<?php

use Illuminate\Http\Request;

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
Route::group(['middleware' => ['apiJsonResponse']], function () {
    
    Route::post('/register', 'Api\UserController@register')->name('api.register');
    Route::post('/login', 'Api\AuthController@login')->name('api.login');

    //Function that require authentication
    Route::middleware('auth:api')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        })->name('api.currentUser');

        Route::get('/allUsers', 'Api\UserController@getAllUsers')->name('api.allUsers');
        Route::get('/user/{id}', 'Api\UserController@getUserById')->name('api.oneSpecificUser');

        Route::get('/logout', 'Api\AuthController@logout')->name('api.logout');
    });
});