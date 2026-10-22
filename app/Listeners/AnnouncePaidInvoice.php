<?php

namespace App\Listeners;

use Corals\Modules\Payment\Common\Events\InvoicePaidEvent;
use Corals\Modules\Payment\Common\Models\Invoice;
use Corals\Modules\Subscriptions\Models\Subscription;

/**
 * Corals only announces a payment (InvoicePaidEvent: activate the subscription, grant whatever the product
 * attaches to a payment) when code calls Invoice::markAsPaid(). The invoices screen (bulk action "paid" and
 * the edit form) sets the status with a plain update, so a Cash payment confirmed there paid nothing out.
 *
 * This announces those updates, for subscription invoices only. markAsPaid() fires the event right
 * before it saves, so the event it fired is remembered and not announced a second time.
 * Registered in AppServiceProvider.
 */
class AnnouncePaidInvoice
{
    /** @var array<int, true> invoice ids whose payment markAsPaid() has just announced */
    protected static array $announced = [];

    public function announced(InvoicePaidEvent $event): void
    {
        self::$announced[$event->invoice->id] = true;
    }

    public function updated(Invoice $invoice): void
    {
        if (!$invoice->wasChanged('status') || $invoice->status !== 'paid') {
            return;
        }

        if (isset(self::$announced[$invoice->id])) {
            unset(self::$announced[$invoice->id]);

            return;
        }

        if ($invoice->invoicable instanceof Subscription) {
            InvoicePaidEvent::dispatch($invoice);

            // announced() also heard the event sent just above; nothing is pending to be skipped.
            unset(self::$announced[$invoice->id]);
        }
    }
}
