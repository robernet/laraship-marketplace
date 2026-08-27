<?php

namespace Corals\Modules\Payment\Common\Policies;

use Corals\Foundation\Policies\BasePolicy;
use Corals\Modules\Payment\Common\Models\PaymentMethod;
use Corals\User\Models\User;

class PaymentMethodPolicy extends BasePolicy
{
    protected $administrationPermission = 'Administrations::admin.payment';

    /**
     * @param User $user
     * @param PaymentMethod|null $paymentMethod
     * @return bool
     */
    public function view(User $user, PaymentMethod $paymentMethod = null)
    {
        return true;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * @param User $user
     * @param PaymentMethod $paymentMethod
     * @return bool
     */
    public function update(User $user, PaymentMethod $paymentMethod)
    {
        return true;
    }

    /**
     * @param User $user
     * @param PaymentMethod $paymentMethod
     * @return bool
     */
    public function destroy(User $user, PaymentMethod $paymentMethod)
    {
        return $paymentMethod->parent_id === $user->id;
    }
}
