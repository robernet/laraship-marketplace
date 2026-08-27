<?php

namespace Corals\Modules\Payment\Openpay\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Payment\Facades\Payments;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected function providerBooted()
    {
        $supported_gateways = Payments::getAvailableGateways();

        $supported_gateways['Openpay'] = 'Openpay';

        Payments::setAvailableGateways($supported_gateways);
    }
}
