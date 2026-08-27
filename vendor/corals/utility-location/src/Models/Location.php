<?php

namespace Corals\Utility\Location\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;

class Location extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;
    use Sluggable;

    protected $table = 'utility_locations';

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'utility-location.models.location';

    protected $guarded = ['id'];

    protected $casts = [
        'properties' => 'json',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }
}
