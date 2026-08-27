<?php

namespace Corals\Utility\ListOfValue\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Utility\ListOfValue\database\migrations\CreateListOfValuesTable;
use Corals\Utility\ListOfValue\database\seeds\UtilityListOfValueDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateListOfValuesTable::class,
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $utilityListOfValueDatabaseSeeder = new UtilityListOfValueDatabaseSeeder();

        $utilityListOfValueDatabaseSeeder->rollback();
    }
}
