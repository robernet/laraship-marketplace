<?php

namespace Corals\Utility\Rating;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Settings\Facades\Modules;
use Corals\User\Communication\Facades\CoralsNotification;
use Corals\Utility\Rating\Classes\RatingManager;
use Corals\Utility\Rating\Commands\RatingCalculator;
use Corals\Utility\Rating\Models\Rating;
use Corals\Utility\Rating\Notifications\RateCreated;
use Corals\Utility\Rating\Notifications\RatingToggleStatus;
use Corals\Utility\Rating\Providers\UtilityAuthServiceProvider;
use Corals\Utility\Rating\Providers\UtilityRouteServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;

class UtilityRatingServiceProvider extends BasePackageServiceProvider
{
    /**
     * @var
     */
    protected $packageCode = 'corals-utility-rating';

    public function bootPackage()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'utility-rating');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'utility-rating');

        $this->mergeConfigFrom(
            __DIR__ . '/config/utility-rating.php',
            'utility-rating'
        );
        $this->publishes([
            __DIR__ . '/config/utility-rating.php' => config_path('utility-rating.php'),
            __DIR__ . '/resources/views' => resource_path('resources/views/vendor/utility-rating'),
        ]);

        $this->registerMorphMaps();
        $this->registerCommand();

        $this->addEvents();
    }

    public function registerPackage()
    {
        $this->app->register(UtilityAuthServiceProvider::class);
        $this->app->register(UtilityRouteServiceProvider::class);

        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('RatingManager', RatingManager::class);
        });
    }

    protected function registerCommand()
    {
        $this->commands(RatingCalculator::class);
    }

    protected function registerMorphMaps()
    {
        Relation::morphMap([
            'UtilityRating' => Rating::class,
        ]);
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/utility-rating');
    }

    protected function addEvents()
    {
        CoralsNotification::addEvent(
            'notifications.rate.rate_created',
            'Rate Created',
            RateCreated::class
        );

        CoralsNotification::addEvent(
            'notifications.rate.rate_toggle_status',
            'Rate Toggle Status',
            RatingToggleStatus::class
        );
    }
}
