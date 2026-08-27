<?php

namespace Corals\Utility\SEO\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Utility\SEO\database\migrations\CreateSEOItemsTable;
use Corals\Utility\SEO\database\seeds\UtilitySEODatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateSEOItemsTable::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilitySEODatabaseSeeder = new UtilitySEODatabaseSeeder();

        $utilitySEODatabaseSeeder->run();
    }
}
