<?php

namespace Corals\Modules\Referral\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class ReferralProgram extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'referral_program.models.referral_program';

    protected $casts = [
        'options' => 'array',
    ];

    protected $guarded = ['id'];

    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = \Str::slug($value);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function referral_links()
    {
        return $this->hasMany(ReferralLink::class);
    }

    public function activeReferralLinks()
    {
        return $this->hasMany(ReferralLink::class)->where('status', 'active');
    }
}
