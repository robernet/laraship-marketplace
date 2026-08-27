<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'utilities'], function () {
    Route::get('content-consent-settings/modal', 'ContentConsentController@modal');
    Route::get('content-consent-settings', 'ContentConsentController@index');
    Route::post('content-consent-settings', 'ContentConsentController@setSettings');
    Route::get('content-consent-answer/{state}', 'ContentConsentController@setContentConsentAnswer');
});
