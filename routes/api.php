<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/invite-user', '\App\Http\Controllers\AdminController@inviteUser');
Route::post('/signup', '\App\Http\Controllers\UserController@signup');
Route::post('/verify-code', '\App\Http\Controllers\UserController@verifyCode');
Route::post('/login', '\App\Http\Controllers\UserController@login');
Route::post('/update-profile', '\App\Http\Controllers\UserController@updateProfile');
