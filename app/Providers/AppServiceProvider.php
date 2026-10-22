<?php

namespace App\Providers;

use App\Jobs\Stripe\HandleCustomerSubscriptionUpdated;
use App\Listeners\AnnouncePaidInvoice;
use App\Listeners\NotifyPaymentRecovered;
use Corals\Modules\Payment\Common\Events\InvoicePaidEvent;
use Corals\Modules\Payment\Common\Models\Invoice;
use Corals\Modules\Payment\Facades\Webhooks;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

        // The Stripe package ignores customer.subscription.updated. Registered here, one event, rather than
        // copying the package's whole `events` list into config/payment_stripe.php (a shallow merge would
        // replace it and freeze it against package updates).
        Webhooks::registerEvent('stripe.customer.subscription.updated', HandleCustomerSubscriptionUpdated::class);

        // A payment that brings back a subscription paused for non-payment (see that job) is announced.
        Event::listen(InvoicePaidEvent::class, NotifyPaymentRecovered::class);

        // Payments confirmed on the invoices screen are plain updates; announce them like markAsPaid() does.
        Event::listen(InvoicePaidEvent::class, [AnnouncePaidInvoice::class, 'announced']);
        Invoice::updated([AnnouncePaidInvoice::class, 'updated']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
