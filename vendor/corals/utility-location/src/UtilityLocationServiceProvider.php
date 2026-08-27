<?php

namespace Corals\Utility\Location;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Settings\Facades\Modules;
use Corals\Settings\Facades\Settings;
use Corals\Utility\Location\Facades\Address;
use Corals\Utility\Location\Models\Location;
use Corals\Utility\Location\Providers\UtilityAuthServiceProvider;
use Corals\Utility\Location\Providers\UtilityRouteServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;

class UtilityLocationServiceProvider extends BasePackageServiceProvider
{
    /**
     * @var
     */
    protected $packageCode = 'corals-utility-location';

    public function bootPackage()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'utility-location');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'utility-location');

        $this->mergeConfigFrom(
            __DIR__ . '/config/utility-location.php',
            'utility-location'
        );
        $this->publishes([
            __DIR__ . '/config/utility-location.php' => config_path('utility-location.php'),
            __DIR__ . '/resources/views' => resource_path('resources/views/vendor/utility-location'),
        ]);

        $this->registerMorphMaps();
        $this->registerCustomFieldsModels();
    }

    public function registerPackage()
    {
        $this->app->register(UtilityAuthServiceProvider::class);
        $this->app->register(UtilityRouteServiceProvider::class);

        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Address', Address::class);
        });
    }

    protected function registerMorphMaps()
    {
        Relation::morphMap([
            'UtilityLocation' => Location::class,
        ]);
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Location::class, 'Location (Utility)');
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/utility-location');
    }
}
