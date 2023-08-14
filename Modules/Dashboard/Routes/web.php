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

/* Dashboard Route */
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['can:isManager']], function () {
        Route::group(['prefix' => 'dashboard'], function () {
            /* Dashboard */
            Route::get('/', 'DashboardController@index');
        });
    });
});
