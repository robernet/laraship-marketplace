<?php

use Illuminate\Support\Facades\Route;

Route::post('comments/bulk-action', 'CommentBaseController@bulkAction');
Route::resource('comments', 'CommentBaseController', ['only' => ['index', 'destroy']]);
Route::post('comments/{comment}/{status}', 'CommentBaseController@toggleStatus');
