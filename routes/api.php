<?php

use App\OtpCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::namespace('Auth')->group(function () {
    Route::post('register', 'RegisterController');
    Route::post('login', 'LoginController');
    Route::post('logout', 'LogoutController');
    Route::post('verification', 'VerificationController');
    Route::post('regenerate-otp', 'RegenerateOtpCodeController');
    Route::post('update-password', 'UpdatePasswordController');
});

Route::get('get-profile', 'ProfileController@index');
Route::post('update-profile', 'ProfileController@update');

Route::namespace('Role')->middleware('auth:api')->group(function () {
    Route::post('create-new-role', 'RoleController@store');
});
