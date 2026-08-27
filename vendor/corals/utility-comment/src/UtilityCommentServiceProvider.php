<?php

namespace Corals\Utility\Comment;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Settings\Facades\Modules;
use Corals\User\Communication\Facades\CoralsNotification;
use Corals\Utility\Comment\Classes\CommentManager;
use Corals\Utility\Comment\Models\Comment;
use Corals\Utility\Comment\Notifications\CommentCreated;
use Corals\Utility\Comment\Notifications\CommentToggleStatus;
use Corals\Utility\Comment\Providers\UtilityAuthServiceProvider;
use Corals\Utility\Comment\Providers\UtilityRouteServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;

class UtilityCommentServiceProvider extends BasePackageServiceProvider
{
    /**
     * @var
     */
    protected $packageCode = 'corals-utility-comment';

    public function bootPackage()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'utility-comment');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'utility-comment');

        $this->mergeConfigFrom(
            __DIR__ . '/config/utility-comment.php',
            'utility-comment'
        );
        $this->publishes([
            __DIR__ . '/config/utility-comment.php' => config_path('utility-comment.php'),
            __DIR__ . '/resources/views' => resource_path('resources/views/vendor/utility-comment'),
        ]);

        $this->registerMorphMaps();

        $this->addEvents();
    }

    public function registerPackage()
    {
        $this->app->register(UtilityAuthServiceProvider::class);
        $this->app->register(UtilityRouteServiceProvider::class);

        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('CommentManager', CommentManager::class);
        });
    }

    protected function registerMorphMaps()
    {
        Relation::morphMap([
            'UtilityComment' => Comment::class,
        ]);
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/utility-comment');
    }

    protected function addEvents()
    {
        CoralsNotification::addEvent(
            'notifications.comment.comment_created',
            'Comment Created',
            CommentCreated::class
        );

        CoralsNotification::addEvent(
            'notifications.comment.comment_toggle_status',
            'Comment Toggle Status',
            CommentToggleStatus::class
        );
    }
}
