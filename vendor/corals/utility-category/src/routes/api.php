<?php

Route::group(['prefix' => 'utilities'], function () {
    Route::group(['prefix' => 'category'], function () {
        Route::apiResource('attributes', 'AttributesController', ['as' => 'api.utilities.category']);
        Route::apiResource('categories', 'CategoriesController', ['as' => 'api.utilities.category']);
    });
});
