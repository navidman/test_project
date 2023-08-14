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

Route::post('consultation-request-site', 'ConsultationRequestController@store')->name('consultation-request.store-site');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['can:isManager']], function () {
        Route::prefix('dashboard')->group(function () {
            Route::resource('consultation-request', 'ConsultationRequestController');
        });
    });
});
