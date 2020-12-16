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
    Route::get('{search}', ['uses' => 'User\UserController@search']);
});

Route::group(['prefix' => 'account-bank'], function () {
    Route::post('', ['uses' => 'AccountBank\AccountBankController@create']);
    Route::delete('', ['uses' => 'AccountBank\AccountBankController@delete']);
});

Route::group(['prefix' => 'atm-simulator'], function () {
    Route::post('withdraw', ['uses' => 'AtmSimulator\AtmSimulatorController@withdraw']);
    Route::post('deposit', ['uses' => 'AtmSimulator\AtmSimulatorController@deposit']);
});
