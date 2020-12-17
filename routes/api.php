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

Route::group(['prefix' => 'docs'], function () {
    Route::get('documentation.yml', function () {
        return response()->view(
            'documentation',
            [],
            200,
            ['Content-Type' => 'text/yaml; charset=UTF-8']
        );
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::post('', ['uses' => 'User\UserController@create']);
    Route::put('', ['uses' => 'User\UserController@update']);
    Route::delete('', ['uses' => 'User\UserController@delete']);
    Route::get('{cpf}', ['uses' => 'User\UserController@searchUser']);
});

Route::group(['prefix' => 'account-bank'], function () {
    Route::post('', ['uses' => 'AccountBank\AccountBankController@create']);
});

Route::group(['prefix' => 'atm-simulator'], function () {
    Route::post('withdraw', ['uses' => 'AtmSimulator\AtmSimulatorController@withdraw']);
    Route::post('deposit', ['uses' => 'AtmSimulator\AtmSimulatorController@deposit']);
});
