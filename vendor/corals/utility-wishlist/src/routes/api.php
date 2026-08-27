<?php

Route::group(['prefix' => 'utilities'], function () {
    Route::delete('wishlist/{wishlist}', 'WishlistAPIBaseController@destroy')->name('api.utilities.wishlist.destroy');
});
