<?php

namespace Corals\Utility\Rating\Facades;

use Illuminate\Support\Facades\Facade;

class RatingManager extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Utility\Rating\Classes\RatingManager::class;
    }
}
