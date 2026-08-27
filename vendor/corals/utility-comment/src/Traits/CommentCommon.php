<?php

namespace Corals\Utility\Comment\Traits;

trait CommentCommon
{
    protected $commentService;
    protected $commentableClass = null;
    protected $author = null;
    protected $redirectUrl = null;
    protected $successMessage = 'utility-comment::messages.comment.success.add';
    protected $successMessageWithPending = 'utility-comment::messages.comment.success.add_with_pending';
    protected $requireApproval = false;

    protected function setCommonVariables()
    {
        $this->commentableClass = null;
        $this->redirectUrl = null;
    }
}
