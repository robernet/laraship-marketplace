<?php

namespace Corals\Utility\Location\Policies;

use Corals\Foundation\Policies\BasePolicy;
use Corals\User\Models\User;
use Corals\Utility\Location\Models\Location;

class LocationPolicy extends BasePolicy
{
    protected $administrationPermission = 'Administrations::admin.utility';

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Utility::location.view')) {
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
        return $user->can('Utility::location.create');
    }

    /**
     * @param User $user
     * @param Location $location
     * @return bool
     */
    public function update(User $user, Location $location)
    {
        if ($user->can('Utility::location.update')) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Location $location
     * @return bool
     */
    public function destroy(User $user, Location $location)
    {
        if ($user->can('Utility::location.delete')) {
            return true;
        }

        return false;
    }
}
