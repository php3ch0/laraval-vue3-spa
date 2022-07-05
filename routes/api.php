<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\User\UsersController;

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

Route::namespace('\App\Http\Controllers\Api')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::get('/user', Auth\UserController::class);

        Route::get('/users',[UsersController::class,'index']);
        Route::post('/users',[UsersController::class,'add']);
        Route::get('/users/{id}',[UsersController::class,'get']);
        Route::patch('/users/{id}',[UsersController::class,'edit']);
        Route::delete('/users/{id}',[UsersController::class,'delete']);
    });
