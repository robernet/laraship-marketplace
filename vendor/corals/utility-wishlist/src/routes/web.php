<?php

use Illuminate\Support\Facades\Route;

Route::delete('wishlist/{wishlist}', 'WishlistBaseController@destroy');
