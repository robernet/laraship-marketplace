<?php

//location
Breadcrumbs::register('address_locations', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('utility-location::module.location.title'), url(config('utility-location.models.location.resource_url')));
});

Breadcrumbs::register('address_location_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('address_locations');
    $breadcrumbs->push(view()->shared('title_singular'));
});
