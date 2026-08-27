<?php

namespace Corals\Utility\Location\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Utility\Location\database\migrations\CreateAddressTables;
use Corals\Utility\Location\database\seeds\UtilityLocationDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateAddressTables::class,
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $utilityLocationDatabaseSeeder = new UtilityLocationDatabaseSeeder();

        $utilityLocationDatabaseSeeder->rollback();
    }
}
