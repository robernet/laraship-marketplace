<?php

namespace Corals\Utility\Wishlist\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class WishlistPresenter extends FractalPresenter
{
    /**
     * @return WishlistTransformer|\League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new WishlistTransformer();
    }
}
