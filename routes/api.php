<?php

use Illuminate\Http\Request;
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

Route::group(['namespace' => 'Api'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::post('/create', 'ApiAuthController@create'); //Swagger
        Route::post('/login', 'ApiAuthController@login'); //Swagger
        Route::post('/reset', 'ForgotPasswordController@reset'); //Swagger
    });
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['namespace' => 'Api'], function () {
        Route::post('/user/token', 'ApiAuthController@token'); //Swagger
    });
});
