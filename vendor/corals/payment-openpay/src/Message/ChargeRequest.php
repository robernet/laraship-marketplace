<?php

namespace Corals\Modules\Payment\Openpay\Message;

use Corals\Modules\Payment\Common\Exception\InvalidResponseException;
use Illuminate\Support\Str;

/**
 * Openpay Charges Request.
 */
class ChargeRequest extends AbstractRequest
{

    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    public function setOrderId($orderId)
    {
        return $this->setParameter('orderId', $orderId);
    }

    public function getCustomer()
    {
        return $this->getParameter('customer');
    }

    public function setCustomer($value)
    {
        return $this->setParameter('customer', $value);
    }


    /**
     * {@inheritdoc}
     *
     * @return mixed
     *
     * @throws InvalidResponseException
     */
    public function getData()
    {
        $this->validate('amount', 'currency', 'token', 'description');

        $data = array();
        $data['method'] = 'card';
        $data['amount'] = $this->getAmount();
        $data['source_id'] = $this->getToken();
        $data['currency'] = $this->getCurrency();
        $data['description'] = $this->getDescription();
        $data['order_id'] = $this->getOrderId() . '_' . Str::random(3);
        $data['customer'] = $this->getCustomer();
        $data['device_session_id'] = Str::random();
        return $data;
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $data
     *
     * @return ChargeResponse
     */
    public function sendData($data)
    {
        $charge = $this->getOpenpayInstance()->charges->create($data);

        return new ChargeResponse($this, $charge);
    }
}
