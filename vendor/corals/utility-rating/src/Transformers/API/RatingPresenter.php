<?php

namespace Corals\Utility\Rating\Transformers\API;

use Corals\Foundation\Transformers\FractalPresenter;

class RatingPresenter extends FractalPresenter
{
    /**
     * @return RatingTransformer|\League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RatingTransformer();
    }
}
