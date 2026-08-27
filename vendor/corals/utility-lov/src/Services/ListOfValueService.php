<?php

namespace Corals\Utility\ListOfValue\Services;

use Corals\Foundation\Services\BaseServiceClass;
use Illuminate\Http\Request;

class ListOfValueService extends BaseServiceClass
{
    protected $excludedRequestParams = ['thumbnail', 'clear'];

    /**
     * @param Request $request
     * @param $additionalData
     */
    public function preStoreUpdate(Request $request, &$additionalData)
    {
        $listofvalue = $this->model;


        if ($request->has('clear') || $request->hasFile('thumbnail')) {
            $listofvalue->clearMediaCollection($listofvalue->mediaCollectionName);
        }

        if ($request->hasFile('thumbnail') && ! $request->has('clear')) {
            $listofvalue->addMedia($request->file('thumbnail'))
                ->withCustomProperties(['root' => 'user_' . user()->hashed_id])
                ->toMediaCollection($listofvalue->mediaCollectionName);
        }
        $properties = $request->get('properties', []);

        $formattedProperties = null;

        foreach ($properties ?? [] as $item) {
            $formattedProperties[$item['key']] = $item['value'];
        }

        $request->request->set('properties', $formattedProperties);
    }
}
