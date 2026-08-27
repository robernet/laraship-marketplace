<?php

namespace Corals\Modules\Slider\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slide extends BaseModel implements HasMedia
{
    use PresentableTrait;
    use LogsActivity;
    use InteractsWithMedia ;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'slider.models.slide';

    protected $guarded = ['id'];

    public function slider()
    {
        return $this->belongsTo(Slider::class);
    }
}
