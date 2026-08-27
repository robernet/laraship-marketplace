<?php

namespace Corals\Modules\Payment\Openpay\Message;

class RefundRequest extends AbstractRequest
{


    public function getData()
    {
        $this->validate('transactionReference', 'amount');

        $data = array();

        $data['amount'] = $this->getAmount();
        $data['description'] = $this->getDescription();
        $data['charge_id'] = $this->getTransactionReference();

        return $data;
    }


    /**
     * @param $data
     * @return \Corals\Modules\Payment\Common\Message\ResponseInterface|void
     */
    public function sendData($data)
    {
        $openpay = $this->getOpenpayInstance();

        $refundData = [
            'amount' => $data['amount'],
            'description' => $data['description'] ?? 'Order Refund'
        ];

        $charge = $openpay->charges->get($data['charge_id']);

        $response = $charge->refund($refundData);

        return new RefundResponse($this, $response);
    }
}
