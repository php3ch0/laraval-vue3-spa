<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountriesController;
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

Route::group(['middleware' => 'auth:api'], function () {

    Route::post('logout', [LoginController::class, 'logout']);

    Route::get('user', [UserController::class, 'current']);
    Route::post('user',[UserController::class, 'currentUpdate']);
    Route::post('password',[UserController::class, 'currentPassword']);

    Route::get('/users',[UserController::class, 'index']);
    Route::post('/users',[UserController::class, 'add']);
    Route::get('/users/{id}',[UserController::class, 'get']);
    Route::post('/users/{id}',[UserController::class, 'update']);
    Route::delete('/users/{id}',[UserController::class, 'delete']);


    /* Admin Countries */
    Route::post('/countries',[CountriesController::class, 'add']);
    Route::post('/countries/{id}',[CountriesController::class, 'edit']);
    Route::delete('/countries/{id}',[CountriesController::class, 'delete']);




});

//Public Access

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [ResetPasswordController::class, 'reset']);


Route::post('oauth/{driver}', [OAuthController::class, 'redirect']);
Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');


Route::get('/countries',[CountriesController::class,'index']);
Route::get('/countries/{id}',[CountriesController::class, 'get']);
