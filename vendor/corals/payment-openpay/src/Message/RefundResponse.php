<?php

namespace Corals\Modules\Payment\Openpay\Message;

use Corals\Modules\Payment\Common\Message\AbstractResponse;
use Corals\Modules\Payment\Common\Message\ResponseInterface;

/**
 * Response.
 */
class RefundResponse extends AbstractResponse implements ResponseInterface
{
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->data->status == 'completed';
    }
}
