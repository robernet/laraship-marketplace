<?php

namespace Corals\Utility\Comment\Http\Controllers\API;

use Corals\Foundation\Http\Controllers\APIBaseController;
use Corals\Utility\Comment\Http\Requests\CommentRequest;
use Corals\Utility\Comment\Models\Comment;
use Corals\Utility\Comment\Services\CommentService;
use Corals\Utility\Comment\Traits\CommentCommon;

class CommentAPIBaseController extends APIBaseController
{
    use CommentCommon;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;

        $this->setCommonVariables();

        parent::__construct();
    }

    /**
     * @param CommentRequest $request
     * @param $commentable_hashed_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function createComment(CommentRequest $request, $commentable_hashed_id)
    {
        try {
            $this->commentService->createComment($request, $this->commentableClass, $commentable_hashed_id);

            return apiResponse([], trans($this->successMessage));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    public function replyComment(CommentRequest $request, Comment $comment)
    {
        try {
            $this->commentService->replyComment($request, $comment);

            return apiResponse([], trans($this->successMessage));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }
}
