<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('payments/result/{PaymentID}', 'WalletController@result')->name('result');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['can:isManager']], function () {
        Route::prefix('dashboard')->group(function () {
            /* Payments Routing */
            Route::resource('payments', 'PaymentsController');
            Route::post('/payments/destroy', 'PaymentsController@destroy')->name('payments.destroy');

            /* Withdrawal Routing */
            Route::resource('withdrawal', 'WithdrawalController');
            Route::post('/withdrawal/destroy', 'WithdrawalController@destroy')->name('withdrawal.destroy');
        });
    });
});
