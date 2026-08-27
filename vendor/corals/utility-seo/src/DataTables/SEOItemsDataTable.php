<?php

namespace Corals\Utility\SEO\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Utility\SEO\Models\SEOItem;
use Corals\Utility\SEO\Transformers\SEOItemTransformer;
use Yajra\DataTables\EloquentDataTable;

class SEOItemsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('utility-seo.models.seo_item.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new SEOItemTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param SEOItem $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(SEOItem $model)
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
            'slug' => ['title' => trans('utility-seo::attributes.seo_item.slug')],
            'route' => ['title' => trans('utility-seo::attributes.seo_item.route')],
            'title' => ['title' => trans('utility-seo::attributes.seo_item.title')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
