<?php

namespace Corals\Utility\Comment\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Utility\Comment\Traits\ModelHasComments;

class Comment extends BaseModel
{
    use PresentableTrait;
    use ModelHasComments;

    public static function htmlentitiesExcluded($key = null)
    {
        return false;
    }

    /**
     * @var string
     */
    protected $table = 'utility_comments';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'utility-comment.models.comment';
    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'properties' => 'json',
        'is_private' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    public function author()
    {
        return $this->morphTo();
    }

    public function scopeComments($query, $commentable_id, $commentable_type)
    {
        return $query->where('commentable_id', $commentable_id)->where('commentable_type', $commentable_type);
    }

    public function getIdentifier($key = null)
    {
        return 'Comment';
    }
}
