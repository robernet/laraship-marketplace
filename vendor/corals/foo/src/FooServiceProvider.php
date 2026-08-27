<?php

namespace Corals\Modules\Foo;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Modules\Foo\Facades\Foo;
use Corals\Modules\Foo\Models\Bar;
use Corals\Modules\Foo\Providers\FooAuthServiceProvider;
use Corals\Modules\Foo\Providers\FooObserverServiceProvider;
use Corals\Modules\Foo\Providers\FooRouteServiceProvider;
use Corals\Settings\Facades\Modules;
use Corals\Settings\Facades\Settings;
use Illuminate\Foundation\AliasLoader;

class FooServiceProvider extends BasePackageServiceProvider
{
    protected $defer = true;
    /**
     * @var
     */
    protected $packageCode = 'corals-foo';

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function bootPackage()
    {
        // Load view
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Foo');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Foo');

        // Load migrations
        //        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->registerCustomFieldsModels();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerPackage()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/foo.php', 'foo');

        $this->app->register(FooRouteServiceProvider::class);
        $this->app->register(FooAuthServiceProvider::class);
        $this->app->register(FooObserverServiceProvider::class);

        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Foo', Foo::class);
        });
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Bar::class);
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/foo');
    }
}
