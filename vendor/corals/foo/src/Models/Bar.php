<?php

namespace Corals\Modules\Foo\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Bar extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'foo.models.bar';

    protected $casts = [
        'properties' => 'json',
    ];

    protected $table = 'foo_bars';

    protected $guarded = ['id'];
}
