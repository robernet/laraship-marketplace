<?php

namespace Corals\Modules\CMS\Transformers\API;

use Corals\Foundation\Transformers\APIBaseTransformer;
use Corals\Modules\CMS\Facades\CMS;
use Corals\Modules\CMS\Models\Content;

class ContentTransformer extends APIBaseTransformer
{
    /**
     * @param Content $content
     * @return array
     * @throws \Throwable
     */
    public function transform(Content $content)
    {
        $featured_image = CMS::getContentFeaturedImage($content);
        $content = $content->toContentType();
        $auther = $content->author;

        $transformedArray = [
            'id' => $content->id,
            'title' => $content->title,
            'content' => $content->content,
            'slug' => ($content->internal ? 'cms/' : '') . $content->slug,
            'published' => $content->published,
            'meta_keywords' => $content->meta_keywords,
            'meta_description' => $content->meta_description,
            'published_at' => $content->published ? format_date($content->published_at) : '-',
            'published_at_show' => $content->published ? $content->published_at->format('m/d/Y') : '-',
            'categories' => $content->categories ? apiPluck($content->categories->pluck('name', 'slug'),
                'value', 'label') : [],
            'tags' => $content->tags ? $content->tags->pluck('name')->toArray() : [],
            'private' => $content->private,
            'internal' => $content->internal,
            'featured_image' => $featured_image,
            'author' => ['full_name' => $auther->name . ' ' . $auther->last_name,
                'picture_thumb' => $auther->picture_thumb],
            'created_at' => format_date($content->created_at),
            'updated_at' => format_date($content->updated_at),
        ];

        return parent::transformResponse($transformedArray);
    }
}
