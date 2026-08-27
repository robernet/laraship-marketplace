<?php

namespace Corals\Utility\Webhook\Facades;

use Illuminate\Support\Facades\Facade;

class Webhooks extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Utility\Webhook\Classes\Webhooks::class;
    }
}
