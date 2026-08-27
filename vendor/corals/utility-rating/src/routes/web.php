<?php

use Illuminate\Support\Facades\Route;

Route::post('ratings/bulk-action', 'RatingBaseController@bulkAction');
Route::resource('ratings', 'RatingBaseController', ['except' => ['store', 'show', 'create']]);
Route::post('ratings/{rating}/{status}', 'RatingBaseController@toggleStatus');
