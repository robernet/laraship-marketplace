<?php

namespace Corals\Utility\Category\Providers;

use Corals\Utility\Category\Models\Attribute;
use Corals\Utility\Category\Models\Category;
use Corals\Utility\Category\Policies\AttributePolicy;
use Corals\Utility\Category\Policies\CategoryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class UtilityAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Attribute::class => AttributePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
