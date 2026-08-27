<?php

namespace Corals\Utility\ContentConsent\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Utility\ContentConsent\database\seeds\UtilityContentConsentDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $module_public_path = __DIR__ . '/../public';

    protected $migrations = [
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilityDatabaseSeeder = new UtilityContentConsentDatabaseSeeder();

        $utilityDatabaseSeeder->run();
    }
}
