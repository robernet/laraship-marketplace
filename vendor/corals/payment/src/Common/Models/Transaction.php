<?php

namespace Corals\Modules\Payment\Common\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Traits\ModelUniqueCode;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;
    use ModelUniqueCode;

    protected $table = 'payment_transactions';

    protected $propertiesColumn = 'extra';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'payment_common.models.transaction';

    protected $casts = [
        'extra' => 'json',
    ];

    protected $guarded = ['id'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get all of the owning invoicable models.
     */
    public function sourcable()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the owning invoicable models.
     */
    public function owner()
    {
        return $this->morphTo();
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
