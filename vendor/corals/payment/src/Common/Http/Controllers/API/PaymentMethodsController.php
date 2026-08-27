<?php


namespace Corals\Modules\Payment\Common\Http\Controllers\API;

use Corals\Foundation\Http\Controllers\APIBaseController;
use Corals\Modules\Payment\Common\Http\Requests\PaymentMethodRequest;
use Corals\Modules\Payment\Common\Models\PaymentMethod;
use Corals\Modules\Payment\Common\Services\PaymentMethodService;


class PaymentMethodsController extends APIBaseController
{
    /**
     * PaymentMethodsController constructor.
     * @param PaymentMethodService $paymentMethodService
     */
    public function __construct(protected PaymentMethodService $paymentMethodService)
    {
        parent::__construct();
    }

    /**
     * @param PaymentMethodRequest $request
     * @param PaymentMethod $paymentMethod
     * @return mixed
     */
    public function destroy(PaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        try {

            $this->paymentMethodService->destroy($request, $paymentMethod);

            return apiResponse([], trans('Corals::messages.success.deleted', ['item' => $paymentMethod->last_four]));
        } catch (\Exception $e) {
            return apiExceptionResponse($e);
        }
    }
}
