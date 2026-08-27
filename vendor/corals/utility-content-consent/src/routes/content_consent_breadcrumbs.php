<?php

Breadcrumbs::register('utilities_content_consent', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(view()->shared('title'));
});

