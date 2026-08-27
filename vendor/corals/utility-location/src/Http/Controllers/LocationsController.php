<?php

namespace Corals\Utility\Location\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Foundation\Http\Requests\BulkRequest;
use Corals\Utility\Category\Models\Category;
use Corals\Utility\Location\DataTables\LocationsDataTable;
use Corals\Utility\Location\Http\Requests\LocationRequest;
use Corals\Utility\Location\Models\Location;
use Corals\Utility\Location\Services\LocationService;
use Illuminate\Http\Request;

class LocationsController extends BaseController
{
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
        $this->resource_url = config('utility-location.models.location.resource_url');

        $this->resource_model = new Location();

        $this->title = 'utility-location::module.location.title';
        $this->title_singular = 'utility-location::module.location.title_singular';

        parent::__construct();
    }

    /**
     * @param LocationRequest $request
     * @param LocationsDataTable $dataTable
     * @return mixed
     */
    public function index(LocationRequest $request, LocationsDataTable $dataTable)
    {
        return $dataTable->render('utility-location::locations.index');
    }

    /**
     * @param LocationRequest $request
     * @return $this
     */
    public function create(LocationRequest $request)
    {
        $location = new Location();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('utility-location::locations.create_edit')->with(compact('location'));
    }

    /**
     * @param LocationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(LocationRequest $request)
    {
        try {
            $location = $this->locationService->store($request, Location::class);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Location::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param LocationRequest $request
     * @param Location $location
     * @return Location
     */
    public function show(LocationRequest $request, Location $location)
    {
        return $location;
    }

    /**
     * @param LocationRequest $request
     * @param Location $location
     * @return $this
     */
    public function edit(LocationRequest $request, Location $location)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $location->name])]);

        return view('utility-location::locations.create_edit')->with(compact('location'));
    }

    /**
     * @param LocationRequest $request
     * @param Location $location
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(LocationRequest $request, Location $location)
    {
        try {
            $this->locationService->update($request, $location);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Location::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param LocationRequest $request
     * @param Location $location
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
                        $location = Location::findByHash($selection_id);
                        $location_request = new LocationRequest();
                        $location_request->setMethod('DELETE');
                        $this->destroy($location_request, $location);
                    }
                    $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];

                    break;

                case 'active':
                    foreach ($selection as $selection_id) {
                        $location = Location::findByHash($selection_id);
                        if (user()->can('Utility::location.update')) {
                            $location->update([
                                'status' => 'active',
                            ]);
                            $location->save();
                            $message = ['level' => 'success', 'message' => trans('utility-location::attributes.update_status', ['item' => $this->title_singular])];
                        } else {
                            $message = ['level' => 'error', 'message' => trans('utility-location::attributes.no_permission', ['item' => $this->title_singular])];
                        }
                    }

                    break;

                case 'inActive':
                    foreach ($selection as $selection_id) {
                        $location = Location::findByHash($selection_id);
                        if (user()->can('Utility::location.update')) {
                            $location->update([
                                'status' => 'inactive',
                            ]);
                            $location->save();
                            $message = ['level' => 'success', 'message' => trans('utility-location::attributes.update_status', ['item' => $this->title_singular])];
                        } else {
                            $message = ['level' => 'error', 'message' => trans('utility-location::attributes.no_permission', ['item' => $this->title_singular])];
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

    public function destroy(LocationRequest $request, Location $location)
    {
        try {
            $this->locationService->destroy($request, $location);

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Location::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getLocationTypeChildren(Request $request)
    {
        try {
            return $this->locationService->getLocationTypeChildren($request);
        } catch (\Exception $exception) {
            $message = ['level' => 'error', 'message' => $exception->getMessage()];

            return response()->json($message);
        }
    }
}
