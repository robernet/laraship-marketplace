<?php

namespace Corals\Utility\ListOfValue\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Traits\Cache\Cachable;
use Corals\Foundation\Traits\ModelPropertiesTrait;
use Corals\Foundation\Traits\ModelUniqueCode;
use Corals\Foundation\Transformers\PresentableTrait;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ListOfValue extends BaseModel implements HasMedia
{
    use PresentableTrait;
    use LogsActivity;
    use ModelPropertiesTrait;
    use ModelUniqueCode;
    use Cachable;
    use InteractsWithMedia;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'utility-lov.models.listOfValue';

    protected $table = 'utility_list_of_values';

    protected $casts = [
        'properties' => 'json',
    ];

    public $guarded = ['id'];
    public $mediaCollectionName = 'utility-listOfvalue-thumbnail';

    public function scopeWithModule(Builder $query, string $module = null): Builder
    {
        if (is_null($module)) {
            return $query;
        }

        return $query->where('module', $module);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function parent()
    {
        return $this->belongsTo(ListOfValue::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(ListOfValue::class, 'parent_id', 'id');
    }

    public function getLabelAttribute()
    {
        if (empty($this->attributes['label'])) {
            return data_get($this->attributes, 'value');
        } else {
            return data_get($this->attributes, 'label');
        }
    }
}
