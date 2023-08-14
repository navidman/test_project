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

Route::post('payments/charging-wallet', 'WalletController@ChargingWallet')->middleware('auth:sanctum');

Route::post('payments/purchase', 'PaymentsController@purchase')->middleware('auth:sanctum');

/* Withdrawal */
Route::get('withdrawal', 'WithdrawalController@get')->middleware('auth:sanctum');
Route::post('withdrawal', 'WithdrawalController@store')->middleware('auth:sanctum');
Route::get('withdrawal/history', 'WithdrawalController@history')->middleware('auth:sanctum');
