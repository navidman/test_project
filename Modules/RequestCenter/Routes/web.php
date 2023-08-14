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
            /* Request Center Routing */
            Route::resource('request-center', 'RequestCenterController');
            Route::post('/request-center/destroy', 'RequestCenterController@destroy')->name('request-center.destroy');

            /* Request Received Routing */
            Route::get('/request-center/received/{id}', 'RequestReceivedController@GetRequestReceived')->name('request-center.received');

            /* Request Replies Routing */
            Route::get('/request-replies/show/{id}', 'RequestRepliesController@ShowRequestReceivedAdmin')->name('request-replies.show');
            Route::post('/request-replies/store/{id}', 'RequestRepliesController@SubmitRepliesAdmin')->name('request-replies.store');
            Route::post('/request-replies/destroy/{id}', 'RequestRepliesController@destroy')->name('request-replies.destroy');
        });
    });
});
