<?php

namespace Corals\Utility\Webhook\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Traits\ModelPropertiesTrait;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Utility\Webhook\Facades\Webhooks;
use Exception;
use Spatie\Activitylog\Traits\LogsActivity;

class Webhook extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;
    use ModelPropertiesTrait;

    protected $casts = [
        'payload' => 'json',
        'exception' => 'json',
        'properties' => 'json',
    ];

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'utility-webhook.models.webhook';

    protected $guarded = ['id'];

    protected $table = 'utility_webhooks';

    /**
     * @throws Exception
     */
    public function process()
    {
        $this->clearException();

        if (empty($this->event_name)) {
            throw new \Exception(trans("utility-webhook::exceptions.webhook.empty_event_name", ['id' => $this->id]));
        }

        $jobClass = $this->determineJobClass($this->event_name);

        if ($jobClass) {
            dispatch(new $jobClass($this));
        } else {
            throw new \Exception(trans("utility-webhook::exceptions.webhook.event_name_not_registered", ['name' => $this->event_name, 'id' => $this->id]));
        }
    }

    /**
     * @param Exception $exception
     * @return $this
     */
    public function saveException(Exception $exception)
    {
        $this->exception = [
            'message' => $exception->getMessage(),
        ];

        $this->status = 'failed';

        $this->save();

        return $this;
    }

    protected function determineJobClass(string $eventName)
    {
        return Webhooks::getEventJob($eventName);
    }

    protected function clearException()
    {
        $this->exception = null;

        $this->save();

        return $this;
    }

    public function markAs($status)
    {
        $this->fill(['status' => $status])->save();
    }
}
