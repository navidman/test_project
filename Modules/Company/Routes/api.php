<?php

use Illuminate\Http\Request;

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

Route::get('companies', 'CompanyAPIController@GetCompanies');
Route::get('companies/{id}', 'CompanyAPIController@CompanyPage');

//Route::middleware('auth:api')->get('/company', function (Request $request) {
//    return $request->user();
//});
