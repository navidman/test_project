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

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['can:isManager']], function () {
        Route::prefix('dashboard')->group(function () {
            /* Support System Routing */
            Route::resource('support', 'SupportSystemController');
            Route::post('support/destroy', 'SupportSystemController@destroy')->name('support.destroy');

            /* Departments Routing */
            Route::resource('support-departments', 'SupportDepartmentsController');
            Route::post('support-departments/destroy', 'SupportDepartmentsController@destroy')->name('support.departments.destroy');

            /* Ticket Routing */
            Route::get('support-ticket/{id}', 'SupportSystemController@tickets');
            Route::post('support-ticket/{id}', 'SupportSystemController@tickets_store')->name('support.ticket.store');
            Route::post('support-ticket/destroy/{id}', 'SupportSystemController@destroy_ticket')->name('support.ticket.destroy');
        });
    });
});
