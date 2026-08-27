<?php

namespace Corals\Utility\Category\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Utility\Category\database\migrations\CreateCategoryAttributeTables;
use Corals\Utility\Category\database\seeds\UtilityCategoryDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateCategoryAttributeTables::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilityCategoryDatabaseSeeder = new UtilityCategoryDatabaseSeeder();

        $utilityCategoryDatabaseSeeder->run();
    }
}
