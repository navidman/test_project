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

Route::get('partner-companies', 'PartnerCompaniesController@PartnerCompanies')->middleware('auth:sanctum');;
Route::get('partner/get-company-list', 'PartnerCompaniesController@GetCompanyList')->middleware('auth:sanctum');;
Route::post('add-partner-company', 'PartnerCompaniesController@AddPartnerCompany')->middleware('auth:sanctum');;
Route::post('change-partner-active', 'PartnerCompaniesController@ChangePartnerActiveToggle')->middleware('auth:sanctum');;
Route::post('delete-partner', 'PartnerCompaniesController@DeletePartnerRequest')->middleware('auth:sanctum');;
Route::post('change-status-partner', 'PartnerCompaniesController@ChangeStatusPartner')->middleware('auth:sanctum');;

//
//Route::middleware('auth:api')->get('/partnercompanies', function (Request $request) {
//    return $request->user();
//});
