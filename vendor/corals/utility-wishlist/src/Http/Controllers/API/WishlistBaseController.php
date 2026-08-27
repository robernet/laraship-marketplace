<?php

namespace Corals\Utility\Wishlist\Http\Controllers\API;

use Corals\Foundation\Http\Controllers\APIBaseController;
use Corals\Utility\Wishlist\Models\Wishlist;
use Corals\Utility\Wishlist\Services\WishlistService;
use Illuminate\Http\Request;

class WishlistBaseController extends APIBaseController
{
    protected $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;

        parent::__construct();
    }

    /**
     * @param Request $request
     * @param Wishlist $wishlist
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Wishlist $wishlist)
    {
        try {
            $wishlistable_type = class_basename($wishlist->wishlistable_type);

            $this->wishlistService->destroy($request, $wishlist);

            return apiResponse([], trans('Corals::messages.success.deleted', ['item' => $wishlistable_type]));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }
}
