<?php

namespace Corals\Utility\ListOfValue\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ListOfValuePresenter extends FractalPresenter
{
    /**
     * @param array $extras
     * @return ListOfValueTransformer|\League\Fractal\TransformerAbstract
     */
    public function getTransformer($extras = [])
    {
        return new ListOfValueTransformer($extras);
    }
}
