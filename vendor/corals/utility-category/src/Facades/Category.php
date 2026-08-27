<?php

namespace Corals\Utility\Category\Facades;

use Illuminate\Support\Facades\Facade;

class Category extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Utility\Category\Classes\CategoryManager::class;
    }
}
