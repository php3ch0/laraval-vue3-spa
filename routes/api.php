<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountriesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WidgetsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogImagesController;
use App\Http\Controllers\GalleriesController;
use App\Http\Controllers\GalleriesImagesController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServicesController;


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

    /* Admin Blog */
    Route::post('/blog',[BlogController::class,'add']);
    Route::post('/blog/{id}',[BlogController::class,'edit']);
    Route::delete('/blog/{id}',[BlogController::class,'delete']);

    Route::post('/blog/{bid}/images',[BlogImagesController::class,'add']);
    Route::delete('/blog/{bid}/images/{id}',[BlogImagesController::class,'delete']);


    /* Admin Widgets */
    Route::get('/widgets',[WidgetsController::class,'index']);
    Route::post('/widgets/{id}',[WidgetsController::class,'edit']);
    Route::delete('/widgets/{id}',[WidgetsController::class,'delete']);
    Route::post('/widgets',[WidgetsController::class,'add']);
    Route::post('/widgets/upload',[WidgetsController::class,'upload']);

    /* Admin Galleries */
    Route::post('/galleries',[GalleriesController::class,'add']);
    Route::patch('/galleries',[GalleriesController::class,'edit']);
    Route::delete('/galleries/{id}',[GalleriesController::class,'delete']);
    Route::post('/galleries/images',[GalleriesImagesController::class,'add']);
    Route::patch('/galleries/images',[GalleriesImagesController::class,'edit']);
    Route::delete('/galleries/images/{id}',[GalleriesImagesController::class,'delete']);
    Route::post('/galleries/images/order',[GalleriesImagesController::class,'order']);
    Route::patch('/galleries/images/{id}/rotate',[GalleriesImagesController::class,'rotate']);


    // Admin testimonials
    Route::post('/testimonials',[TestimonialsController::class,'add']);
    Route::delete('/testimonials/{id}',[TestimonialsController::class,'delete']);
    Route::post('/testimonials/order',[TestimonialsController::class,'order']);
    Route::post('/testimonials/{id}',[TestimonialsController::class,'edit']);

    /* Admin Services */
    Route::post('/services/add',[ServicesController::class,'add']);
    Route::post('/services/edit',[ServicesController::class,'edit']);
    Route::any('/services/order',[ServicesController::class,'order']);
    Route::get('/services/{id}/delete',[ServicesController::class,'delete']);
    Route::get('/services/{id}/rotate/{image}',[ServicesController::class,'rotate']);


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

/* Public Blog */
Route::get('/blog',[BlogController::class,'index']);
Route::get('/blog/{id}',[BlogController::class,'get']);

// Public Widgets
Route::get('/widget',[WidgetsController::class,'get']);

/* Public Galleries */
Route::get('/galleries',[GalleriesController::class,'index']);
Route::get('/galleries/{id}',[GalleriesController::class,'get']);
Route::get('/galleries/images/{id}',[GalleriesImagesController::class,'get']);

// Public Testimonials
Route::get('/testimonials',[TestimonialsController::class,'index']);
Route::get('/testimonials/{id}',[TestimonialsController::class,'get']);

// Public Contact Form
Route::post('contact',[ContactController::class,'contact']);

// Public Widgets
Route::get('/widgets/{id}',[WidgetsController::class,'get']);

/* Public Services */
Route::get('/services',[ServicesController::class,'index']);
Route::get('/services/{id}',[ServicesController::class,'get']);
