<?php

namespace Corals\Modules\Payment\Openpay;

use Corals\Modules\Payment\Common\AbstractGateway;
use Corals\Modules\Payment\Facades\Payments;
use Corals\Settings\Facades\Settings;
use Corals\User\Models\User;
use Illuminate\Http\Request;
use Openpay\Data\Openpay;

/**
 * Openpay Gateway.
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Openpay';
    }

    public function setAuthentication()
    {
        $public_key = '';
        $merchant_id = '';
        $private_key = '';

        $sandbox = Settings::get('payment_openpay_sandbox_mode', 'true');
        $countryCode = Settings::get('payment_openpay_country_code', 'co');

        if ($sandbox == 'true') {
            $this->setTestMode(true);
            $merchant_id = Settings::get('payment_openpay_sandbox_merchant_id');
            $public_key = Settings::get('payment_openpay_sandbox_public_key');
            $private_key = Settings::get('payment_openpay_sandbox_private_key');
        } elseif ($sandbox == 'false') {
            $this->setTestMode(false);
            $merchant_id = Settings::get('payment_openpay_live_merchant_id');
            $public_key = Settings::get('payment_openpay_live_public_key');
            $private_key = Settings::get('payment_openpay_live_private_key');
        }

        $this->setMerchantId($merchant_id);
        $this->setPublicKey($public_key);
        $this->setPrivateKey($private_key);
        $this->setCountryCode($countryCode);

        Openpay::setProductionMode(!$this->getTestMode());
        Openpay::setId($merchant_id);
        Openpay::setApiKey($private_key);

        $openpay = Openpay::getInstance($merchant_id, $private_key, strtoupper($countryCode));

        $this->setOpenpayInstance($openpay);
    }

    public function getDefaultParameters()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->getParameter('countryCode');
    }

    /**
     * @param $value
     * @return void
     */
    public function setCountryCode($value)
    {
        $this->setParameter('countryCode', $value);
    }

    /**
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->getParameter('PublicKey');
    }

    /**
     * @param $value
     * @return void
     */
    public function setPublicKey($value)
    {
        $this->setParameter('PublicKey', $value);
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @param $value
     * @return void
     */
    public function setMerchantId($value)
    {
        $this->setParameter('merchantId', $value);
    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    /**
     * @param $value
     * @return void
     */
    public function setPrivateKey($value)
    {
        $this->setParameter('privateKey', $value);
    }

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

    public function getPaymentViewName($type = null)
    {
        return "Openpay::ecommerce-checkout";
    }

    public function loadScripts()
    {
        return view("Openpay::scripts")->render();
    }

    public static function webhookHandler(Request $request)
    {
    }

    protected function getCurrencyAndAmount($order, $amount = null)
    {
        $amount = $amount ?? $order->amount;

        $countryCode = $this->getCountryCode();
        $currency = strtolower($order->currency);

        switch ($countryCode) {
            case 'mx':
                $currency = 'MXN';
                break;
            case 'co':
                $currency = 'COP';
                break;
            case 'pe':
                $currency = 'PEN';
                break;
        }

        if (strtolower($order->currency) != strtolower($currency)) {
            $amount = Payments::currency_convert($amount, $order->currency, $currency);
        }

        return ['currency' => $currency, 'amount' => $amount];
    }

    public function prepareCreateMultiOrderChargeParameters($orders, User $user, $checkoutDetails)
    {
        $amount = 0;

        $description = "Order # ";

        foreach ($orders as $order) {
            $amount += $order->amount;
            $description .= $order->order_number . ",";
        }

        $order = current($orders);

        //TODO Remove the hardcoded amount and pass the $amount
        $result = $this->getCurrencyAndAmount($order, 2);

        return [
            'amount' => $result['amount'],
            'currency' => $result['currency'],
            'token' => $checkoutDetails['token'],
            'description' => trim($description, ' ,'),
            'customer' => [
                'name' => data_get($order, 'billing.billing_address.first_name'),
                'last_name' => data_get($order, 'billing.billing_address.last_name'),
                'email' => data_get($order, 'billing.billing_address.email'),
            ]
        ];
    }

    public function prepareCreateChargeParameters($order, User $user, $checkoutDetails)
    {
        $result = $this->getCurrencyAndAmount($order);

        return [
            'amount' => $result['amount'],
            'currency' => $result['currency'],
            'token' => $checkoutDetails['token'],
            'description' => 'Order #' . $order->id,
            'order_id' => $order->order_number,
            'customer' => [
                'name' => data_get($order, 'billing.billing_address.first_name'),
                'last_name' => data_get($order, 'billing.billing_address.last_name'),
                'email' => data_get($order, 'billing.billing_address.email'),
            ]
        ];
    }

    public function prepareCreateRefundParameters($order, $amount)
    {
        $result = $this->getCurrencyAndAmount($order, $amount);

        return [
            'currency' => $result['currency'],
            'amount' => $result['amount'],
            'transactionReference' => $order->billing['payment_reference'],
        ];
    }

    /**
     * @param array $parameters
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function createCharge(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Openpay\Message\ChargeRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Openpay\Message\RefundRequest', $parameters);
    }
}
