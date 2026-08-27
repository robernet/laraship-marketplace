<?php

namespace Corals\Utility\Category\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Foundation\Http\Requests\BulkRequest;
use Corals\Utility\Category\DataTables\AttributesDataTable;
use Corals\Utility\Category\Http\Requests\AttributeRequest;
use Corals\Utility\Category\Models\Attribute;
use Corals\Utility\Category\Models\Category;
use Corals\Utility\Category\Services\AttributeService;
use Illuminate\Support\Arr;

class AttributesController extends BaseController
{
    protected $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;

        $this->resource_url = config('utility-category.models.attribute.resource_url');

        $this->resource_model = new Attribute();

        $this->title = 'utility-category::module.attribute.title';
        $this->title_singular = 'utility-category::module.attribute.title_singular';

        parent::__construct();
    }

    /**
     * @param AttributeRequest $request
     * @param AttributesDataTable $dataTable
     * @return mixed
     */
    public function index(AttributeRequest $request, AttributesDataTable $dataTable)
    {
        return $dataTable->render('utility-category::attributes.index');
    }

    /**
     * @param AttributeRequest $request
     * @return $this
     */
    public function create(AttributeRequest $request)
    {
        $attribute = new Attribute();

        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular]),
        ]);

        return view('utility-category::attributes.create_edit')->with(compact('attribute'));
    }

    /**
     * @param AttributeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(AttributeRequest $request)
    {
        try {
            $this->attributeService->store($request, Attribute::class);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Attribute::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param AttributeRequest $request
     * @param Attribute $attribute
     * @return Attribute
     */
    public function show(AttributeRequest $request, Attribute $attribute)
    {
        return $attribute;
    }

    /**
     * @param AttributeRequest $request
     * @param Attribute $attribute
     * @return $this
     */
    public function edit(AttributeRequest $request, Attribute $attribute)
    {
        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.update_title', ['title' => $attribute->label]),
        ]);

        return view('utility-category::.attributes.create_edit')->with(compact('attribute'));
    }

    /**
     * @param AttributeRequest $request
     * @param Attribute $attribute
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(AttributeRequest $request, Attribute $attribute)
    {
        try {
            $this->attributeService->update($request, $attribute);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Attribute::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param AttributeRequest $request
     * @param Attribute $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkAction(BulkRequest $request)
    {
        try {
            $action = $request->input('action');
            $selection = json_decode($request->input('selection'), true);

            switch ($action) {
                case 'delete':
                    foreach ($selection as $selection_id) {
                        $attribute = Attribute::findByHash($selection_id);
                        $attribute_request = new AttributeRequest();
                        $attribute_request->setMethod('DELETE');
                        $this->destroy($attribute_request, $attribute);
                    }
                    $message = [
                        'level' => 'success',
                        'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular]),
                    ];

                    break;
            }
        } catch (\Exception $exception) {
            log_exception($exception, Category::class, 'bulkAction');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    public function destroy(AttributeRequest $request, Attribute $attribute)
    {
        try {
            $this->attributeService->destroy($request, $attribute);

            $message = [
                'level' => 'success',
                'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular]),
            ];
        } catch (\Exception $exception) {
            log_exception($exception, Attribute::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    public function getCategoryAttributes(AttributeRequest $request, $modelId = null)
    {
        $categories_ids = request()->get('categories_ids', "[]");
        $categories_ids = Arr::wrap(json_decode(urldecode($categories_ids)));
        $modelClass = $request->get('model_class', []);

        if (! is_array($categories_ids)) {
            return '';
        }

        $instance = null;


        $categories = Category::query()->whereIn('id', $categories_ids)->get();

        if (! is_null($modelId) && class_exists($modelClass)) {
            $instance = $modelClass::findByHash($modelId);
        }

        $fields = collect([]);

        foreach ($categories as $category) {
            if ($category->parent_id) {
                $fields = $fields->merge($category->parent->categoryAttributes);
            }
            $fields = $fields->merge($category->categoryAttributes);
        }

        $fields = $fields->unique('id');


        $input = '';
        foreach ($fields as $field) {
            $input .= \Category::renderAttribute($field, $instance, []);
        }

        return response()->json($input);
    }
}
