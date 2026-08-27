<?php

namespace Corals\Utility\Wishlist\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Utility\Wishlist\database\migrations\CreateWishlistsTable;
use Corals\Utility\Wishlist\database\seeds\UtilityWishlistDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateWishlistsTable::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilityWishlistDatabaseSeeder = new UtilityWishlistDatabaseSeeder();

        $utilityWishlistDatabaseSeeder->run();
    }
}
