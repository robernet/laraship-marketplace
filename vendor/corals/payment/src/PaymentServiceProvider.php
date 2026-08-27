<?php

namespace Corals\Modules\Payment;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Modules\Payment\Classes\Currency;
use Corals\Modules\Payment\Common\Console\Cleanup;
use Corals\Modules\Payment\Common\Console\Manage;
use Corals\Modules\Payment\Common\Console\Update;
use Corals\Modules\Payment\Common\Hooks\Payment as PaymentHooks;
use Corals\Modules\Payment\Common\Notifications\InvoiceNotification;
use Corals\Modules\Payment\Providers\PaymentAuthServiceProvider;
use Corals\Modules\Payment\Providers\PaymentObserverServiceProvider;
use Corals\Modules\Payment\Providers\PaymentRouteServiceProvider;
use Corals\Settings\Facades\Modules;
use Corals\User\Communication\Facades\CoralsNotification;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\DB;

class PaymentServiceProvider extends BasePackageServiceProvider
{
    /**
     * @var
     */
    protected $defer = false;
    /**
     * @var
     */
    protected $packageCode = 'corals-payment';

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function bootPackage()
    {
        // Load view
        $this->loadViewsFrom(__DIR__ . '/Common/resources/views', 'Payment');

        //load translation
        $this->loadTranslationsFrom(__DIR__ . '/Common/resources/lang', 'Payment');
        $this->mergeConfigFrom(__DIR__ . '/Common/config/common.php', 'payment_common');

        $this->mergeConfigFrom(__DIR__ . '/Common/config/currency.php', 'currency');

        try {
            $payment_modules = $this->getModules()
                ->where('type', 'payment')
                ->where('enabled', true)
                ->where('installed', true)
                ->sortBy('load_order');

            foreach ($payment_modules as $payment_module) {
                if ($payment_module->provider) {
                    $this->app->register($payment_module->provider);
                }
                $configFilesPath = base_path() . '/vendor/corals/' . $payment_module->folder . '/src/config';

                $configFiles = \Illuminate\Support\Facades\File::allFiles($configFilesPath);

                foreach ($configFiles as $file) {
                    $gateway = $file->getBasename('.php');

                    $configKey = 'payment_' . $gateway;

                    $this->mergeConfigFrom($configFilesPath . '/' . $file->getBasename(), $configKey);

                    $gateway_name = config($configKey . '.name');


                    $this->loadViewsFrom(base_path() . '/vendor/corals' . "/{$payment_module->folder}/src/resources/views", $gateway_name);

                    $this->loadTranslationsFrom(base_path() . '/vendor/corals'  . "/{$payment_module->folder}/src/resources/lang", $gateway_name);

                    //register gateways webhooks events
                    if ($events = config($configKey . '.events')) {
                        foreach ($events as $eventName => $jobClass) {
                            \Corals\Modules\Payment\Facades\Webhooks::registerEvent(
                                "{$gateway}.{$eventName}",
                                $jobClass
                            );
                        }
                    }
                }
            }

            $this->registerWidgets();
            $this->registerHooks();
            //
            if ($this->app->runningInConsole()) {
                $this->registerCommands();
            }
            $this->addEvents();
        } catch (\Exception $exception) {
            if (isset($payment_module)) {
                \DB::table('modules')->where('code', $payment_module->code)
                    ->update([
                        'enabled' => 0,
                        'notes' => $exception->getMessage()
                    ]);
                flash(trans(
                    'Payment::exception.payment_service.error_load_module',
                    ['code' => $payment_module->code]
                ))->warning();
            }
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerPackage()
    {
        $this->app->singleton('Webhooks', function ($app) {
            return new Webhooks();
        });

        $this->app->singleton('currency', function ($app) {
            return new Currency(
                $app->config->get('currency', []),
                $app['cache']
            );
        });


        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Payments', \Corals\Modules\Payment\Facades\Payments::class);
            $loader->alias('Currency', \Corals\Modules\Payment\Facades\Currency::class);
        });

        $this->app->register(PaymentRouteServiceProvider::class);
        $this->app->register(PaymentObserverServiceProvider::class);
        $this->app->register(PaymentAuthServiceProvider::class);

        $this->app['router']->pushMiddlewareToGroup(
            'web',
            \Corals\Modules\Payment\Common\Middleware\CurrencyMiddleware::class
        );
    }

    public function registerWidgets()
    {
        \Shortcode::addWidget('revenue', \Corals\Modules\Payment\Common\Widgets\RevenueWidget::class);
        \Shortcode::addWidget('monthly_revenue', \Corals\Modules\Payment\Common\Widgets\MonthlyRevenueWidget::class);
    }

    public function registerHooks()
    {
        \Actions::add_action('show_navbar', [PaymentHooks::class, 'show_nav_currencies_menu'], 9);

        \Actions::add_action('post_display_frontend_menu', [PaymentHooks::class, 'show_available_currencies_menu'], 10);
    }

    /**
     * Register currency commands.
     *
     * @return void
     */
    public function registerCommands()
    {
        $this->commands([
            Cleanup::class,
            Manage::class,
            Update::class,
        ]);
    }

    public function provides()
    {
        return [
            'Webhooks',
            'currency',
        ];
    }

    public function addEvents()
    {
        CoralsNotification::addEvent('notifications.invoice.send_invoice', 'Invoice', InvoiceNotification::class);
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/payment');
    }
}
