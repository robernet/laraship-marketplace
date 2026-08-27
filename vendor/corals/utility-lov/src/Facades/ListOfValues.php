<?php

namespace Corals\Utility\ListOfValue\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ListOfValues
 * @package Corals\Utility\Facades\ListOfValue
 * @method static getParents($module = null, $objects = false, $status = null)
 * @method static get($parentCode, $objects = false, $status = 'active', $useCode = true)
 * @method static getLOVByCode($code, $parentCode = null, $object = false, $default = null, $attribute = 'label')
 * @method static getColoredLOVByCode($code, $parentCode = null, $attribute = 'label', $default = null)
 * @method static insertListOfValuesChildren($parent, $options)
 */
class ListOfValues extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Utility\ListOfValue\Classes\ListOfValueManager::class;
    }
}
