<?php

namespace Corals\Utility\ListOfValue\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Utility\ListOfValue\database\migrations\CreateListOfValuesTable;
use Corals\Utility\ListOfValue\database\seeds\UtilityListOfValueDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateListOfValuesTable::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilityListOfValueDatabaseSeeder = new UtilityListOfValueDatabaseSeeder();

        $utilityListOfValueDatabaseSeeder->run();
    }
}
