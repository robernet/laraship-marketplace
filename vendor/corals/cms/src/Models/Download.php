<?php

namespace Corals\Modules\CMS\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;

class Download extends Content
{
    use Sluggable;

    public function getModuleName()
    {
        return 'CMS';
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'download');
        });
    }

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'cms.models.download';

    protected $table = 'posts';

    protected $attributes = [
        'type' => 'download',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
            ],
        ];
    }

    protected $fillable = ['title', 'content', 'published', 'published', 'author_id'];

    public $mediaCollectionName = 'cms-download-files';

    /**
     * @return array
     */
    public function getFiles()
    {
        $medias = $this->getMedia($this->mediaCollectionName);

        $downloads = [];

        foreach ($medias as $item) {
            $downloads[$item->id] = [
                'description' => $item->getCustomProperty('description'),
                'name' => $item->name,
                'hashed_id' => hashids_encode($item->id),
                'downloads_count' => $item->getCustomProperty('downloads_count', 1),
            ];
        }

        return $downloads;
    }
}
