<?php

namespace Corals\Modules\Payment\Openpay\Message;

use Corals\Modules\Payment\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Abstract Request.
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    /**
     * @return mixed
     */
    public function getOpenpayInstance()
    {
        return $this->getParameter('openpayInstance');
    }

    /**
     * @param $value
     * @return void
     */
    public function setOpenpayInstance($value)
    {
        $this->setParameter('openpayInstance', $value);
    }

    public function getAmount()
    {
        return round($this->getParameter('amount'));
    }
}
