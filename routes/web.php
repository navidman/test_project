<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\SmsHandler\Http\Controllers\SmsHandlerController;

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


/* Index */
//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
//    return redirect('https://' . env('APP_URL'));
    Auth::loginUsingId(1);
})->name('home');


Route::get('/email/verify', 'App\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify')->middleware(['signed']);
Route::post('/email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');

/* CKEditor Image Upload */
Route::group(['middleware' => ['auth']], function () {
    Route::post('dashboard/ckeditor/upload/{path}', [App\Http\Controllers\CKEditorController::class, 'upload'])->name('ckeditor.image-upload');
});

/* Clear Cache */
Route::get('clear-cache', function () {
//    Artisan::call('migrate');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    \Cookie::queue(\Cookie::forget('userData'));
    \Cookie::queue(\Cookie::forget('toplicant_session'));
    \Cookie::queue(\Cookie::forget('XSRF-TOKEN'));
    \Cookie::queue(\Cookie::forget('auth_token'));

//    Artisan::call('schedule:run');
//    Artisan::call('config:cache');
    return 'DONE';
});

Auth::routes();
