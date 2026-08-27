<?php

namespace Corals\Modules\CMS\Policies;

use Corals\Foundation\Policies\BasePolicy;
use Corals\Modules\CMS\Models\Post;
use Corals\User\Models\User;

class PostPolicy extends BasePolicy
{
    protected $administrationPermission = 'Administrations::admin.cms';

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('CMS::post.view')) {
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
        return $user->can('CMS::post.create');
    }

    /**
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        if ($user->can('CMS::post.update')) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function destroy(User $user, Post $post)
    {
        if ($user->can('CMS::post.delete')) {
            return true;
        }

        return false;
    }
}
