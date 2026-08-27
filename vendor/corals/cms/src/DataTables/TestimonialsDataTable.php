<?php

namespace Corals\Modules\CMS\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\CMS\Models\Testimonial;
use Corals\Modules\CMS\Transformers\TestimonialTransformer;
use Yajra\DataTables\EloquentDataTable;

class TestimonialsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('cms.models.testimonial.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new TestimonialTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Testimonial $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Testimonial $model)
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
            'image' => ['width' => '35px', 'title' => trans('cms::attributes.content.image'), 'orderable' => false, 'searchable' => false],
            'title' => ['title' => trans('cms::attributes.content.title')],
            'job_title' => ['title' => trans('cms::attributes.content.job_title')],
            'rating' => ['title' => trans('cms::attributes.content.rating')],
            'published' => ['title' => trans('cms::attributes.content.published')],
            'published_at' => ['title' => trans('cms::attributes.content.published_at')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
