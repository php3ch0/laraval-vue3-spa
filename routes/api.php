<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\User\UsersController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\Blog\BlogController;
use App\Http\Controllers\Api\Blog\BlogImagesController;

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

        /* Admin Blog */
        Route::post('/blog',[BlogController::class,'add']);
        Route::post('/blog/{id}',[BlogController::class,'edit']);
        Route::delete('/blog/{id}',[BlogController::class,'delete']);

        Route::post('/blog/{bid}/images',[BlogImagesController::class,'add']);
        Route::delete('/blog/{bid}/images/{id}',[BlogImagesController::class,'delete']);

    });

Route::namespace('\App\Http\Controllers\Api')
    ->group(function() {
        Route::post('/contact',[ContactController::class,'sendEnquiry']);

        /* Public Blog */
        Route::get('/blog',[BlogController::class,'index']);
        Route::get('/blog/{id}',[BlogController::class,'get']);

    });
