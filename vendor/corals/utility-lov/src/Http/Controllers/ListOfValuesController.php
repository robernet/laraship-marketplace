<?php

namespace Corals\Utility\ListOfValue\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Foundation\Http\Requests\BulkRequest;
use Corals\Utility\ListOfValue\DataTables\ListOfValuesDataTable;
use Corals\Utility\ListOfValue\Facades\ListOfValues;
use Corals\Utility\ListOfValue\Http\Requests\ListOfValueRequest;
use Corals\Utility\ListOfValue\Models\ListOfValue;
use Corals\Utility\ListOfValue\Services\ListOfValueService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListOfValuesController extends BaseController
{
    protected $listOfValueService;

    public function __construct(ListOfValueService $listOfValueService)
    {
        $this->listOfValueService = $listOfValueService;
        $this->resource_url = config('utility-lov.models.listOfValue.resource_url');

        $this->resource_model = new ListOfValue();

        $this->title = 'utility-lov::module.listOfValue.title';
        $this->title_singular = 'utility-lov::module.listOfValue.title_singular';

        parent::__construct();
    }

    /**
     * @param ListOfValueRequest $request
     * @param ListOfValuesDataTable $dataTable
     * @return mixed
     */
    public function index(ListOfValueRequest $request, ListOfValuesDataTable $dataTable)
    {
        return $dataTable->render('utility-lov::index');
    }

    /**
     * @param ListOfValueRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(ListOfValueRequest $request)
    {
        $listOfValue = new ListOfValue();

        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular]),
        ]);

        return view('utility-lov::create_edit')->with(compact('listOfValue'));
    }

    /**
     * @param ListOfValueRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ListOfValueRequest $request)
    {
        try {
            $additionalData = [];

            if (empty($request->get('code'))) {
                $additionalData['code'] = ListOfValue::getCode('LOV', 'code', false);
            }

            $listOfValue = $this->listOfValueService->store($request, ListOfValue::class, $additionalData);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, ListOfValue::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param ListOfValueRequest $request
     * @param ListOfValue $listOfValue
     * @return ListOfValue
     */
    public function show(ListOfValueRequest $request, ListOfValue $listOfValue)
    {
        return $listOfValue;
    }

    /**
     * @param ListOfValueRequest $request
     * @param ListOfValue $listOfValue
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ListOfValueRequest $request, ListOfValue $listOfValue)
    {
        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.update_title', ['title' => $listOfValue->code]),
        ]);

        return view('utility-lov::create_edit')->with(compact('listOfValue'));
    }

    /**
     * @param ListOfValueRequest $request
     * @param ListOfValue $listOfValue
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ListOfValueRequest $request, ListOfValue $listOfValue)
    {
        try {
            $this->listOfValueService->update($request, $listOfValue);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, ListOfValue::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param ListOfValueRequest $request
     * @param ListOfValue $listOfValue
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
                        $listOfValue = ListOfValue::findByHash($selection_id);
                        $listOfValue_request = new ListOfValueRequest();
                        $listOfValue_request->setMethod('DELETE');
                        $this->destroy($listOfValue_request, $listOfValue);
                    }
                    $message = [
                        'level' => 'success',
                        'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular]),
                    ];

                    break;

                case 'active':
                    foreach ($selection as $selection_id) {
                        $listOfValue = ListOfValue::findByHash($selection_id);
                        if (user()->can('Utility::listOfValue.update')) {
                            $listOfValue->update([
                                'status' => 'active',
                            ]);
                            $listOfValue->save();
                            $message = [
                                'level' => 'success',
                                'message' => trans(
                                    'utility-lov::attributes.update_status',
                                    ['item' => $this->title_singular]
                                ),
                            ];
                        } else {
                            $message = [
                                'level' => 'error',
                                'message' => trans(
                                    'utility-lov::attributes.no_permission',
                                    ['item' => $this->title_singular]
                                ),
                            ];
                        }
                    }

                    break;

                case 'inActive':
                    foreach ($selection as $selection_id) {
                        $listOfValue = ListOfValue::findByHash($selection_id);
                        if (user()->can('Utility::listOfValue.update')) {
                            $listOfValue->update([
                                'status' => 'inactive',
                            ]);
                            $listOfValue->save();
                            $message = [
                                'level' => 'success',
                                'message' => trans(
                                    'utility-lov::attributes.update_status',
                                    ['item' => $this->title_singular]
                                ),
                            ];
                        } else {
                            $message = [
                                'level' => 'error',
                                'message' => trans(
                                    'utility-lov::attributes.no_permission',
                                    ['item' => $this->title_singular]
                                ),
                            ];
                        }
                    }

                    break;
            }
        } catch (\Exception $exception) {
            log_exception($exception, ListOfValuesController::class, 'bulkAction');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    public function destroy(ListOfValueRequest $request, ListOfValue $listOfValue)
    {
        try {
            $this->listOfValueService->destroy($request, $listOfValue);

            $message = [
                'level' => 'success',
                'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular]),
            ];
        } catch (\Exception $exception) {
            log_exception($exception, ListOfValue::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getParentChildren(Request $request)
    {
        try {
            return ListOfValues::get(current($request->all()));
        } catch (\Exception $exception) {
            $message = ['level' => 'error', 'message' => $exception->getMessage()];

            return response()->json($message);
        }
    }
}
