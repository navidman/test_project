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

Route::post('comment', 'CommentSystemController@store');
Route::post('comment-with-auth', 'CommentSystemController@store')->middleware('auth:sanctum');
Route::get('comment/{type}/{id}', 'CommentSystemController@show');
Route::post('comment-like/{id}', 'CommentSystemController@like');

//Route::middleware('auth:api')->get('/commentsystem', function (Request $request) {
//    return $request->user();
//});
