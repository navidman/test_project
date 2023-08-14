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

Route::post('comment/store', 'CommentSystemController@store')->name('user-comment.store');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['can:isManager']], function () {
        Route::prefix('dashboard')->group(function () {
            Route::resource('comment', 'CommentSystemController');
            Route::post('comment/destroy', 'CommentSystemController@destroy')->name('comment.destroy');
        });
    });
});
