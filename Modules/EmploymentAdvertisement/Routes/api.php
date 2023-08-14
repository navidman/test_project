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

Route::get('get-ads-taxonomy', 'EmploymentAdvertisementController@getTaxonomy');
Route::post('employment-advertisement', 'EmploymentAdvertisementController@store_api')->middleware('auth:sanctum');
Route::get('employment-advertisement', 'EmploymentAdvertisementController@ShowOwnerAdvertisement')->middleware('auth:sanctum');
Route::get('advertisement-edit/{id}', 'EmploymentAdvertisementController@EditAdvertisement')->middleware('auth:sanctum');
Route::post('advertisement-update/{id}', 'EmploymentAdvertisementController@UpdateAdvertisement')->middleware('auth:sanctum');

/* Get Last Employer Image */
Route::get('get-employer-image/{count}', 'EmploymentAdvertisementController@getEmplouerImage');


//Route::middleware('auth:api')->get('/employment-advertisement', function (Request $request) {
//});
