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
            /* Blog Routing */
            Route::resource('blog', 'BlogController');
            Route::post('/blog/destroy', 'BlogController@destroy')->name('blog.destroy');

            /* Blog Category Routing */
            Route::resource('blog-category', 'BlogCategoryController');
            Route::post('blog-category/destroy', 'BlogCategoryController@destroy')->name('blog-category.destroy');
        });
    });
});
