<?php

namespace Corals\Utility\Comment\Policies;

use Corals\Foundation\Policies\BasePolicy;
use Corals\User\Models\User;
use Corals\Utility\Comment\Models\Comment;

class CommentPolicy extends BasePolicy
{
    protected $administrationPermission = 'Administrations::admin.utility';

    protected $skippedAbilities = ['updateStatus', 'create'];

    public function updateStatus(User $user, Comment $comment = null, $status = null)
    {
        if ($comment->status == $status) {
            return false;
        }

        return $user->can('Utility::comment.set_status');
    }

    public function create(User $user)
    {
        return $user->can('Utility::comment.create');
    }

    public function view(User $user)
    {
        return $user->can('Utility::comment.view');
    }

    public function destroy(User $user, Comment $comment)
    {
        return $user->can('Utility::comment.delete');
    }

    public function seePrivateComments(User $user, Comment $comment = null)
    {
        return $user->can('Utility::comment.can_see_private_comments')
            || ($comment && $comment->author_id == $user->id);
    }
}
