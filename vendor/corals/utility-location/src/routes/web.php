<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'address'], function () {
    Route::get('get-location-type-children', 'LocationsController@getLocationTypeChildren');
    Route::post('locations/bulk-action', 'LocationsController@bulkAction');
    Route::resource('locations', 'LocationsController');
});

Route::group(['prefix' => 'locations'], function () {
    Route::get('import/{target}/get-import-modal', 'ImportController@getImportModal');
    Route::get('import/{target}/download-import-sample', 'ImportController@downloadImportSample');
    Route::post('import/{target}/upload-import-file', 'ImportController@uploadImportFile');
});
