<?php

namespace Corals\Utility\Tag\Classes;

use Corals\Utility\Tag\Models\Tag;

class TagManager
{
    /**
     * @param null $module
     * @param bool $objects
     * @param null $status
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getTagsList($module = null, $objects = false, $status = null)
    {
        $tags = Tag::query();

        if (! is_null($module)) {
            $tags = $tags->withModule($module);
        }

        if ($status) {
            $tags = $tags->where('status', $status);
        }


        if ($objects) {
            $tags = $tags->get();
        } else {
            $tags = $tags->pluck('name', 'id');
        }

        return $tags;
    }
}
