<?php

namespace Corals\Utility\Tag\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Utility\Tag\database\migrations\CreateTagTables;
use Corals\Utility\Tag\database\seeds\UtilityTagDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateTagTables::class,
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $utilityTagDatabaseSeeder = new UtilityTagDatabaseSeeder();

        $utilityTagDatabaseSeeder->rollback();
    }
}
