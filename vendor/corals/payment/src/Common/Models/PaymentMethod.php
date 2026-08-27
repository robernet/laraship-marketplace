<?php

namespace Corals\Modules\Payment\Common\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Traits\ModelPropertiesTrait;
use Corals\Foundation\Transformers\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PaymentMethod extends BaseModel
{
    use PresentableTrait, LogsActivity, ModelPropertiesTrait, SoftDeletes;

    protected $casts = [
        'properties' => 'json',
        'is_default' => 'boolean'
    ];

    protected $table = 'payment_payment_methods';

    protected $guarded = ['id'];

    public function parent()
    {
        return $this->morphTo();
    }
}
