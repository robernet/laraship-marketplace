<?php

//Tag
Breadcrumbs::register('tags', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('utility-tag::module.tag.title'), url(config('utility-tag.models.tag.resource_url')));
});

Breadcrumbs::register('tag_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('tags');
    $breadcrumbs->push(view()->shared('title_singular'));
});
