<?php

use Illuminate\Support\Facades\Route;

Route::post('tags/bulk-action', 'TagsController@bulkAction');
Route::resource('tags', 'TagsController', ['except' => ['show']]);
