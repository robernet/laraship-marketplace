<?php

namespace Corals\Modules\Payment\Common\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Tax extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'payment_common.models.tax';

    protected $guarded = ['id'];

    public function tax_class()
    {
        return $this->belongsTo(TaxClass::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
