<?php

namespace Corals\Modules\Payment\Common\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Currency extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;

    protected $casts = [
        'active' => 'boolean',
    ];

    public $config = 'payment_common.models.currency';

    protected $guarded = ['id'];
}
