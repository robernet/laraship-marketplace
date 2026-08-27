<?php

namespace Corals\Modules\Payment\Common\Transformers\API;

use Corals\Foundation\Transformers\APIBaseTransformer;
use Corals\Modules\Payment\Common\Models\PaymentMethod;

class PaymentMethodTransformer extends APIBaseTransformer
{
    /**
     * @param PaymentMethod $paymentMethod
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function transform(PaymentMethod $paymentMethod)
    {
        $transformedArray = [
            'id' => $paymentMethod->id,
            'last4' => $paymentMethod->last_four,
            'gateway' => $paymentMethod->gateway,
            'reference_id' => $paymentMethod->reference_id,
            'status' => $paymentMethod->status,
            'expiry_month' => $paymentMethod->expiry_month,
            'expiry_year' => $paymentMethod->expiry_year,
            'brand' => $paymentMethod->brand,
            'created_at' => format_date($paymentMethod->created_at),
            'updated_at' => format_date($paymentMethod->updated_at),
        ];

        return parent::transformResponse($transformedArray);
    }
}
