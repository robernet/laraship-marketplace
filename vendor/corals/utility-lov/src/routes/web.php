<?php

use Illuminate\Support\Facades\Route;

Route::post('list-of-values/bulk-action', 'ListOfValuesController@bulkAction');
Route::get('list-of-values/get-parent-children', 'ListOfValuesController@getParentChildren');
Route::resource('list-of-values', 'ListOfValuesController');
