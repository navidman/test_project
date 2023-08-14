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

Route::get('get-last-resume/{count}', 'ResumeManagerController@getLastResume');
Route::get('resume/{id}', 'ResumeManagerController@show');

Route::get('resume', 'ResumeManagerController@ShowRecommendedResume')->middleware('auth:sanctum');
Route::get('owner-resume', 'ResumeManagerController@ShowOwnerResume')->middleware('auth:sanctum');
Route::post('resume', 'ResumeManagerController@store')->middleware('auth:sanctum');
Route::post('resume-confirm', 'ResumeManagerController@resume_confirm')->middleware('auth:sanctum');
Route::get('resume-edit/{id}', 'ResumeManagerController@resume_edit')->middleware('auth:sanctum');
Route::post('resume-update/{id}', 'ResumeManagerController@resume_update')->middleware('auth:sanctum');
Route::post('resumes', 'ResumeManagerController@getAllResumes');
Route::post('get-resume-by-id-cart', 'ResumeManagerController@getResumeByIDsCart');

/* Purchase Result */
Route::post('set-purchase-result', 'ResumeManagerController@PurchaseResult')->middleware('auth:sanctum');

/* Purchase Reasons */
Route::get('get-purchased-resume-data/{id}', 'ResumeManagerController@GetPurchasedResumeData')->middleware('auth:sanctum');
Route::post('reason-not-hiring', 'ResumeManagerController@ReasonNotHiring')->middleware('auth:sanctum');

/* WorkExperience */
Route::get('work-experience', 'WorkExperienceController@getOwnerWorkExperience')->middleware('auth:sanctum');
Route::post('work-experience', 'WorkExperienceController@store')->middleware('auth:sanctum');
Route::get('work-experience/{slug}', 'WorkExperienceController@GetWorkExperience');
Route::post('work-experience/{slug}', 'WorkExperienceController@SubmitWorkExperience');
Route::post('delete-work-experience', 'WorkExperienceController@delete')->middleware('auth:sanctum');

/* My Resume data */
Route::get('my-resume-data', 'ResumeManagerController@MyResumeData')->middleware('auth:sanctum');
Route::post('my-resume-data-store', 'ResumeManagerController@MyResumeDataStore')->middleware('auth:sanctum');

/* Resume Requirements */
Route::get('resume-requirements/{id}', 'ResumeManagerController@ResumeRequirements')->middleware('auth:sanctum');
