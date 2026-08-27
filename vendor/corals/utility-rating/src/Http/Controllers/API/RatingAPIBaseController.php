<?php

namespace Corals\Utility\Rating\Http\Controllers\API;

use Corals\Foundation\Http\Controllers\APIBaseController;
use Corals\Utility\Rating\DataTables\RatingsDataTable;
use Corals\Utility\Rating\Http\Requests\RatingRequest;
use Corals\Utility\Rating\Models\Rating;
use Corals\Utility\Rating\Services\RatingService;
use Corals\Utility\Rating\Traits\RatingCommon;

class RatingAPIBaseController extends APIBaseController
{
    use RatingCommon;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;

        $this->setCommonVariables();

        parent::__construct();
    }

    /**
     * @param RatingRequest $request
     * @param RatingsDataTable $dataTable
     * @return mixed
     */
    public function index(RatingRequest $request, RatingsDataTable $dataTable)
    {
        $ratings = $dataTable->query(new Rating(), $request);

        return $this->ratingService->index($ratings, $dataTable);
    }

    public function createRating(RatingRequest $request, $rateable_hashed_id)
    {
        try {
            $rating = $this->ratingService->createRating($request, $this->rateableClass, $rateable_hashed_id);

            if ($rating->status == 'pending') {
                $message = $this->successMessageWithPending;
            } else {
                $message = $this->successMessage;
            }

            return apiResponse(['status' => $rating->status], trans($message));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }
}
