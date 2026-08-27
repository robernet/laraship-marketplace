<?php

namespace Corals\Utility\Wishlist\Traits;

trait WishlistCommon
{
    protected $wishlistableClass = null;
    protected $redirectUrl = null;
    protected $addSuccessMessage = 'utility-wishlist::messages.wishlist.success.add';
    protected $deleteSuccessMessage = 'utility-wishlist::messages.wishlist.success.delete';
    protected $requireLoginMessage = 'utility-wishlist::messages.wishlist.require_login';
    protected $wishlistService;

    protected function setCommonVariables()
    {
        $this->wishlistableClass = null;
        $this->redirectUrl = null;
    }
}
