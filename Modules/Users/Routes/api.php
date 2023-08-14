<?php

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

Route::get('my-account', 'UsersController@MyAccount')->middleware('auth:sanctum');
Route::post('my-account', 'UsersController@UpdateMyAccount')->middleware('auth:sanctum');
Route::post('my-account-security', 'UsersController@UpdateMySecurityAccount')->middleware('auth:sanctum');
Route::get('members', 'UsersController@GetMembers')->middleware('auth:sanctum');
Route::post('verify-email', 'UsersController@resendVerifyEmail')->middleware('auth:sanctum');

//Route::prefix('v1')->namespace('Api\v1')->group(function () {
//    Route::get('/my-account', 'MyAccountController@index');
//});
