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

    Route::group(['middleware' => 'authorization'], function(){
        Route::group(['prefix' => 'stores'], function () {
            Route::post('/', 'StoreController@store');
            Route::get('/', 'StoreController@index')->middleware('store');
        });

        //middleware store is to check if user already has store
        Route::group(['middleware' => 'store'], function(){
            Route::apiResource('categories', CategoryController::class);
            Route::apiResource('products', ProductController::class);

            Route::group(['prefix' => 'receipt-items'], function () {
                Route::get('/total/{date}', 'ReceiptItemController@dailySales');
                Route::get('/top/{date}', 'ReceiptItemController@topSales');
            });

            Route::post('/receipts/checkout', 'ReceiptController@checkout');
        });
    });
});
