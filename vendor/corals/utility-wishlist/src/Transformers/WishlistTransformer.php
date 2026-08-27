<?php

namespace Corals\Utility\Wishlist\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Utility\Wishlist\Models\Wishlist;

class WishlistTransformer extends BaseTransformer
{
    public function __construct($extras = [])
    {
        $this->resource_url = config('utility-wishlist.models.wishlist.resource_url');

        parent::__construct($extras);
    }

    /**
     * @param Wishlist $wishlist
     * @return array
     * @throws \Throwable
     */
    public function transform(Wishlist $wishlist)
    {
        $transformedArray = [
            'object' => '<a href="' . $wishlist->wishlistable->getShowURL() . '" target="_blank">' . $wishlist->wishlistable->getIdentifier() . '</a>',
            'id' => $wishlist->id,
            'user_id' => $wishlist->user->full_name,
            'created_at' => format_date($wishlist->created_at),
            'action' => $this->actions($wishlist),
        ];

        return parent::transformResponse($transformedArray);
    }
}
