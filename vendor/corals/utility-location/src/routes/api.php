<?php

Route::group(['prefix' => 'utilities'], function () {
    Route::group(['prefix' => 'address'], function () {
        Route::apiResource('locations', 'LocationsController', ['as' => 'api.utilities.address']);
    });
});
