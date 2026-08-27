<?php

namespace Corals\Utility\Category\Policies;

use Corals\Foundation\Policies\BasePolicy;
use Corals\User\Models\User;
use Corals\Utility\Category\Models\Attribute;

class AttributePolicy extends BasePolicy
{
    protected $administrationPermission = 'Administrations::admin.utility';

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Utility::attribute.view')) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('Utility::attribute.create');
    }

    /**
     * @param User $user
     * @param Attribute $attribute
     * @return bool
     */
    public function update(User $user, Attribute $attribute)
    {
        if ($user->can('Utility::attribute.update')) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Attribute $attribute
     * @return bool
     */
    public function destroy(User $user, Attribute $attribute)
    {
        if ($user->can('Utility::attribute.delete')) {
            return true;
        }

        return false;
    }
}
