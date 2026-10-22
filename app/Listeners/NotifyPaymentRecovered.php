<?php

namespace App\Listeners;

use App\Billing\PaymentPause;
use App\Notifications\SubscriptionPaymentRecovered;
use Corals\Modules\Payment\Common\Events\InvoicePaidEvent;
use Corals\Modules\Subscriptions\Models\Subscription;

/**
 * Tells the user when a payment brings back a subscription that had been paused for non-payment.
 * HandleCustomerSubscriptionUpdated marks the pause (App\Billing\PaymentPause); the next paid
 * invoice clears it and sends the notice, so a first payment or an ordinary renewal never does.
 */
class NotifyPaymentRecovered
{
    public function handle(InvoicePaidEvent $event): void
    {
        $subscription = $event->invoice->invoicable;

        if (!($subscription instanceof Subscription) || !PaymentPause::reason($subscription)) {
            return;
        }

        PaymentPause::clear($subscription);

        $subscription->user->notify(new SubscriptionPaymentRecovered($subscription));
    }
}
