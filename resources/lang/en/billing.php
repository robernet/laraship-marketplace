<?php

// Notices sent when a subscription payment fails or recovers (App\Notifications\SubscriptionPayment*).
// Keep resources/lang/es/billing.php in step: a test compares the keys of both.
return [
    'payment_failed' => [
        // First warning: a renewal could not be charged and access is paused; the gateway will retry.
        'past_due' => [
            'subject' => 'We could not charge your :plan subscription',
            'message' => 'We could not charge the renewal of your :plan subscription. Access is paused until the payment goes through, and we will try again in the next few days.',
        ],
        // Final notice: the gateway stopped retrying; still paused.
        'unpaid' => [
            'subject' => 'We suspended your :plan subscription',
            'message' => 'After several attempts we could not charge your :plan subscription, so we suspended it.',
        ],
        // The first payment never went through; the subscription was cancelled.
        'incomplete_expired' => [
            'subject' => 'Your :plan subscription was not completed',
            'message' => 'We could not charge the initial payment of your :plan subscription, so we cancelled it.',
        ],
    ],
    'update_payment' => 'To reactivate it, update your payment method.',
    'resubscribe' => 'If you still want it, subscribe again with another payment method.',
    'action_update_payment' => 'Update payment method',
    'action_resubscribe' => 'Subscribe again',
    'recovered' => [
        'subject' => 'Your :plan subscription is active again',
        'message' => 'We charged your payment and your :plan subscription is active again. Thank you.',
        'action' => 'Go to my account',
    ],
];
