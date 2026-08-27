<?php

namespace Corals\Utility\Location\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Utility\Location\Jobs\GenerateExcelForLocations;
use Corals\Utility\Location\Models\Location;
use Corals\Utility\Location\Transformers\LocationTransformer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Yajra\DataTables\EloquentDataTable;

class LocationsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('utility-location.models.location.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new LocationTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Location $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Location $model)
    {
        return $model->newQuery();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['visible' => false],
            'name' => ['title' => trans('utility-location::attributes.location.name')],
            'address' => ['title' => trans('utility-location::attributes.location.address')],
            'lat' => ['title' => trans('utility-location::attributes.location.lat')],
            'long' => ['title' => trans('utility-location::attributes.location.long')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }

    protected function getBulkActions()
    {
        return [
            'delete' => ['title' => trans('Corals::labels.delete'), 'permission' => 'Utility::location.delete', 'confirmation' => trans('Corals::labels.confirmation.title')],
            'active' => ['title' => '<i class="fa fa-check-circle"></i> ' . trans('Corals::attributes.status_options.active'), 'permission' => 'Utility::location.update', 'confirmation' => trans('Corals::labels.confirmation.title')],
            'inActive' => ['title' => '<i class="fa fa-check-circle-o"></i> ' . trans('Corals::attributes.status_options.inactive'), 'permission' => 'Utility::location.update', 'confirmation' => trans('Corals::labels.confirmation.title')],
        ];
    }

    protected function getOptions()
    {
        $url = url(config('utility-location.models.location.resource_url'));

        return ['resource_url' => $url];
    }

    /**
     * @param $download
     * @return ShouldQueue
     */
    protected function getCSVGeneratorJob($download)
    {
        $columns = $this->getExportColumnsFromBuilder();

        return new GenerateExcelForLocations(
            get_class($this),
            $this->scopes,
            $columns,
            $this->getTableId(),
            user(),
            $download
        );
    }
}
