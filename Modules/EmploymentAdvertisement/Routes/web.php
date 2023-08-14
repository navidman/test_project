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
            /* Employment Advertisement Routing */
            Route::resource('advertisement', 'EmploymentAdvertisementController');
            Route::post('advertisement/destroy', 'EmploymentAdvertisementController@destroy')->name('advertisement.destroy');

            /* Management Head Hunt Resumes */
            Route::get('advertisement/head-hunt/{id}', 'EmploymentAdvertisementController@head_hunt');
            Route::put('advertisement/head-hunt/{id}', 'EmploymentAdvertisementController@head_hunt_store')->name('headhunt.store');

            /* Management Expert Resumes */
            Route::get('advertisement/expert-ads/{id}', 'EmploymentAdvertisementController@expert_ads');
            Route::put('advertisement/expert-ads/{id}', 'EmploymentAdvertisementController@expert_ads_store')->name('expert_ads.store');

            /* Employment Advertisement Category Routing */
            Route::resource('advertisement-category', 'EmploymentAdvertisementCategoryController');
            Route::post('advertisement-category/destroy', 'EmploymentAdvertisementCategoryController@destroy')->name('advertisement-category.destroy');

            /* Employment Advertisement Proficiency Routing */
            Route::resource('advertisement-proficiency', 'EmploymentAdvertisementProficiencyController');
            Route::post('advertisement-proficiency/destroy', 'EmploymentAdvertisementProficiencyController@destroy')->name('advertisement-proficiency.destroy');

            /* Employment Advertisement Personal Proficiency Routing */
            Route::resource('ads-personal-proficiency', 'EmploymentAdvertisementPersonalProficiencyController');
            Route::post('ads-personal-proficiency/destroy', 'EmploymentAdvertisementPersonalProficiencyController@destroy')->name('ads-personal-proficiency.destroy');
        });
    });
});
