<?php

namespace App\Jobs\Stripe;

use App\Billing\PaymentPause;
use App\Notifications\SubscriptionPaymentFailed;
use Corals\Modules\Payment\Common\Models\WebhookCall;
use Corals\Modules\Payment\Stripe\Exception\StripeWebhookFailed;
use Corals\Modules\Subscriptions\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * customer.subscription.updated: the Stripe package does not handle it. Access follows payment, so:
 *
 *  - `incomplete_expired`: the first payment never succeeded and Stripe gave up. A subscription that is
 *    still `pending` is cancelled; one that is active or already cancelled is left alone.
 *  - `past_due`: a renewal payment failed. An `active` subscription becomes `pending` (no access) until
 *    a retry succeeds; that arrives as invoice.payment_succeeded, which reactivates it (and triggers whatever
 *    a product attaches to a paid invoice). If Stripe gives up, customer.subscription.deleted cancels it.
 *    A cancelled one is never revived.
 *  - `unpaid`: Stripe stopped retrying but keeps the subscription (a dashboard setting). Same as past_due:
 *    paused until an invoice is paid.
 *
 * The user is told once per change: the pause (`past_due`/`unpaid`), the final notice when `unpaid` follows
 * `past_due`, and the cancellation of a first payment that never went through (SubscriptionPaymentFailed).
 * The recovery notice belongs to NotifyPaymentRecovered. Every other status changes nothing.
 * Registered in AppServiceProvider.
 */
class HandleCustomerSubscriptionUpdated implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var WebhookCall */
    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {
        try {
            if ($this->webhookCall->processed) {
                throw StripeWebhookFailed::processedCall($this->webhookCall);
            }

            $object = data_get($this->webhookCall->payload, 'data.object');

            if (!is_array($object) || empty($object['id']) || empty($object['status'])) {
                throw StripeWebhookFailed::invalidStripePayload($this->webhookCall);
            }

            $subscription = Subscription::where('subscription_reference', $object['id'])->first();

            if (!$subscription) {
                throw StripeWebhookFailed::invalidStripeSubscription($this->webhookCall);
            }

            $status = $object['status'];
            $pausedFor = PaymentPause::reason($subscription);

            // Each branch notifies only on a real change, so a repeated event tells nobody twice.
            if ($status === 'incomplete_expired' && $subscription->status === 'pending') {
                $subscription->markAsCancelled();
                $subscription->user->notify(new SubscriptionPaymentFailed($subscription, $status));
            } elseif (in_array($status, ['past_due', 'unpaid'], true) && $subscription->status === 'active') {
                $subscription->setStatus('pending');
                // Remembered so the next paid invoice is announced as a recovery (NotifyPaymentRecovered).
                PaymentPause::mark($subscription, $status);
                $subscription->user->notify(new SubscriptionPaymentFailed($subscription, $status));
            } elseif ($status === 'unpaid' && $subscription->status === 'pending' && $pausedFor === 'past_due') {
                // Paused by the first warning, now Stripe gave up retrying: the final notice.
                PaymentPause::mark($subscription, $status);
                $subscription->user->notify(new SubscriptionPaymentFailed($subscription, $status));
            }

            $this->webhookCall->markAsProcessed();
        } catch (\Exception $exception) {
            log_exception($exception);
            $this->webhookCall->saveException($exception);
            throw $exception;
        }
    }
}
