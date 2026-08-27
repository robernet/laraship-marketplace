<?php

namespace Corals\Utility\Webhook;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Settings\Facades\Modules;
use Corals\Utility\Webhook\Facades\Webhooks;
use Corals\Utility\Webhook\Providers\UtilityAuthServiceProvider;
use Corals\Utility\Webhook\Providers\UtilityRouteServiceProvider;
use Illuminate\Foundation\AliasLoader;

class UtilityWebhookServiceProvider extends BasePackageServiceProvider
{
    /**
     * @var
     */
    protected $packageCode = 'corals-utility-webhook';

    public function bootPackage()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'utility-webhook');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'utility-webhook');

        $this->mergeConfigFrom(
            __DIR__ . '/config/utility-webhook.php',
            'utility-webhook'
        );
        $this->publishes([
            __DIR__ . '/config/utility-webhook.php' => config_path('utility-webhook.php'),
            __DIR__ . '/resources/views' => resource_path('resources/views/vendor/utility-webhook'),
        ]);
    }

    public function registerPackage()
    {
        $this->app->register(UtilityAuthServiceProvider::class);
        $this->app->register(UtilityRouteServiceProvider::class);

        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Webhooks', Webhooks::class);
        });
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/utility-webhook');
    }
}
