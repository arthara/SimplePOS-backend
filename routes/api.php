<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function(){
    Route::group(['prefix' => 'auth'], function(){
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
    });

    Route::group(['prefix' => 'stores', 'middleware' => 'authorization'], function () {
        Route::post('/', 'StoreController@store');
    });

    //Category
    Route::group(['prefix' => 'categories', 'middleware' => 'authorization'], function () {
        Route::get('/{store}', 'CategoryController@getCategoriesOfCurrentStore')
            ->name('get-category-on-store');
        Route::get('/all', 'CategoryController@getAllCategory')
            ->name('get-all-categories');
    });
    Route::resource('category', 'CategoryController');

    //Product
    Route::group(['prefix' => 'products', 'middleware' => 'authorization'], function () {
        Route::get('/{store}/{category}', 'ProductController@getAllProductOfCategory')
            ->name('get-all-product-of-category');
        Route::get('/all', 'ProductController@getAllProduct')
            ->name('get-all-products');
    });
    Route::resource('Product', 'ProductController');

    //
});
