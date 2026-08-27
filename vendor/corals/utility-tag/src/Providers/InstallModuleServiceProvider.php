<?php

namespace Corals\Utility\Tag\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Utility\Tag\database\migrations\CreateTagTables;
use Corals\Utility\Tag\database\seeds\UtilityTagDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateTagTables::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilityTagDatabaseSeeder = new UtilityTagDatabaseSeeder();

        $utilityTagDatabaseSeeder->run();
    }
}
