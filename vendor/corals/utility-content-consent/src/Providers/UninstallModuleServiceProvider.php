<?php

namespace Corals\Utility\ContentConsent\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Utility\ContentConsent\database\seeds\UtilityContentConsentDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $utilityDatabaseSeeder = new UtilityContentConsentDatabaseSeeder();

        $utilityDatabaseSeeder->rollback();
    }
}
