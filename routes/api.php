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

//Route::prefix('v1')->namespace('App\Http\Controllers\Api\v1')->group(function () {
//
//});

//Route::post('login', 'App\Http\Controllers\UserController@login');
//Route::post('register', 'App\Http\Controllers\UserController@register');
//
//Route::post('logout', 'App\Http\Controllers\UserController@logout')->middleware('auth:sanctum');

Route::post('login', 'App\Http\Controllers\UserController@login');
Route::post('logout', 'App\Http\Controllers\UserController@logout')->middleware('auth:sanctum');
Route::get('user-data', 'App\Http\Controllers\UserController@UserData')->middleware('auth:sanctum');
Route::post('add-member', 'App\Http\Controllers\UserController@addMember')->middleware('auth:sanctum');
Route::post('member-toggle-active', 'App\Http\Controllers\UserController@ChangeMemberActiveToggle')->middleware('auth:sanctum');
Route::post('delete-member', 'App\Http\Controllers\UserController@DeleteMember')->middleware('auth:sanctum');

//Route::post('logout', 'App\Http\Controllers\UserController@logout');

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
