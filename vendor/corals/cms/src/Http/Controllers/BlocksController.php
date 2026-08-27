<?php

namespace Corals\Modules\CMS\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\CMS\DataTables\BlocksDataTable;
use Corals\Modules\CMS\Http\Requests\BlockRequest;
use Corals\Modules\CMS\Models\Block;

class BlocksController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('cms.models.block.resource_url');

        $this->resource_model = new Block();

        $this->title = 'cms::module.block.title';
        $this->title_singular = 'cms::module.block.title_singular';

        parent::__construct();
    }

    /**
     * @param BlockRequest $request
     * @param BlocksDataTable $dataTable
     * @return mixed
     */
    public function index(BlockRequest $request, BlocksDataTable $dataTable)
    {
        return $dataTable->render('cms::blocks.index');
    }
}
