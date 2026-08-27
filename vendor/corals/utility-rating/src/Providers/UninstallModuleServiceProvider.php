<?php

namespace Corals\Utility\Rating\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Utility\Rating\database\migrations\CreateRatingTable;
use Corals\Utility\Rating\database\seeds\UtilityRatingDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateRatingTable::class,
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $utilityRatingDatabaseSeeder = new UtilityRatingDatabaseSeeder();

        $utilityRatingDatabaseSeeder->rollback();
    }
}
