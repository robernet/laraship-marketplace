<?php

namespace Corals\Utility\Webhook\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Foundation\Http\Requests\BulkRequest;
use Corals\Utility\Webhook\DataTables\WebhooksDataTable;
use Corals\Utility\Webhook\Http\Requests\WebhookRequest;
use Corals\Utility\Webhook\Models\Webhook;
use Illuminate\Http\Request;

class WebhooksController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('utility-webhook.models.webhook.resource_url');

        $this->resource_model = new Webhook();

        $this->title = 'utility-webhook::module.webhook.title';
        $this->title_singular = 'utility-webhook::module.webhook.title_singular';
        $this->corals_middleware_except = array_merge($this->corals_middleware_except, ['submitEvent']);

        parent::__construct();
    }

    public function submitEvent(Request $request, $event)
    {
        try {
            $webhook = null;

            $eventPayload = $request->input();

            $data = [
                'event_name' => $event,
                'payload' => $eventPayload,
            ];

            $webhook = Webhook::query()->create($data);

            $webhook->process();

            return apiResponse([], trans('utility-webhook::messages.webhook.event_submitted_successfully', ['name' => $event]));
        } catch (\Exception $exception) {
            if ($webhook) {
                $webhook->saveException($exception);
            }

            return apiExceptionResponse($exception);
        }
    }

    public function index(WebhookRequest $request, WebhooksDataTable $dataTable)
    {
        return $dataTable->render('utility-webhook::webhooks.index');
    }

    /**
     * @param BulkRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function bulkAction(BulkRequest $request)
    {
        $this->authorize('Administrations::admin.utility');

        try {
            $action = $request->input('action');
            $selection = json_decode($request->input('selection'), true);

            $processed = 0;
            $failed = 0;
            $message = [];
            switch ($action) {
                case 'process':
                    foreach ($selection as $selection_id) {
                        try {
                            $webhook = Webhook::findByHash($selection_id);

                            if (user()->cannot('process', $webhook)) {
                                continue;
                            }

                            $webhook_request = new WebhookRequest();
                            $webhook_request->setMethod('POST');
                            $webhook_request->merge(['throw_exception' => true]);

                            $this->process($webhook_request, $webhook);

                            $processed++;
                        } catch (\Exception $exception) {
                            $failed++;
                        }
                    }

                    $message = [
                        'level' => 'success',
                        'message' => trans(
                            'utility-webhook::messages.webhook.bulk_processed',
                            ['processed_count' => $processed, 'failed_count' => $failed]
                        ),
                    ];

                    break;
            }
        } catch (\Exception $exception) {
            log_exception($exception, WebhooksController::class, 'bulkAction');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    public function process(WebhookRequest $request, Webhook $webhook)
    {
        try {
            $webhook->process();
            $message = ['level' => 'success', 'message' => trans('utility-webhook::messages.webhook.processed')];
        } catch (\Exception $exception) {
            if ($webhook) {
                $webhook->saveException($exception);
            }

            log_exception($exception, 'Webhooks', 'ReProcess');

            if ($request->has('throw_exception')) {
                throw($exception);
            }

            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    public function destroy(WebhookRequest $request, Webhook $webhook)
    {
        try {
            $webhook->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Webhook::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}
