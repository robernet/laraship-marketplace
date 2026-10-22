<?php

namespace Tests\Feature\Billing;

use Corals\Modules\Payment\Common\Models\Invoice;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Product;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * An invoice marked paid on the invoices screen (bulk action or edit form) is a plain status update in
 * Corals: it fires no payment event, so a Cash payment confirmed there left the subscription pending.
 * App\Listeners\AnnouncePaidInvoice makes it behave like the "mark invoice as paid and active" action.
 *
 * Generic: nothing here depends on a product module. Rows are rolled back.
 */
class InvoiceScreenPaymentTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::query()->orderBy('id')->firstOrFail();
    }

    protected function subscription(string $status = 'pending'): Subscription
    {
        $product = Product::create(['name' => 'Test product', 'status' => 'active']);
        $plan = Plan::create([
            'name' => 'Test plan',
            'code' => 'screen-test-' . uniqid(),
            'price' => 49,
            'product_id' => $product->id,
        ]);

        return Subscription::create([
            'user_id' => $this->admin->id,
            'plan_id' => $plan->id,
            'status' => $status,
            'gateway' => 'Cash',
            'subscription_reference' => 'screen_' . uniqid(),
        ]);
    }

    protected function invoice(object $invoicable, string $type = Subscription::class): Invoice
    {
        return Invoice::create([
            'code' => 'in_screen_' . uniqid(),
            'currency' => 'usd',
            'description' => 'test',
            'sub_total' => 49,
            'total' => 49,
            'user_id' => $this->admin->id,
            'invoicable_id' => $invoicable->id,
            'invoicable_type' => $type,
            'due_date' => now(),
            'invoice_date' => now(),
            'status' => 'pending',
        ]);
    }

    public function test_paying_the_invoice_of_a_pending_subscription_on_the_screen_activates_it(): void
    {
        $subscription = $this->subscription('pending');
        $invoice = $this->invoice($subscription);

        $invoice->update(['status' => 'paid']);

        $this->assertSame('active', $subscription->fresh()->status);
        $this->assertSame(1, $subscription->cycles()->count());
    }

    public function test_the_bulk_action_of_the_invoices_screen_does_the_same(): void
    {
        $subscription = $this->subscription('pending');
        $invoice = $this->invoice($subscription);

        $this->actingAs($this->admin)->post('/invoices/bulk-action', [
            'action' => 'paid',
            'selection' => json_encode([$invoice->hashed_id]),
        ])->assertOk();

        $this->assertSame('paid', $invoice->fresh()->status);
        $this->assertSame('active', $subscription->fresh()->status);
    }

    public function test_a_renewal_paid_on_the_screen_extends_the_subscription(): void
    {
        $subscription = $this->subscription('pending');
        $this->invoice($subscription)->update(['status' => 'paid']);
        $cycles = $subscription->cycles()->count();

        $this->invoice($subscription)->update(['status' => 'paid']);

        $this->assertSame($cycles + 1, $subscription->cycles()->count());
    }

    public function test_the_action_that_already_worked_is_not_doubled(): void
    {
        // markAsPaid() already announces the payment; the screen hook must stay out of its way.
        $subscription = $this->subscription('pending');

        $this->invoice($subscription)->markAsPaid();

        $this->assertSame('active', $subscription->fresh()->status);
        $this->assertSame(1, $subscription->cycles()->count());
    }

    public function test_editing_a_paid_invoice_does_not_announce_the_payment_again(): void
    {
        $subscription = $this->subscription('pending');
        $invoice = $this->invoice($subscription);
        $invoice->update(['status' => 'paid']);
        $cycles = $subscription->cycles()->count();

        $invoice->fresh()->update(['description' => 'edited']);

        $this->assertSame($cycles, $subscription->cycles()->count());
    }

    public function test_failing_or_cancelling_an_invoice_activates_nothing(): void
    {
        $subscription = $this->subscription('pending');

        $this->invoice($subscription)->update(['status' => 'failed']);
        $this->invoice($subscription)->update(['status' => 'cancelled']);

        $this->assertSame('pending', $subscription->fresh()->status);
        $this->assertSame(0, $subscription->cycles()->count());
    }

    public function test_an_invoice_that_is_not_a_subscriptions_is_left_alone(): void
    {
        $subscription = $this->subscription('pending');
        $invoice = $this->invoice($this->admin, User::class);

        $invoice->update(['status' => 'paid']);

        $this->assertSame('pending', $subscription->fresh()->status);
    }
}
