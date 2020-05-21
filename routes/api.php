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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('akun/{id?}', 'AkunController@get');

Route::post('akun/check', 'AkunController@login');

Route::post('akun', 'AkunController@create');

Route::put('akun', 'AkunController@update');

Route::delete('akun', 'AkunController@delete');

Route::get('level/{id?}', 'LevelController@get');

Route::post('level', 'LevelController@create');

Route::put('level', 'LevelController@update');

Route::delete('level', 'LevelController@delete');

Route::get('method/{id?}', 'MethodController@get');

Route::post('method', 'MethodController@create');

Route::put('method', 'MethodController@update');

Route::delete('method', 'MethodController@delete');

Route::get('payment/{id?}', 'PaymentController@get');

Route::post('payment', 'PaymentController@create');

Route::put('payment', 'PaymentController@update');

Route::delete('payment', 'PaymentController@delete');

Route::get('po/{id?}', 'PoController@get');

Route::post('po', 'PoController@create');

Route::put('po', 'PoController@update');

Route::delete('po', 'PoController@delete');

Route::get('status/{id?}', 'StatusController@get');

Route::post('status', 'StatusController@create');

Route::put('status', 'StatusController@update');

Route::delete('status', 'StatusController@delete');

Route::get('terminal/{id?}', 'TerminalController@get');

Route::post('terminal', 'TerminalController@create');

Route::put('terminal', 'TerminalController@update');

Route::delete('terminal', 'TerminalController@delete');

Route::get('trayek/{id?}', 'TrayekController@get');

Route::get('trayek/search/{asal}/{tujuan}/{tanggal}', 'TrayekController@get');

Route::post('trayek', 'TrayekController@create');

Route::put('trayek', 'TrayekController@update');

Route::delete('trayek', 'TrayekController@delete');
