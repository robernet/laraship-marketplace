<?php

namespace Corals\Modules\Marketplace\Http\Controllers;

use Corals\Modules\Marketplace\Models\Product;
use Corals\Utility\Rating\Http\Controllers\RatingBaseController;

class RatingController extends RatingBaseController
{
    protected function setCommonVariables()
    {
        $this->rateableClass = Product::class;
    }
}
