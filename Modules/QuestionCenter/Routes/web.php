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
    Route::group(['middleware' => ['can:isOperator']], function () {
        Route::prefix('dashboard')->group(function () {
            /* Question Center Routing */
            Route::resource('question-center', 'QuestionCenterController');
            Route::post('/question-center/destroy', 'QuestionCenterController@destroy')->name('question-center.destroy');

            /* Question Category Routing */
            Route::resource('question-center-category', 'QuestionCenterCategoryController');
            Route::post('question-center-category/destroy', 'QuestionCenterCategoryController@destroy')->name('question-center-category.destroy');
        });
    });
});
