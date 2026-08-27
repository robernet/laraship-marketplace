<?php

namespace Corals\Utility\Comment\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Utility\Comment\database\migrations\CreateCommentsTable;
use Corals\Utility\Comment\database\seeds\UtilityCommentDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateCommentsTable::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilityCommentDatabaseSeeder = new UtilityCommentDatabaseSeeder();

        $utilityCommentDatabaseSeeder->run();
    }
}
