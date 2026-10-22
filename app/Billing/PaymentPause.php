<?php

namespace App\Billing;

use Corals\Modules\Subscriptions\Models\Subscription;

/**
 * Marks a subscription that was paused because its payment failed ("past_due" or "unpaid"), so the next
 * paid invoice can be announced as a recovery. Kept in the `properties` column, next to the other keys.
 *
 * Not Subscription::getProperty()/setProperty(): on this model they work on `extras`, which returns
 * defaults of its own and never our key.
 */
class PaymentPause
{
    const KEY = 'payment_paused';

    public static function reason(Subscription $subscription): ?string
    {
        return data_get($subscription->properties, self::KEY);
    }

    public static function mark(Subscription $subscription, string $reason): void
    {
        $properties = $subscription->properties ?? [];
        $properties[self::KEY] = $reason;

        $subscription->properties = $properties;
        $subscription->save();
    }

    public static function clear(Subscription $subscription): void
    {
        $properties = $subscription->properties ?? [];
        unset($properties[self::KEY]);

        $subscription->properties = $properties;
        $subscription->save();
    }
}
