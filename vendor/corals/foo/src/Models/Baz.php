<?php

namespace Corals\Modules\Foo\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Baz extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    protected $formModalConfig = ['size' => 'modal-lg'];

    public $config = 'foo.models.baz';

    protected $casts = [
        'properties' => 'json',
    ];

    protected $table = 'foo_bazs';

    protected $guarded = ['id'];
}
