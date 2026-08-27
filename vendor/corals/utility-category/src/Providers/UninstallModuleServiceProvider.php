<?php

namespace Corals\Utility\Category\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Utility\Category\database\migrations\CreateCategoryAttributeTables;
use Corals\Utility\Category\database\seeds\UtilityCategoryDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateCategoryAttributeTables::class,
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $utilityCategoryDatabaseSeeder = new UtilityCategoryDatabaseSeeder();

        $utilityCategoryDatabaseSeeder->rollback();
    }
}
