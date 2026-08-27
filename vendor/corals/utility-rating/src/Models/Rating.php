<?php

namespace Corals\Utility\Rating\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\User\Models\User;
use Corals\Utility\Comment\Traits\ModelHasComments;

class Rating extends BaseModel
{
    use ModelHasComments;
    use PresentableTrait;

    /**
     * @var string
     */
    protected $table = 'utility_ratings';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'utility-rating.models.rating';
    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'properties' => 'json',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function reviewrateable()
    {
        return $this->morphTo();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('utility_ratings.status', 'approved');
    }

    public function scopeReviews($query)
    {
        return $query->where('author_id', user()->id)->where('author_type', get_class(user()));
    }

    public function canBePending()
    {
        return in_array($this->status, ['approved', 'disapproved', 'spam']);
    }

    public function canBeApproved()
    {
        return in_array($this->status, ['disapproved', 'pending', 'spam']);
    }

    public function canBeDisApproved()
    {
        return in_array($this->status, ['approved', 'pending', 'spam']);
    }

    public function canBeSpam()
    {
        return in_array($this->status, ['approved', 'pending', 'disapproved']);
    }

    public function ratable()
    {
        return $this->morphTo('reviewrateable');
    }
}
