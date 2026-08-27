<?php

namespace Corals\Utility\Location\Services;

use Corals\Foundation\Services\BaseServiceClass;
use Corals\Utility\Location\Facades\Address;
use Illuminate\Http\Request;

class LocationService extends BaseServiceClass
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getLocationTypeChildren(Request $request)
    {
        $values = array_values($request->all());

        $locationId = data_get($values, '0');
        $type = data_get($values, '1');

        return Address::getLocationsList($module = null, $objects = false, $status = 'active', $orderBy = 'name ASC', $type, $parent_id = $locationId);
    }
}
