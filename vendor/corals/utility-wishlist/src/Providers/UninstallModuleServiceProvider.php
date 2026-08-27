<?php

namespace Corals\Utility\Wishlist\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Utility\Wishlist\database\migrations\CreateWishlistsTable;
use Corals\Utility\Wishlist\database\seeds\UtilityWishlistDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateWishlistsTable::class,
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $utilityWishlistDatabaseSeeder = new UtilityWishlistDatabaseSeeder();

        $utilityWishlistDatabaseSeeder->rollback();
    }
}
