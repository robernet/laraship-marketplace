<?php

namespace Corals\Modules\Payment\Common\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Payment\Common\Models\PaymentMethod;

class PaymentMethodRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(PaymentMethod::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [

            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, []);
        }

        if ($this->isUpdate()) {
            $paymentMethod = $this->route('payment_method');
            $rules = array_merge($rules, []);
        }

        return $rules;
    }

}
