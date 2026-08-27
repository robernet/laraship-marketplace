<?php

namespace Corals\Utility\Location\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Utility\Location\database\migrations\CreateAddressTables;
use Corals\Utility\Location\database\seeds\UtilityLocationDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateAddressTables::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilityLocationDatabaseSeeder = new UtilityLocationDatabaseSeeder();

        $utilityLocationDatabaseSeeder->run();
    }
}
