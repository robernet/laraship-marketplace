<?php

namespace Corals\Utility\Category\Http\Controllers\API;

use Corals\Foundation\Http\Controllers\APIBaseController;
use Corals\Utility\Category\DataTables\AttributesDataTable;
use Corals\Utility\Category\Http\Requests\AttributeRequest;
use Corals\Utility\Category\Models\Attribute;
use Corals\Utility\Category\Services\AttributeService;
use Corals\Utility\Category\Transformers\API\AttributePresenter;

class AttributesController extends APIBaseController
{
    protected $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
        $this->attributeService->setPresenter(new AttributePresenter());

        parent::__construct();
    }

    /**
     * @param AttributeRequest $request
     * @param AttributesDataTable $dataTable
     * @return mixed
     */
    public function index(AttributeRequest $request, AttributesDataTable $dataTable)
    {
        $attributes = $dataTable->query(new Attribute());

        return $this->attributeService->index($attributes, $dataTable);
    }

    /**
     * @param AttributeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AttributeRequest $request)
    {
        try {
            $attribute = $this->attributeService->store($request, Attribute::class);

            return apiResponse($this->attributeService->getModelDetails(), trans('Corals::messages.success.created', ['item' => $attribute->label]));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    /**
     * @param AttributeRequest $request
     * @param Attribute $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AttributeRequest $request, Attribute $attribute)
    {
        try {
            return apiResponse($this->attributeService->getModelDetails($attribute));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    /**
     * @param AttributeRequest $request
     * @param Attribute $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AttributeRequest $request, Attribute $attribute)
    {
        try {
            $this->attributeService->update($request, $attribute);

            return apiResponse($this->attributeService->getModelDetails(), trans('Corals::messages.success.updated', ['item' => $attribute->label]));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    /**
     * @param AttributeRequest $request
     * @param Attribute $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AttributeRequest $request, Attribute $attribute)
    {
        try {
            $this->attributeService->destroy($request, $attribute);

            return apiResponse([], trans('Corals::messages.success.deleted', ['item' => $attribute->name]));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }
}
