<?php

namespace Corals\Utility\Wishlist\Http\Controllers\API;

use Corals\Foundation\Http\Controllers\APIBaseController;
use Corals\Utility\Wishlist\DataTables\Scopes\MyWishlistScope;
use Corals\Utility\Wishlist\DataTables\Scopes\WishlistTypeScope;
use Corals\Utility\Wishlist\DataTables\WishlistDataTable;
use Corals\Utility\Wishlist\Models\Wishlist;
use Corals\Utility\Wishlist\Services\WishlistService;
use Corals\Utility\Wishlist\Traits\WishlistCommon;
use Illuminate\Http\Request;

class WishlistAPIBaseController extends APIBaseController
{
    use WishlistCommon;

    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;

        $this->setCommonVariables();

        parent::__construct();
    }

    public function setWishlist(Request $request, $wishlistable_hashed_id)
    {
        try {
            [$state, $wishlistable] = $this->wishlistService->setWishlist($wishlistable_hashed_id, $this->wishlistableClass, $this->requireLoginMessage);

            if ($state == 'add') {
                return apiResponse(['state' => $state], trans($this->addSuccessMessage, ['item' => class_basename($this->wishlistableClass)]));
            } else {
                return apiResponse(['state' => $state], trans($this->deleteSuccessMessage, ['item' => class_basename($this->wishlistableClass)]));
            }
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    /**
     * @param Request $request
     * @param WishlistDataTable $dataTable
     * @return mixed
     */
    public function myWishlist(Request $request, WishlistDataTable $dataTable)
    {
        $dataTable->addScope(new MyWishlistScope(user()));
        $dataTable->addScope(new WishlistTypeScope($this->wishlistableClass));

        $wishlist = $dataTable->query(new Wishlist());

        return $this->wishlistService->index($wishlist, $dataTable);
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
