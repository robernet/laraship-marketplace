<?php

namespace Corals\Utility\Tag;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Settings\Facades\Modules;
use Corals\Utility\Tag\Facades\Tag;
use Corals\Utility\Tag\Models\Tag as TagModel;
use Corals\Utility\Tag\Providers\UtilityAuthServiceProvider;
use Corals\Utility\Tag\Providers\UtilityRouteServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;

class UtilityTagServiceProvider extends BasePackageServiceProvider
{
    /**
     * @var
     */
    protected $packageCode = 'corals-utility-tag';

    public function bootPackage()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'utility-tag');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'utility-tag');

        $this->mergeConfigFrom(
            __DIR__ . '/config/utility-tag.php',
            'utility-tag'
        );
        $this->publishes([
            __DIR__ . '/config/utility-tag.php' => config_path('utility-tag.php'),
            __DIR__ . '/resources/views' => resource_path('resources/views/vendor/utility-tag'),
        ]);

        $this->registerMorphMaps();
    }

    public function registerPackage()
    {
        $this->app->register(UtilityAuthServiceProvider::class);
        $this->app->register(UtilityRouteServiceProvider::class);

        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Tag', Tag::class);
        });
    }

    protected function registerMorphMaps()
    {
        Relation::morphMap([
            'UtilityTag' => TagModel::class,
        ]);
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/utility-tag');
    }
}
