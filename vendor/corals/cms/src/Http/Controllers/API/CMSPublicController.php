<?php

namespace Corals\Modules\CMS\Http\Controllers\API;

use Corals\Foundation\Http\Controllers\APIPublicController;
use Corals\Modules\CMS\Models\Category;
use Corals\Modules\CMS\Services\CMSService;
use Corals\Modules\CMS\Transformers\API\ContentPresenter;
use Illuminate\Http\Request;

class CMSPublicController extends APIPublicController
{
    protected $CMSService;

    public function __construct(CMSService $CMSService)
    {
        $this->CMSService = $CMSService;

        parent::__construct();
    }

    /**
     * @param Request $request
     * @param $type
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getContentListByType(Request $request, $type)
    {
        try {
            $validTypes = ['page', 'post', 'faq', 'news'];

            if (!in_array($type, $validTypes)) {
                throw new \Exception('Invalid type!! type should be of the following: ' . join(', ', $validTypes));
            }

            $contentQuery = $this->CMSService->contentListByType($request, $type);

            return $this->CMSService->paginateResult($contentQuery);
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    public function show(Request $request, $slug)
    {
        try {
            $item = $this->CMSService->show($request, $slug);

            return apiResponse($item);
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    public function getPostsByCategory(Request $request, $slug)
    {
        try {
            return $this->CMSService->getPostsByCategory($request, $slug);
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    public function getPostsByTag(Request $request, $slug)
    {
        try {
            return $this->CMSService->getPostsByTag($request, $slug);
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    /**
     * @param Request $request
     * @param $type
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getCategoriesList(Request $request, $type)
    {
        try {
            return ['categories' => apiPluck(Category::query()->active()->where('belongs_to', $type)
                ->pluck('name', 'slug'), 'value', 'label')];
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    /**
     * @param Request $request
     * @param $type
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getLatestContentListByType(Request $request, $type)
    {
        try {
            $validTypes = ['page', 'post', 'faq', 'news'];

            if (!in_array($type, $validTypes)) {
                throw new \Exception('Invalid type!! type should be of the following: ' . join(', ', $validTypes));
            }

            $contentQuery = $this->CMSService->contentListByType($request, $type);
            $contentQuery = $contentQuery->latest()->take(3);

            return (new ContentPresenter())->present($contentQuery->get());
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    public function getFaqsByCategory(Request $request, $slug)
    {
        try {
            return $this->CMSService->getFaqsByCategory($request, $slug);
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    public function getPagesBySlugs(Request $request)
    {
        try {
            $contentQuery = $this->CMSService->getPagesBySlugs($request);

            return (new ContentPresenter())->present($contentQuery->get());
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }
}
