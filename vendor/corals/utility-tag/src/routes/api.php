<?php

Route::group(['prefix' => 'utilities'], function () {
    Route::group(['prefix' => 'tag'], function () {
        Route::apiResource('tags', 'TagsController', ['as' => 'api.utilities.tag']);
    });
});
