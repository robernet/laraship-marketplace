<?php

namespace Corals\Utility\Category\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Utility\Category\Models\Category;
use Corals\Utility\Category\Transformers\CategoryTransformer;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Corals\Utility\Category\Jobs\GenerateExcelForCategories;

class CategoriesDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('utility-category.models.category.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new CategoryTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Category $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Category $model)
    {
        //        return $model->withCount('products');
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
            'name' => ['title' => trans('utility-category::attributes.category.name')],
            'slug' => ['title' => trans('utility-category::attributes.category.slug')],
            'parent_id' => ['title' => trans('utility-category::attributes.category.parent_id')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }

    public function getFilters()
    {
        return [
            'name' => ['title' => trans('utility-category::attributes.category.name'), 'class' => 'col-md-3', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'parent.id' => ['title' => trans('utility-category::attributes.category.parent_id'), 'class' => 'col-md-2', 'type' => 'select2', 'options' => \Category::getCategoriesList(null, true), 'active' => true],
            'created_at' => ['title' => trans('Corals::attributes.created_at'), 'class' => 'col-md-2', 'type' => 'date', 'active' => true],
        ];
    }

    protected function getBulkActions()
    {
        return [
            'delete' => ['title' => trans('Corals::labels.delete'), 'permission' => 'Utility::category.delete', 'confirmation' => trans('Corals::labels.confirmation.title')],
            'active' => ['title' => '<i class="fa fa-check-circle"></i> ' . trans('Corals::attributes.status_options.active'), 'permission' => 'Utility::category.update', 'confirmation' => trans('Corals::labels.confirmation.title')],
            'inActive' => ['title' => '<i class="fa fa-check-circle-o"></i> ' . trans('Corals::attributes.status_options.inactive'), 'permission' => 'Utility::category.update', 'confirmation' => trans('Corals::labels.confirmation.title')],
        ];
    }

    protected function getOptions()
    {
        $url = url(config('utility-category.models.category.resource_url'));

        return ['resource_url' => $url];
    }

    /**
     * @param $download
     * @return ShouldQueue
     */
    protected function getCSVGeneratorJob($download)
    {
        $columns = $this->getExportColumnsFromBuilder();

        return new GenerateExcelForCategories(
            get_class($this),
            $this->scopes,
            $columns,
            $this->getTableId(),
            user(),
            $download
        );
    }
}
