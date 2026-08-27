<?php

namespace Corals\Utility\ListOfValue;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Settings\Facades\Modules;
use Corals\Utility\ListOfValue\Facades\ListOfValues;
use Corals\Utility\ListOfValue\Providers\UtilityAuthServiceProvider;
use Corals\Utility\ListOfValue\Providers\UtilityRouteServiceProvider;
use Illuminate\Foundation\AliasLoader;

class UtilityListOfValueServiceProvider extends BasePackageServiceProvider
{
    /**
     * @var
     */
    protected $packageCode = 'corals-utility-listOfValue';

    public function bootPackage()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'utility-lov');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'utility-lov');

        $this->mergeConfigFrom(
            __DIR__ . '/config/utility-lov.php',
            'utility-lov'
        );
        $this->publishes([
            __DIR__ . '/config/utility-lov.php' => config_path('utility-lov.php'),
            __DIR__ . '/resources/views' => resource_path('resources/views/vendor/utility-lov'),
        ]);
    }

    public function registerPackage()
    {
        $this->app->register(UtilityAuthServiceProvider::class);
        $this->app->register(UtilityRouteServiceProvider::class);

        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('ListOfValues', ListOfValues::class);
        });
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/utility-lov');
    }
}
