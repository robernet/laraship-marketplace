<?php

namespace Corals\Utility\Rating\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Utility\Rating\Models\Rating;
use Corals\Utility\Rating\Transformers\RatingTransformer;
use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;

class RatingsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('utility-rating.models.rating.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new RatingTransformer());
    }

    /**
     * @param Rating $model
     * @param Request $request
     * @return mixed
     */
    public function query(Rating $model, Request $request)
    {
        if (! isSuperUser()) {
            return $model->reviews()->newQuery();
        } else {
            return $model->newQuery();
        }
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
            'rating' => ['title' => trans('utility-rating::attributes.rating.rating')],
            'title' => ['title' => trans('utility-rating::attributes.rating.title')],
            'body' => ['title' => trans('utility-rating::attributes.rating.body')],
            'reviewrateable_id' => ['title' => trans('utility-rating::attributes.rating.model')],
            'reviewrateable_type' => ['title' => trans('utility-rating::attributes.rating.type')],
            'author_id' => ['title' => trans('utility-rating::attributes.rating.author')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'comments_count' => ['title' => trans('utility-rating::attributes.rating.comments_count')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
        ];
    }

    public function getFilters()
    {
        return [
            'title' => ['title' => trans('utility-rating::attributes.rating.title'), 'class' => 'col-md-3', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'rating' => ['title' => trans('utility-rating::attributes.rating.rating'), 'class' => 'col-md-2', 'type' => 'select', 'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5], 'active' => true],
        ];
    }

    protected function getBulkActions()
    {
        return [
            'delete' => ['title' => trans('Corals::labels.delete'), 'permission' => 'Utility::rating.delete', 'confirmation' => trans('Corals::labels.confirmation.title')],
            'pending' => ['title' => trans('utility-rating::attributes.rating.status_options.pending'), 'permission' => 'Utility::rating.update', 'confirmation' => trans('Corals::labels.confirmation.title')],
            'approved' => ['title' => trans('utility-rating::attributes.rating.status_options.approved'), 'permission' => 'Utility::rating.update', 'confirmation' => trans('Corals::labels.confirmation.title')],
            'disapproved' => ['title' => trans('utility-rating::attributes.rating.status_options.disapproved'), 'permission' => 'Utility::rating.update', 'confirmation' => trans('Corals::labels.confirmation.title')],
            'spam' => ['title' => trans('utility-rating::attributes.rating.status_options.spam'), 'permission' => 'Utility::rating.update', 'confirmation' => trans('Corals::labels.confirmation.title')],
        ];
    }

    protected function getOptions()
    {
        $url = url(config('utility-rating.models.rating.resource_url'));

        return ['resource_url' => $url];
    }
}
