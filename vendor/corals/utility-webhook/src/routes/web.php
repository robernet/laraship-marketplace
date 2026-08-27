<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'webhooks'], function () {
    Route::post('bulk-action', 'WebhooksController@bulkAction');
    Route::delete('{webhook}', 'WebhooksController@destroy');
    Route::post('{event_name}', 'WebhooksController@submitEvent');
    Route::post('{webhook}/process', 'WebhooksController@process');
    Route::get('/', 'WebhooksController@index');
});
