<?php

namespace Corals\Utility\Webhook\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Utility\Webhook\database\migrations\CreateWebhooksTable;
use Corals\Utility\Webhook\database\seeds\UtilityWebhookDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateWebhooksTable::class,
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $utilityWebhookDatabaseSeeder = new UtilityWebhookDatabaseSeeder();

        $utilityWebhookDatabaseSeeder->rollback();
    }
}
