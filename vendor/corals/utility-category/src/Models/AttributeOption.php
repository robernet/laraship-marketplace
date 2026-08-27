<?php

namespace Corals\Utility\Category\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class AttributeOption extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;

    public $timestamps = false;

    protected $table = 'utility_attribute_options';


    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'utility-category.models.attribute_option';


    protected $guarded = [];

    protected $casts = [
        'properties' => 'json',
    ];

    public function attribute()
    {
        return $this->belongsToMany(Attribute::class);
    }
}
