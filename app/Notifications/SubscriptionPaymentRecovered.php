<?php

namespace App\Notifications;

use Corals\Modules\Subscriptions\Models\Subscription;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * The payment that had paused a subscription went through and the subscription is active again.
 * Text in resources/lang/{en,es}/billing.php; see SubscriptionPaymentFailed for the locale and the
 * choice of a plain Laravel notification.
 */
class SubscriptionPaymentRecovered extends Notification
{
    public function __construct(public Subscription $subscription)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject($this->text('subject'))
            ->line($this->text('message'))
            ->action(trans('billing.recovered.action'), url('dashboard'));
    }

    public function toArray($notifiable): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'plan' => $this->subscription->plan->name,
            'message' => $this->text('message'),
        ];
    }

    protected function text(string $part): string
    {
        return trans("billing.recovered.{$part}", ['plan' => $this->subscription->plan->name]);
    }
}
