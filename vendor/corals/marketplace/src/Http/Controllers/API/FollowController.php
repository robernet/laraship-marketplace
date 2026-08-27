<?php

namespace Corals\Modules\Marketplace\Http\Controllers\API;

use Corals\Modules\Marketplace\Models\Store;
use Corals\Utility\Wishlist\Http\Controllers\API\WishlistAPIBaseController;

class FollowController extends WishlistAPIBaseController
{
    protected function setCommonVariables()
    {
        $this->wishlistableClass = Store::class;
    }
}
