<?php

namespace Tests\Feature\Billing;

use App\Jobs\Stripe\HandleCustomerSubscriptionUpdated;
use App\Notifications\SubscriptionPaymentFailed;
use App\Notifications\SubscriptionPaymentRecovered;
use Corals\Modules\Payment\Common\Models\Invoice;
use Corals\Modules\Payment\Common\Models\WebhookCall;
use Corals\Modules\Payment\Facades\Webhooks;
use Corals\Modules\Payment\Stripe\Exception\StripeWebhookFailed;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Product;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Stripe tells us a subscription changed with customer.subscription.updated. Access follows payment:
 *  - `incomplete_expired`: the first payment never succeeded; a still-pending subscription is cancelled;
 *  - `past_due` / `unpaid`: a renewal failed; an active subscription is paused until a payment succeeds;
 *  - anything else changes nothing.
 * The user is told once per change, and when a paused subscription is back.
 *
 * Generic: no product module is involved. Needs the Stripe payment package (its exception class and its
 * events registered, which happens when the Stripe module is installed). Rows are rolled back.
 */
class StripeSubscriptionUpdatedTest extends TestCase
{
    use DatabaseTransactions;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::query()->firstOrFail();
    }

    protected function subscription(string $status): Subscription
    {
        $product = Product::create(['name' => 'Test product', 'status' => 'active']);
        $plan = Plan::create([
            'name' => 'Test plan',
            'code' => 'sub-updated-' . uniqid(),
            'price' => 25,
            'product_id' => $product->id,
        ]);

        return Subscription::create([
            'user_id' => $this->user->id,
            'plan_id' => $plan->id,
            'status' => $status,
            'gateway' => 'Stripe',
            'subscription_reference' => 'sub_test_' . uniqid(),
        ]);
    }

    protected function webhookCall(string $reference, string $stripeStatus): WebhookCall
    {
        return WebhookCall::create([
            'event_name' => 'stripe.customer.subscription.updated',
            'gateway' => 'Stripe',
            'payload' => ['type' => 'customer.subscription.updated', 'data' => ['object' => ['id' => $reference, 'status' => $stripeStatus]]],
        ]);
    }

    protected function handle(WebhookCall $call): void
    {
        (new HandleCustomerSubscriptionUpdated($call))->handle();
    }

    protected function payRenewal(Subscription $subscription): void
    {
        Invoice::create([
            'code' => 'in_notice_' . uniqid(), 'currency' => 'usd', 'description' => 'renewal', 'sub_total' => 25, 'total' => 25,
            'user_id' => $this->user->id, 'invoicable_id' => $subscription->id, 'invoicable_type' => Subscription::class,
            'due_date' => now(), 'invoice_date' => now(), 'status' => 'pending',
        ])->markAsPaid();
    }

    public function test_the_event_is_registered_next_to_the_packages_own(): void
    {
        // The package registers its events only while the Stripe module is installed.
        if (!DB::table('modules')->where('code', 'corals-payment-stripe')->where('installed', 1)->exists()) {
            $this->markTestSkipped('The Stripe module is not installed; it registers the package events checked here.');
        }

        $this->assertSame(HandleCustomerSubscriptionUpdated::class, Webhooks::getEventJob('stripe.customer.subscription.updated'));
        $this->assertNotNull(Webhooks::getEventJob('stripe.invoice.payment_succeeded'));
        $this->assertNotNull(Webhooks::getEventJob('stripe.customer.subscription.deleted'));
    }

    public function test_incomplete_expired_cancels_a_subscription_that_was_never_paid(): void
    {
        $subscription = $this->subscription('pending');
        $call = $this->webhookCall($subscription->subscription_reference, 'incomplete_expired');

        $this->handle($call);

        $fresh = $subscription->fresh();
        $this->assertSame('canceled', $fresh->status);
        $this->assertNotNull($fresh->ends_at);
        $this->assertTrue((bool)$call->fresh()->processed);
    }

    public function test_incomplete_expired_never_cancels_a_subscription_that_is_paid(): void
    {
        $subscription = $this->subscription('active');

        $this->handle($this->webhookCall($subscription->subscription_reference, 'incomplete_expired'));

        $this->assertSame('active', $subscription->fresh()->status);
    }

    public function test_past_due_pauses_an_active_subscription(): void
    {
        $subscription = $this->subscription('active');
        $call = $this->webhookCall($subscription->subscription_reference, 'past_due');

        $this->handle($call);

        $this->assertSame('pending', $subscription->fresh()->status);
        $this->assertFalse($subscription->fresh()->active());
        $this->assertTrue((bool)$call->fresh()->processed);
    }

    public function test_a_successful_retry_brings_it_back(): void
    {
        $subscription = $this->subscription('active');
        $this->handle($this->webhookCall($subscription->subscription_reference, 'past_due'));

        // Stripe's retry works: invoice.payment_succeeded marks the renewal invoice paid.
        $this->payRenewal($subscription);

        $this->assertSame('active', $subscription->fresh()->status);
        $this->assertTrue($subscription->fresh()->active());
    }

    public function test_past_due_leaves_alone_what_is_not_active(): void
    {
        $pending = $this->subscription('pending');
        $canceled = $this->subscription('canceled');

        $this->handle($this->webhookCall($pending->subscription_reference, 'past_due'));
        $this->handle($this->webhookCall($canceled->subscription_reference, 'past_due'));

        $this->assertSame('pending', $pending->fresh()->status);
        $this->assertSame('canceled', $canceled->fresh()->status, 'A cancelled subscription must never be revived.');
    }

    public function test_unpaid_pauses_an_active_subscription_like_past_due(): void
    {
        $subscription = $this->subscription('active');

        $this->handle($this->webhookCall($subscription->subscription_reference, 'unpaid'));

        $this->assertSame('pending', $subscription->fresh()->status);
    }

    public function test_unpaid_never_revives_a_cancelled_subscription(): void
    {
        $canceled = $this->subscription('canceled');

        $this->handle($this->webhookCall($canceled->subscription_reference, 'unpaid'));

        $this->assertSame('canceled', $canceled->fresh()->status);
    }

    public function test_every_other_status_is_ignored_but_the_call_is_marked_processed(): void
    {
        foreach (['active', 'trialing', 'incomplete', 'canceled', 'paused'] as $status) {
            $subscription = $this->subscription('active');
            $call = $this->webhookCall($subscription->subscription_reference, $status);

            $this->handle($call);

            $this->assertSame('active', $subscription->fresh()->status, $status);
            $this->assertTrue((bool)$call->fresh()->processed, $status);
        }
    }

    public function test_the_user_is_told_when_the_subscription_is_paused(): void
    {
        Notification::fake();
        $subscription = $this->subscription('active');

        $this->handle($this->webhookCall($subscription->subscription_reference, 'past_due'));

        Notification::assertSentTo($this->user, SubscriptionPaymentFailed::class, function ($notification, $channels) use ($subscription) {
            return $notification->subscription->is($subscription)
                && $notification->stripeStatus === 'past_due'
                && $channels === ['mail', 'database'];
        });
        Notification::assertCount(1);
    }

    public function test_unpaid_sends_the_final_notice(): void
    {
        Notification::fake();
        $subscription = $this->subscription('active');

        $this->handle($this->webhookCall($subscription->subscription_reference, 'unpaid'));

        Notification::assertSentTo($this->user, SubscriptionPaymentFailed::class, fn($n) => $n->stripeStatus === 'unpaid');
    }

    public function test_the_notice_names_the_plan_and_says_what_to_do_in_english(): void
    {
        app()->setLocale('en');
        $subscription = $this->subscription('active');

        $mail = (new SubscriptionPaymentFailed($subscription, 'past_due'))->toMail($this->user);
        $text = $mail->subject . ' ' . implode(' ', $mail->introLines) . ' ' . $mail->actionText;

        $this->assertStringContainsString($subscription->plan->name, $text);
        $this->assertStringContainsString('We could not charge', $text);
        $this->assertStringContainsString('update your payment method', $text);
        $this->assertStringNotContainsString('billing.', $text, 'A missing translation shows its key.');
    }

    public function test_both_languages_have_the_same_keys_and_the_same_placeholders(): void
    {
        $en = Arr::dot(require resource_path('lang/en/billing.php'));
        $es = Arr::dot(require resource_path('lang/es/billing.php'));

        $this->assertSame(array_keys($en), array_keys($es));

        foreach ($en as $key => $text) {
            preg_match_all('/:\w+/', $text, $inEn);
            preg_match_all('/:\w+/', $es[$key], $inEs);
            $this->assertSame($inEn[0], $inEs[0], "Placeholders differ in billing.$key");
            $this->assertNotSame('', trim($es[$key]), "billing.$key is empty in es");
        }
    }

    public function test_every_status_has_a_translated_notice_in_both_languages(): void
    {
        $subscription = $this->subscription('active');

        foreach (['en', 'es'] as $locale) {
            app()->setLocale($locale);
            foreach (['past_due', 'unpaid', 'incomplete_expired'] as $status) {
                $mail = (new SubscriptionPaymentFailed($subscription, $status))->toMail($this->user);
                $text = $mail->subject . ' ' . implode(' ', $mail->introLines) . ' ' . $mail->actionText;

                $this->assertStringNotContainsString('billing.', $text, "$locale/$status");
                $this->assertStringNotContainsString(':plan', $text, "$locale/$status");
                $this->assertStringContainsString($subscription->plan->name, $text, "$locale/$status");
            }
            $recovered = (new SubscriptionPaymentRecovered($subscription))->toMail($this->user);
            $this->assertStringNotContainsString('billing.', $recovered->subject . implode('', $recovered->introLines) . $recovered->actionText, "$locale/recovered");
        }
    }

    public function test_the_notice_names_the_plan_and_says_what_to_do_in_spanish(): void
    {
        app()->setLocale('es');
        $subscription = $this->subscription('active');

        $mail = (new SubscriptionPaymentFailed($subscription, 'past_due'))->toMail($this->user);
        $text = $mail->subject . ' ' . implode(' ', $mail->introLines) . ' ' . $mail->actionText . ' ' . $mail->actionUrl;

        $this->assertStringContainsString($subscription->plan->name, $text);
        $this->assertStringContainsString('método de pago', $text);
        $this->assertStringContainsString('subscriptions/payment-configuration', $text);
        // The database copy carries the same facts for the in-app list.
        $data = (new SubscriptionPaymentFailed($subscription, 'past_due'))->toArray($this->user);
        $this->assertSame($subscription->id, $data['subscription_id']);
        $this->assertSame('past_due', $data['stripe_status']);
    }

    public function test_nobody_is_told_when_nothing_changed(): void
    {
        Notification::fake();
        $pending = $this->subscription('pending');
        $canceled = $this->subscription('canceled');
        $active = $this->subscription('active');

        $this->handle($this->webhookCall($pending->subscription_reference, 'past_due'));
        $this->handle($this->webhookCall($canceled->subscription_reference, 'past_due'));
        $this->handle($this->webhookCall($active->subscription_reference, 'active'));
        $this->handle($this->webhookCall($active->subscription_reference, 'incomplete_expired'));

        Notification::assertNothingSent();
    }

    public function test_the_user_is_told_when_an_unpaid_first_payment_cancels_the_subscription(): void
    {
        Notification::fake();
        $subscription = $this->subscription('pending');

        $this->handle($this->webhookCall($subscription->subscription_reference, 'incomplete_expired'));

        Notification::assertSentTo($this->user, SubscriptionPaymentFailed::class, fn($n) => $n->stripeStatus === 'incomplete_expired');
        Notification::assertCount(1);
    }

    public function test_the_mail_for_a_cancelled_first_payment_invites_to_subscribe_again(): void
    {
        app()->setLocale('es');
        $subscription = $this->subscription('canceled');

        $mail = (new SubscriptionPaymentFailed($subscription, 'incomplete_expired'))->toMail($this->user);
        $text = $mail->subject . ' ' . implode(' ', $mail->introLines) . ' ' . $mail->actionText . ' ' . $mail->actionUrl;

        $this->assertStringContainsString('pago inicial', $text);
        $this->assertStringContainsString('subscriptions/select', $text);
    }

    public function test_unpaid_after_past_due_sends_the_final_notice_once(): void
    {
        Notification::fake();
        $subscription = $this->subscription('active');

        $this->handle($this->webhookCall($subscription->subscription_reference, 'past_due'));
        $this->handle($this->webhookCall($subscription->subscription_reference, 'unpaid'));
        $this->handle($this->webhookCall($subscription->subscription_reference, 'unpaid'));

        Notification::assertSentToTimes($this->user, SubscriptionPaymentFailed::class, 2);
        Notification::assertSentTo($this->user, SubscriptionPaymentFailed::class, fn($n) => $n->stripeStatus === 'past_due');
        Notification::assertSentTo($this->user, SubscriptionPaymentFailed::class, fn($n) => $n->stripeStatus === 'unpaid');
    }

    public function test_the_user_is_told_when_a_paused_subscription_is_back(): void
    {
        $subscription = $this->subscription('active');
        $this->handle($this->webhookCall($subscription->subscription_reference, 'past_due'));
        Notification::fake();

        $this->payRenewal($subscription);

        Notification::assertSentTo($this->user, SubscriptionPaymentRecovered::class, fn($n) => $n->subscription->is($subscription));
        Notification::assertCount(1);
        $this->assertSame('active', $subscription->fresh()->status);
    }

    public function test_the_recovery_notice_is_sent_once_and_never_for_a_first_payment(): void
    {
        $paused = $this->subscription('active');
        $this->handle($this->webhookCall($paused->subscription_reference, 'past_due'));
        $fresh = $this->subscription('pending');
        Notification::fake();

        $this->payRenewal($paused);
        $this->payRenewal($paused);   // the next renewals are plain payments
        $this->payRenewal($fresh);    // a first payment is not a recovery

        Notification::assertSentToTimes($this->user, SubscriptionPaymentRecovered::class, 1);
    }

    public function test_recovery_after_the_final_notice_is_also_announced(): void
    {
        $subscription = $this->subscription('active');
        $this->handle($this->webhookCall($subscription->subscription_reference, 'past_due'));
        $this->handle($this->webhookCall($subscription->subscription_reference, 'unpaid'));
        Notification::fake();

        $this->payRenewal($subscription);

        Notification::assertSentTo($this->user, SubscriptionPaymentRecovered::class);
    }

    public function test_the_recovery_mail_says_it_is_active_again(): void
    {
        app()->setLocale('es');
        $subscription = $this->subscription('active');

        $mail = (new SubscriptionPaymentRecovered($subscription))->toMail($this->user);
        $text = $mail->subject . ' ' . implode(' ', $mail->introLines) . ' ' . $mail->actionUrl;

        $this->assertStringContainsString('activa de nuevo', $text);
        $this->assertStringContainsString($subscription->plan->name, $text);
        $this->assertSame($subscription->id, (new SubscriptionPaymentRecovered($subscription))->toArray($this->user)['subscription_id']);
    }

    public function test_the_same_event_twice_notifies_once(): void
    {
        Notification::fake();
        $subscription = $this->subscription('active');

        $this->handle($this->webhookCall($subscription->subscription_reference, 'past_due'));
        $this->handle($this->webhookCall($subscription->subscription_reference, 'past_due'));

        Notification::assertCount(1);
    }

    public function test_the_same_event_twice_changes_nothing_the_second_time(): void
    {
        $subscription = $this->subscription('active');

        $this->handle($this->webhookCall($subscription->subscription_reference, 'past_due'));
        $this->handle($this->webhookCall($subscription->subscription_reference, 'past_due'));

        $this->assertSame('pending', $subscription->fresh()->status);
    }

    public function test_an_unknown_subscription_fails_loudly_and_stays_unprocessed(): void
    {
        $call = $this->webhookCall('sub_does_not_exist', 'past_due');

        try {
            $this->handle($call);
            $this->fail('Expected StripeWebhookFailed.');
        } catch (StripeWebhookFailed) {
        }

        $this->assertFalse((bool)$call->fresh()->processed);
        $this->assertNotNull($call->fresh()->exception);
    }

    public function test_a_payload_without_a_subscription_object_fails_loudly(): void
    {
        $call = WebhookCall::create(['event_name' => 'stripe.customer.subscription.updated', 'gateway' => 'Stripe', 'payload' => ['type' => 'x']]);

        $this->expectException(StripeWebhookFailed::class);

        $this->handle($call);
    }
}
