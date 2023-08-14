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

/* Work Experience History */
Route::get('work-experience-history', 'ResumeWorkExperienceHistoryController@getOwnerWorkExperienceHistory')->middleware('auth:sanctum');
Route::post('work-experience-history', 'ResumeWorkExperienceHistoryController@store')->middleware('auth:sanctum');
Route::put('work-experience-history', 'ResumeWorkExperienceHistoryController@update')->middleware('auth:sanctum');
Route::delete('work-experience-history', 'ResumeWorkExperienceHistoryController@delete')->middleware('auth:sanctum');

/* Education History */
Route::get('education-history', 'ResumeEducationHistoryController@getOwnerEducationHistory')->middleware('auth:sanctum');
Route::post('education-history', 'ResumeEducationHistoryController@store')->middleware('auth:sanctum');
Route::put('education-history', 'ResumeEducationHistoryController@update')->middleware('auth:sanctum');
Route::delete('education-history', 'ResumeEducationHistoryController@delete')->middleware('auth:sanctum');

/* Course History */
Route::get('course-history', 'ResumeCourseHistoryController@getOwnerCourseHistory')->middleware('auth:sanctum');
Route::post('course-history', 'ResumeCourseHistoryController@store')->middleware('auth:sanctum');
Route::put('course-history', 'ResumeCourseHistoryController@update')->middleware('auth:sanctum');
Route::delete('course-history', 'ResumeCourseHistoryController@delete')->middleware('auth:sanctum');

/* Works Sample history */
Route::get('works-sample-history', 'ResumeWorksSampleHistoryController@getOwnerWorksSampleHistory')->middleware('auth:sanctum');
Route::post('works-sample-history', 'ResumeWorksSampleHistoryController@store')->middleware('auth:sanctum');
Route::post('works-sample-history-update', 'ResumeWorksSampleHistoryController@update')->middleware('auth:sanctum');
Route::delete('works-sample-history', 'ResumeWorksSampleHistoryController@delete')->middleware('auth:sanctum');
