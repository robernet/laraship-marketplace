<?php

namespace Corals\Utility\Comment\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Utility\Comment\database\migrations\CreateCommentsTable;
use Corals\Utility\Comment\database\seeds\UtilityCommentDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateCommentsTable::class,
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $utilityCommentDatabaseSeeder = new UtilityCommentDatabaseSeeder();

        $utilityCommentDatabaseSeeder->rollback();
    }
}
