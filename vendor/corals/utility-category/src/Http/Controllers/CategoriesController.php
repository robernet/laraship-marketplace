<?php

namespace Corals\Utility\Category\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Foundation\Http\Requests\BulkRequest;
use Corals\Utility\Category\DataTables\CategoriesDataTable;
use Corals\Utility\Category\Http\Requests\CategoryRequest;
use Corals\Utility\Category\Models\Category;
use Corals\Utility\Category\Services\CategoryService;
use Illuminate\Http\Request;

class CategoriesController extends BaseController
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;

        $this->resource_url = config('utility-category.models.category.resource_url');

        $this->resource_model = new Category();

        $this->title = 'utility-category::module.category.title';
        $this->title_singular = 'utility-category::module.category.title_singular';

        parent::__construct();
    }

    /**
     * @param CategoryRequest $request
     * @param CategoriesDataTable $dataTable
     * @return mixed
     */
    public function index(CategoryRequest $request, CategoriesDataTable $dataTable)
    {
        return $dataTable->render('utility-category::categories.index');
    }

    /**
     * @param CategoryRequest $request
     * @return $this
     */
    public function create(CategoryRequest $request)
    {
        $category = new Category();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('utility-category::categories.create_edit')->with(compact('category'));
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CategoryRequest $request)
    {
        try {
            $category = $this->categoryService->store($request, Category::class);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Category::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return Category
     */
    public function show(CategoryRequest $request, Category $category)
    {
        return $category;
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return $this
     */
    public function edit(CategoryRequest $request, Category $category)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $category->name])]);

        return view('utility-category::categories.create_edit')->with(compact('category'));
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $this->categoryService->update($request, $category);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Category::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
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
                        $category = Category::findByHash($selection_id);
                        $category_request = new CategoryRequest();
                        $category_request->setMethod('DELETE');
                        $this->destroy($category_request, $category);
                    }
                    $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];

                    break;

                case 'active':
                    foreach ($selection as $selection_id) {
                        $category = Category::findByHash($selection_id);
                        if (user()->can('Utility::category.update')) {
                            $category->update([
                                'status' => 'active',
                            ]);
                            $category->save();
                            $message = ['level' => 'success', 'message' => trans('utility-category::attributes.update_status', ['item' => $this->title_singular])];
                        } else {
                            $message = ['level' => 'error', 'message' => trans('utility-category::attributes.no_permission', ['item' => $this->title_singular])];
                        }
                    }

                    break;

                case 'inActive':
                    foreach ($selection as $selection_id) {
                        $category = Category::findByHash($selection_id);
                        if (user()->can('Utility::category.update')) {
                            $category->update([
                                'status' => 'inactive',
                            ]);
                            $category->save();
                            $message = ['level' => 'success', 'message' => trans('utility-category::attributes.update_status', ['item' => $this->title_singular])];
                        } else {
                            $message = ['level' => 'error', 'message' => trans('utility-category::attributes.no_permission', ['item' => $this->title_singular])];
                        }
                    }

                    break;
            }
        } catch (\Exception $exception) {
            log_exception($exception, Category::class, 'bulkAction');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    public function destroy(CategoryRequest $request, Category $category)
    {
        try {
            $this->categoryService->destroy($request, $category);

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Category::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    /**
     * categoriesHierarchy
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categoriesHierarchy(CategoryRequest $request)
    {
        if (user()->cannot('update', Category::class)) {
            abort(403, 'Forbidden!!');
        }

        return view('utility-category::categories.hierarchy');
    }

    /**
     * updateCategoriesHierarchy
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCategoriesHierarchy(Request $request)
    {
        try {
            if (user()->cannot('update', Category::class)) {
                abort(403, 'Forbidden!!');
            }

            $json_tree = $request->get('tree');

            if ($json_tree) {
                $json_tree = json_decode($json_tree, true);
            }

            $tree = [];

            $this->buildTree(0, $json_tree, $tree);

            foreach ($tree as $parent_id => $children) {
                foreach ($children as $child_id) {
                    Category::where('id', $child_id)->update(['parent_id' => $parent_id ?: null]);
                }
            }
            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.updated', ['item' => $this->title])];
        } catch (\Exception $exception) {
            log_exception($exception, Category::class, 'updateCategoriesHierarchy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    /**
     * buildTree
     *
     * @param $id
     * @param $json_tree
     * @param $tree
     */
    protected function buildTree($id, $json_tree, &$tree)
    {
        foreach ($json_tree as $node) {
            $tree[$id][] = \Arr::get($node, 'id');

            if (isset($node['children'])) {
                $this->buildTree(\Arr::get($node, 'id'), $node['children'], $tree);
            }
        }
    }
}
