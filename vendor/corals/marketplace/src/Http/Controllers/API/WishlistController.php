<?php

namespace Corals\Modules\Marketplace\Http\Controllers\API;

use Corals\Modules\Marketplace\Models\Product;
use Corals\Utility\Wishlist\Http\Controllers\API\WishlistAPIBaseController;

class WishlistController extends WishlistAPIBaseController
{
    protected function setCommonVariables()
    {
        $this->wishlistableClass = Product::class;
    }
}
