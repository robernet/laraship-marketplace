<?php

namespace Corals\Modules\Payment\Common\Transformers\API;

use Corals\Foundation\Transformers\FractalPresenter;

class PaymentMethodPresenter extends FractalPresenter
{
    public function getTransformer()
    {
        return new PaymentMethodTransformer;
    }
}
