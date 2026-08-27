<?php

namespace Corals\Modules\Marketplace\Http\Controllers\API;

use Corals\Modules\Marketplace\Models\Product;
use Corals\Utility\Rating\Http\Controllers\API\RatingAPIBaseController;

class RatingController extends RatingAPIBaseController
{
    protected function setCommonVariables()
    {
        $this->rateableClass = Product::class;
    }
}
