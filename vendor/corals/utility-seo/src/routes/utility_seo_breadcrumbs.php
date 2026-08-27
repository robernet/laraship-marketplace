<?php

Breadcrumbs::register('utility_seo_item', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(view()->shared('title'));
});
