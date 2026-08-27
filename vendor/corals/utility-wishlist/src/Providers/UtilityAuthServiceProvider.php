<?php

namespace Corals\Utility\Wishlist\Providers;

use Corals\Utility\Wishlist\Models\Wishlist;
use Corals\Utility\Wishlist\Policies\WishlistPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class UtilityAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Wishlist::class => WishlistPolicy::class,
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
