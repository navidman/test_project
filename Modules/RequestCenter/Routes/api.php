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

/* Request Center */
Route::get('request-center', 'RequestCenterController@request_list')->middleware('auth:sanctum');

/* Request Received */
Route::get('request-received', 'RequestReceivedController@RequestReceived')->middleware('auth:sanctum');
Route::post('request-received-store', 'RequestReceivedController@RequestReceivedStore')->middleware('auth:sanctum');
Route::get('request-received/{id}', 'RequestRepliesController@ShowRequestReceived')->middleware('auth:sanctum');

/* Request Replies */
Route::post('request-replies', 'RequestRepliesController@SubmitReplies')->middleware('auth:sanctum');
