<?php

namespace Tests\Feature\Billing;

use Corals\Modules\Payment\Common\Models\Invoice;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Product;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * A Stripe subscription is created at Stripe before the card is charged. With a declined card Stripe
 * leaves it `incomplete`, but the local row used to be `active` anyway, giving access with no payment.
 * Stripe subscriptions now start `pending` (config/payment_stripe.php) and become active when the
 * paid-invoice webhook arrives.
 *
 * The creation call itself needs Stripe; it was exercised in the sandbox. Here: the configuration, and
 * what a pending subscription may and may not do. Generic. Rows are rolled back.
 */
class StripePendingUntilPaidTest extends TestCase
{
    use DatabaseTransactions;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::query()->firstOrFail();
    }

    protected function pendingStripeSubscription(): Subscription
    {
        $product = Product::create(['name' => 'Test product', 'status' => 'active']);
        $plan = Plan::create([
            'name' => 'Test plan',
            'code' => 'stripe-pending-' . uniqid(),
            'price' => 25,
            'product_id' => $product->id,
        ]);

        return Subscription::create([
            'user_id' => $this->user->id,
            'plan_id' => $plan->id,
            'status' => config('payment_stripe.default_subscription_status') ?? 'active',
            'gateway' => 'Stripe',
            'subscription_reference' => 'sub_test_' . uniqid(),
        ]);
    }

    protected function invoice(Subscription $subscription): Invoice
    {
        return Invoice::create([
            'code' => 'in_test_' . uniqid(),
            'currency' => 'usd',
            'description' => 'test',
            'sub_total' => 25,
            'total' => 25,
            'user_id' => $this->user->id,
            'invoicable_id' => $subscription->id,
            'invoicable_type' => Subscription::class,
            'due_date' => now(),
            'invoice_date' => now(),
            'status' => 'pending',
        ]);
    }

    public function test_stripe_subscriptions_start_pending_and_the_rest_of_the_gateway_config_is_intact(): void
    {
        // The package's own settings are merged into config only while the Stripe module is installed.
        if (!DB::table('modules')->where('code', 'corals-payment-stripe')->where('installed', 1)->exists()) {
            $this->markTestSkipped('The Stripe module is not installed; it supplies the package config checked here.');
        }

        $this->assertSame('pending', config('payment_stripe.default_subscription_status'));

        // The app file only adds the status: the package's own settings must still be there.
        $this->assertTrue(config('payment_stripe.require_invoice_creation'));
        $this->assertTrue(config('payment_stripe.support_subscription'));
        $this->assertNotEmpty(config('payment_stripe.events'));
    }

    public function test_an_unpaid_stripe_subscription_is_not_active(): void
    {
        $subscription = $this->pendingStripeSubscription();

        $this->assertSame('pending', $subscription->status);
        $this->assertFalse($subscription->active());
    }

    public function test_a_failed_payment_leaves_it_pending(): void
    {
        $subscription = $this->pendingStripeSubscription();

        $this->invoice($subscription)->update(['status' => 'failed']);

        $this->assertSame('pending', $subscription->fresh()->status);
        $this->assertFalse($subscription->fresh()->active());
    }

    public function test_the_paid_invoice_activates_it_once_with_one_cycle(): void
    {
        $subscription = $this->pendingStripeSubscription();

        $this->invoice($subscription)->markAsPaid();

        $this->assertSame('active', $subscription->fresh()->status);
        $this->assertTrue($subscription->fresh()->active());
        $this->assertSame(1, $subscription->cycles()->count());
    }
}
