<?php

namespace Corals\Modules\Subscriptions\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Subscriptions\DataTables\PlanUsageDataTable;
use Corals\Modules\Subscriptions\Http\Requests\PlanUsageRequest;
use Corals\Modules\Subscriptions\Models\PlanUsage;

class PlanUsageController extends BaseController
{

    public function __construct()
    {
        $this->resource_url = config('subscriptions.models.plan_usage.resource_url');

        $this->resource_model = new PlanUsage();

        $this->title = trans('Subscriptions::module.plan_usage.title');
        $this->title_singular = trans('Subscriptions::module.plan_usage.title_singular');
        parent::__construct();
    }

    /**
     * @param PlanUsageRequest $request
     * @param PlanUsageDataTable $dataTable
     * @return mixed
     */
    public function index(PlanUsageRequest $request, PlanUsageDataTable $dataTable)
    {
        return $dataTable->render('Subscriptions::plan_usage.index');
    }
}
