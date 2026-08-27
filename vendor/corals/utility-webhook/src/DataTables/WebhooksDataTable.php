<?php

namespace Corals\Utility\Webhook\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Utility\Webhook\Models\Webhook;
use Corals\Utility\Webhook\Transformers\WebhookTransformer;
use Yajra\DataTables\EloquentDataTable;

class WebhooksDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('utility-webhook.models.webhook.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new WebhookTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Webhook $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Webhook $model)
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
            'event_name' => ['title' => trans('utility-webhook::attributes.webhook.event_name')],
            'payload' => ['title' => trans('utility-webhook::attributes.webhook.payload')],
            'exception' => ['title' => trans('utility-webhook::attributes.webhook.exception')],
            'properties' => ['title' => trans('utility-webhook::attributes.webhook.properties')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'created_by' => ['title' => trans('Corals::attributes.created_by')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
        ];
    }

    public function getFilters()
    {
        return [
            'event_name' => ['title' => trans('utility-webhook::attributes.webhook.event_name'), 'class' => 'col-md-3', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'created_at' => ['title' => trans('Corals::attributes.created_at'), 'class' => 'col-md-2', 'type' => 'date', 'active' => true],
        ];
    }

    protected function getBulkActions()
    {
        return [
            'process' => [
                'title' => trans('utility-webhook::labels.webhook.process'),
                'permission' => 'Utility::webhook.process',
                'confirmation' => trans('Corals::labels.confirmation.title'),
            ],
        ];
    }

    protected function getOptions()
    {
        $url = url(config('utility-webhook.models.webhook.resource_url'));

        return ['resource_url' => $url];
    }

    protected function getBuilderParameters(): array
    {
        return ['order' => [[1, 'desc']]];
    }
}
