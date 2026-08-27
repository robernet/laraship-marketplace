<?php

namespace Corals\Utility\Rating\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Utility\Rating\database\migrations\CreateRatingTable;
use Corals\Utility\Rating\database\seeds\UtilityRatingDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateRatingTable::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilityRatingDatabaseSeeder = new UtilityRatingDatabaseSeeder();

        $utilityRatingDatabaseSeeder->run();
    }
}
