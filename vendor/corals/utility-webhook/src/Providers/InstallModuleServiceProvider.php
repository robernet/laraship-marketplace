<?php

namespace Corals\Utility\Webhook\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Utility\Webhook\database\migrations\CreateWebhooksTable;
use Corals\Utility\Webhook\database\seeds\UtilityWebhookDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateWebhooksTable::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilityWebhookDatabaseSeeder = new UtilityWebhookDatabaseSeeder();

        $utilityWebhookDatabaseSeeder->run();
    }
}
