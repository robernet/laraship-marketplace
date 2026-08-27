<?php

//Webhook
Breadcrumbs::register('utility_webhook', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('utility-webhook::module.webhook.title'), url(config('utility-webhook.models.webhook.resource_url')));
});
