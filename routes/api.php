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
