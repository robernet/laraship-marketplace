<?php

namespace Corals\Utility\ContentConsent\Facades;

use Illuminate\Support\Facades\Facade;

class UtilityContentConsent extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Utility\ContentConsent\Classes\UtilityContentConsent::class;
    }
}
