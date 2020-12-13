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

Route::group(['prefix' => 'user'], function () {
    Route::post('', ['uses' => 'User\UserController@create']);
    Route::put('', ['uses' => 'User\UserController@update']);
    Route::delete('', ['uses' => 'User\UserController@delete']);
    Route::get('', ['uses' => 'User\UserController@search']);
});
