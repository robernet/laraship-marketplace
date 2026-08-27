<?php

namespace Corals\Utility\Category\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class CategoryPresenter extends FractalPresenter
{
    /**
     * @param array $extras
     * @return CategoryTransformer|\League\Fractal\TransformerAbstract
     */
    public function getTransformer($extras = [])
    {
        return new CategoryTransformer($extras);
    }
}
