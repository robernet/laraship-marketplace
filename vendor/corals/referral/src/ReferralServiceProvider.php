<?php

namespace Corals\Modules\Referral;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Modules\Referral\Facades\Referral;
use Corals\Modules\Referral\Hooks\Referral as ReferralHooks;
use Corals\Modules\Referral\Models\ReferralProgram;
use Corals\Modules\Referral\Providers\ReferralAuthServiceProvider;
use Corals\Modules\Referral\Providers\ReferralObserverServiceProvider;
use Corals\Modules\Referral\Providers\ReferralRouteServiceProvider;
use Corals\Settings\Facades\Modules;
use Corals\Settings\Facades\Settings;
use Illuminate\Foundation\AliasLoader;

class ReferralServiceProvider extends BasePackageServiceProvider
{
    /**
     * @var
     */
    protected $defer = true;
    /**
     * @var
     */
    protected $packageCode = 'corals-referral';

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function bootPackage()
    {
        // Load view
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'ReferralProgram');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'ReferralProgram');

        // Load migrations
        //        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->registerHooks();

        $this->registerCustomFieldsModels();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerPackage()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/referral_program.php', 'referral_program');

        $this->app->register(ReferralRouteServiceProvider::class);
        $this->app->register(ReferralAuthServiceProvider::class);
        $this->app->register(ReferralObserverServiceProvider::class);

        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Referral', Referral::class);
        });
    }

    public function registerHooks()
    {
        \Filters::add_filter('corals_middleware', [ReferralHooks::class, 'referrals_middleware'], 11);
        \Actions::add_action('user_registered', [ReferralHooks::class, 'check_registration_referral_programs'], 10);
        \Actions::add_action('post_create_subscription', [ReferralHooks::class, 'check_subscribed_referral_programs'], 11);
        \Actions::add_action('post_order_received', [ReferralHooks::class, 'check_ecommerce_referral_programs'], 11);
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(ReferralProgram::class);
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/referral');
    }
}
