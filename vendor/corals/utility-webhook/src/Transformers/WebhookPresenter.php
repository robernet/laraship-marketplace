<?php

namespace Corals\Utility\Webhook\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class WebhookPresenter extends FractalPresenter
{
    /**
     * @return WebhookTransformer|\League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new WebhookTransformer();
    }
}
