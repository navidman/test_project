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

Route::get('tickets', 'SupportSystemController@ShowOwnerTickets')->middleware('auth:sanctum');
Route::get('get-support-taxonomy', 'SupportSystemController@getTaxonomy')->middleware('auth:sanctum');

Route::post('support', 'SupportSystemController@store_support')->middleware('auth:sanctum');
Route::get('support/{id}', 'SupportSystemController@show')->middleware('auth:sanctum');

Route::post('ticket-store/{id}', 'SupportSystemController@TicketReply')->middleware('auth:sanctum');


//Route::middleware('auth:api')->get('/supportsystem', function (Request $request) {
//    return $request->user();
//});
