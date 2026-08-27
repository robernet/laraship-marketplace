<?php

//Rating
Breadcrumbs::register('utility_ratings', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('utility-rating::module.rating.title'), url(config('utility-rating.models.rating.resource_url')));
});

Breadcrumbs::register('utility_ratings_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('utility_ratings');
    $breadcrumbs->push(trans('utility-rating::module.rating.title'), url(config('utility-rating.models.rating.resource_url')));
});
