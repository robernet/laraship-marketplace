<?php

namespace Corals\Modules\Payment\Openpay\Message;

use Corals\Modules\Payment\Common\Message\AbstractResponse;

/**
 * Openpay Complete Purchase Response.
 */
class ChargeResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return $this->data->status == 'completed';
    }

    /**
     * @return array|null
     * @see \Corals\Modules\Payment\Openpay\Message\Response::getTransactionReference()
     */
    public function getChargeReference()
    {
        return $this->data->id;
    }

    /**
     * Transaction reference returned by openpay or null on payment failure.
     *
     * @return mixed|null
     */
    public function getTransactionReference()
    {
        return $this->data->id;
    }
}
