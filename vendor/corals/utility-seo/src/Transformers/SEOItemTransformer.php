<?php

namespace Corals\Utility\SEO\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Utility\SEO\Models\SEOItem;

class SEOItemTransformer extends BaseTransformer
{
    public function __construct($extras = [])
    {
        $this->resource_url = config('utility-seo.models.seo_item.resource_url');

        parent::__construct($extras);
    }

    /**
     * @param SEOItem $SEOItems
     * @return array
     * @throws \Throwable
     */
    public function transform(SEOItem $SEOItems)
    {
        $transformedArray = [
            'id' => $SEOItems->id,
            'slug' => $SEOItems->slug ?? '-',
            'route' => $SEOItems->route ?? '-',
            'title' => $SEOItems->title,
            'meta_keywords' => $SEOItems->meta_keywords,
            'meta_description' => $SEOItems->meta_description,
            'created_at' => format_date($SEOItems->created_at),
            'updated_at' => format_date($SEOItems->updated_at),
            'action' => $this->actions($SEOItems),
        ];

        return parent::transformResponse($transformedArray);
    }
}
