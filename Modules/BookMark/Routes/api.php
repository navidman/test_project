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

Route::get('bookmark', 'BookMarkController@show')->middleware('auth:sanctum');
Route::post('bookmark', 'BookMarkController@check')->middleware('auth:sanctum');
Route::post('bookmark/store', 'BookMarkController@store')->middleware('auth:sanctum');
