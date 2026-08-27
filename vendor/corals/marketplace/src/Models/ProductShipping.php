<?php

namespace Corals\Modules\Marketplace\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductShipping extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $table = 'marketplace_shippings';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('productScope', function (Builder $builder) {
            $builder->whereNotNull('product_id');
        });
    }

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'marketplace.models.shipping';

    protected $guarded = ['id'];

    protected $casts = [
        'properties' => 'json',
        'start' => 'datetime',
        'expiry' => 'datetime'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
