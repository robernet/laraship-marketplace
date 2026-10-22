<?php

namespace App\Notifications;

use Corals\Modules\Subscriptions\Models\Subscription;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Tells a subscriber that a payment failed and what happened to the subscription:
 *  - `past_due`: a renewal could not be charged, access is paused, the gateway will retry (first warning);
 *  - `unpaid`: the gateway stopped retrying, still paused (final notice);
 *  - `incomplete_expired`: the first payment never went through, the subscription was cancelled.
 *
 * The text lives in resources/lang/{en,es}/billing.php and comes out in the application's current locale.
 * A webhook has no session, so that is `config('app.locale')`.
 *
 * shortcut: a plain Laravel notification instead of Corals' notification templates, which need a row in
 * the database per event. Move it there if the wording must be editable from the admin.
 */
class SubscriptionPaymentFailed extends Notification
{
    const STATUSES = ['past_due', 'unpaid', 'incomplete_expired'];

    public function __construct(public Subscription $subscription, public string $stripeStatus)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $cancelled = $this->status() === 'incomplete_expired';

        return (new MailMessage())
            ->subject($this->text('subject'))
            ->line($this->text('message'))
            ->line(trans($cancelled ? 'billing.resubscribe' : 'billing.update_payment'))
            ->action(
                trans($cancelled ? 'billing.action_resubscribe' : 'billing.action_update_payment'),
                url($cancelled ? 'subscriptions/select' : 'subscriptions/payment-configuration')
            );
    }

    public function toArray($notifiable): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'plan' => $this->subscription->plan->name,
            'stripe_status' => $this->stripeStatus,
            'message' => $this->text('message'),
        ];
    }

    /** An unexpected status reads as the first warning rather than showing a missing translation key. */
    protected function status(): string
    {
        return in_array($this->stripeStatus, self::STATUSES, true) ? $this->stripeStatus : 'past_due';
    }

    protected function text(string $part): string
    {
        return trans("billing.payment_failed.{$this->status()}.{$part}", ['plan' => $this->subscription->plan->name]);
    }
}
