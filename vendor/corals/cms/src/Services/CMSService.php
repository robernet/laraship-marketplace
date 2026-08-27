<?php

namespace Corals\Modules\CMS\Services;

use Corals\Modules\CMS\Models\Category;
use Corals\Modules\CMS\Models\Content;
use Corals\Modules\CMS\Models\Post;
use Corals\Modules\CMS\Transformers\API\ContentPresenter;
use Corals\Utility\Tag\Models\Tag;

class CMSService
{
    public $internalState = false;

    /**
     * @return mixed
     */
    public function getContentQuery()
    {
        $contentQuery = Content::query();

        return $contentQuery;
    }

    /**
     * @param $request
     * @param $categorySlug
     * @return mixed
     * @throws \Exception
     */
    public function getPostsByCategory($request, $categorySlug)
    {
        $category = Category::active()->where('slug', $categorySlug)->first();

        if (! $category) {
            abort(404, 'Not Found!!');
        }

        $posts = $category->posts();

        $posts = $this->applyFilters($request, $posts);

        return $this->paginateResult($posts);
    }

    /**
     * @param $request
     * @param $categorySlug
     * @return mixed
     * @throws \Exception
     */
    public function getFaqsByCategory($request, $categorySlug)
    {
        $category = Category::active()->where('slug', $categorySlug)->first();

        if (! $category) {
            abort(404, 'Not Found!!');
        }

        $posts = $category->faqs();

        $posts = $this->applyFilters($request, $posts);

        return $this->paginateResult($posts);
    }
    /**
     * @param $request
     * @param $tagSlug
     * @return mixed
     * @throws \Exception
     */
    public function getPostsByTag($request, $tagSlug)
    {
        $tag = Tag::active()->where('slug', $tagSlug)->first();

        if (! $tag) {
            abort(404, 'Not Found!!');
        }

        $posts = Post::query()->withAnyTags([$tag->name], 'CMS');

        $posts = $this->applyFilters($request, $posts);

        return $this->paginateResult($posts);
    }

    protected function applyFilters($request, $queryBuilder)
    {
        $queryBuilder->published();

        $queryBuilder->internal($this->internalState);

        if (! user()) {
            $queryBuilder->public();
        }

        $query = strip_tags($request->get('query'));

        if (! empty($query)) {
            $queryBuilder->where(function ($subQuery) use ($query) {
                $subQuery->where('title', 'like', "%$query%")
                    ->orWhere('content', 'like', "%$query%");
            });
        }

        return $queryBuilder;
    }

    /**
     * @param $request
     * @param $type
     * @return mixed
     * @throws \Exception
     */
    public function contentListByType($request, $type)
    {
        $contentQuery = $this->getContentQuery();

        $contentQuery->where('type', $type);

        $contentQuery = $this->applyFilters($request, $contentQuery);

        return $contentQuery;
    }

    /**
     * @param $queryBuilder
     * @return mixed
     * @throws \Exception
     */
    public function paginateResult($queryBuilder)
    {
        $presenter = new ContentPresenter();

        return $presenter->present($queryBuilder->paginate());
    }

    /**
     * @param $request
     * @param $slug
     * @return mixed
     * @throws \Exception
     */
    public function show($request, $slug)
    {
        $contentQuery = $this->getContentQuery();

        $contentQuery = $this->applyFilters($request, $contentQuery);

        $item = $contentQuery->where('slug', \Str::slug($slug))->first();

        if (! $item) {
            abort(404, 'Not Found!');
        }

        $item->setPresenter(new ContentPresenter());

        return $item->presenter();
    }

    /**
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function getPagesBySlugs($request)
    {
        $contentQuery = $this->getContentQuery();

        $slugs = explode(',',$request->get('slugs',[]));

        $contentQuery->where('type', 'page')->whereIn('slug',$slugs);

        $contentQuery = $this->applyFilters($request, $contentQuery);

        return $contentQuery;
    }
}
