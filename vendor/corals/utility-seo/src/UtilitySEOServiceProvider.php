<?php

namespace Corals\Utility\SEO;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Settings\Facades\Modules;
use Corals\Utility\SEO\Facades\SEOItems;
use Corals\Utility\SEO\Models\SEOItem;
use Corals\Utility\SEO\Providers\UtilityAuthServiceProvider;
use Corals\Utility\SEO\Providers\UtilityRouteServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;

class UtilitySEOServiceProvider extends BasePackageServiceProvider
{
    /**
     * @var
     */
    protected $packageCode = 'corals-utility-seo';

    public function bootPackage()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'utility-seo');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'utility-seo');

        $this->mergeConfigFrom(
            __DIR__ . '/config/utility-seo.php',
            'utility-seo'
        );
        $this->publishes([
            __DIR__ . '/config/utility-seo.php' => config_path('utility-seo.php'),
            __DIR__ . '/resources/views' => resource_path('resources/views/vendor/utility-seo'),
        ]);

        $this->registerMorphMaps();
    }

    public function registerPackage()
    {
        $this->app->register(UtilityAuthServiceProvider::class);
        $this->app->register(UtilityRouteServiceProvider::class);

        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('SEOItems', SEOItems::class);
        });
    }

    protected function registerMorphMaps()
    {
        Relation::morphMap([
            'UtilitySEOItem' => SEOItem::class,
        ]);
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/utility-seo');
    }
}
