<?php

namespace Corals\Utility\SEO\Facades;

use Illuminate\Support\Facades\Facade;

class SEOItems extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Utility\SEO\Classes\SEOItems::class;
    }
}
