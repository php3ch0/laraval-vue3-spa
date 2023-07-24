<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\User\UsersController;

use App\Http\Controllers\Api\Blog\BlogController;
use App\Http\Controllers\Api\Blog\BlogImagesController;
use App\Http\Controllers\Api\Widgets\WidgetsController;

use App\Http\Controllers\Api\Galleries\GalleriesController;
use App\Http\Controllers\Api\Galleries\GalleriesImagesController;

use App\Http\Controllers\Api\ContactController;

use App\Http\Controllers\Api\Testimonials\TestimonialsController;


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
        Route::post('/user',[UsersController::class,'update']);

        Route::get('/users',[UsersController::class,'index']);
        Route::post('/users',[UsersController::class,'add']);
        Route::get('/users/{id}',[UsersController::class,'get']);
        Route::get('/users/{id}/cv',[UsersController::class,'downloadCV']);
        Route::patch('/users/{id}',[UsersController::class,'edit']);
        Route::delete('/users/{id}',[UsersController::class,'delete']);

        /* Admin Blog */
        Route::post('/blog',[BlogController::class,'add']);
        Route::post('/blog/{id}',[BlogController::class,'edit']);
        Route::delete('/blog/{id}',[BlogController::class,'delete']);

        Route::post('/blogimages',[BlogImagesController::class,'add']);
        Route::post('/blogimages/order',[BlogImagesController::class,'order']);
        Route::delete('/blogimages/{id}',[BlogImagesController::class,'delete']);
        Route::post('/blogimages/{id}/rotate',[BlogImagesController::class,'rotate']);

        Route::get('/widgets', [WidgetsController::class,'index']);
        Route::post('/widgets', [WidgetsController::class,'add']);
        Route::post('/widgets/{id}', [WidgetsController::class,'edit']);
        Route::delete('/widgets/{id}', [WidgetsController::class,'delete']);

        /* Galleries */

        Route::post('/galleries',[GalleriesController::class,'add']);

        Route::post('/galleries/{id}',[GalleriesController::class,'edit']);
        Route::delete('/galleries/{id}',[GalleriesController::class,'delete']);

        Route::post('/galleriesimages',[GalleriesImagesController::class,'add']);
        Route::post('/galleriesimages/order',[GalleriesImagesController::class,'order']);
        Route::post('/galleriesimages/{id}',[GalleriesImagesController::class,'edit']);
        Route::post('/galleriesimages/{id}/rotate',[GalleriesImagesController::class,'rotate']);
        Route::delete('/galleriesimages/{id}',[GalleriesImagesController::class,'delete']);

        /* Testimonials */
        Route::post('/testimonials',[TestimonialsController::class,'add']);
        Route::get('/testimonials/{id}',[TestimonialsController::class,'get']);
        Route::post('/testimonials/{id}',[TestimonialsController::class,'edit']);
        Route::delete('/testimonials/{id}',[TestimonialsController::class,'delete']);


    });

Route::namespace('\App\Http\Controllers\Api')
    ->group(function() {

        /* Public Blog */
        Route::get('/blog',[BlogController::class,'index']);
        Route::get('/blog/{id}',[BlogController::class,'get']);

        /* public Widgets */
        Route::get('/widgets/{id}', [WidgetsController::class,'get']);

        /*Public Galleries */
        Route::get('/galleries',[GalleriesController::class,'index']);
        Route::get('/galleries/{id}',[GalleriesController::class,'get']);
        Route::get('/galleriesimages/{id}',[GalleriesImagesController::class,'get']);

        Route::post('/register',[UsersController::class,'register']);

        Route::post('/sendRoomEnquiry',[ContactController::class,'sendRoomEnquiry']);
        Route::post('/sendRestaurantEnquiry',[ContactController::class,'sendRestaurantEnquiry']);

        /* testimonials */
        Route::get('/testimonials',[TestimonialsController::class,'index']);

    });
