<?php

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

Route::get('blog', 'BlogController@blog');
Route::get('blog/editor-choice/{count}', 'BlogController@EditorChoice');
Route::get('blog/get-last-articles/{count}', 'BlogController@getLastArticles');
Route::get('blog/{slug}', 'BlogController@show');

Route::post('blog-category/{slug}', 'BlogController@BlogCategory');
Route::get('get-blog-category', 'BlogController@GetCategory');

//Route::prefix('v1')->namespace('Api\v1')->group(function () {
//    Route::get('/blog', 'BlogController@showOnHome');
//});
