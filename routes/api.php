<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountriesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StockMarginsController;
use App\Http\Controllers\UserPricesController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\DeliveryTypesController;
use App\Http\Controllers\OrdersItemsController;
use App\Http\Controllers\BatchesController;
use App\Http\Controllers\DeliveryTypesCountriesController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\TicketsRepliesController;

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
    Route::get('user/invoices', [UserController::class, 'currentInvoices']);
    Route::post('user',[UserController::class, 'currentUpdate']);
    Route::post('password',[UserController::class, 'currentPassword']);
    Route::get('user/prices', [UserController::class, 'getPrices']);
    Route::get('user/countorders', [UserController::class, 'countOrders']);

    Route::get('/users',[UserController::class, 'index']);
    Route::post('/users',[UserController::class, 'add']);
    Route::get('/users/{id}',[UserController::class, 'get']);
    Route::post('/users/{id}',[UserController::class, 'update']);
    Route::delete('/users/{id}',[UserController::class, 'delete']);
    Route::get('/users/{id}/downloadOrders',[UserController::class, 'downloadOrders']);
    Route::get('/users/{id}/downloadOrdersDispatched',[UserController::class, 'downloadOrdersDispatched']);

    Route::get('/users/{id}/invoices',[InvoicesController::class, 'index']);
    Route::post('/invoices',[InvoicesController::class,'add']);
    Route::delete('/invoices/{id}',[InvoicesController::class,'delete']);
    Route::get('/invoices/{id}/download',[InvoicesController::class, 'download']);

    Route::post('/users/{uid}/prices',[UserPricesController::class,'add']);
    Route::get('/users/{uid}/prices/{id}',[UserPricesController::class,'get']);
    Route::post('/users/{uid}/prices/{id}',[UserPricesController::class,'edit']);
    Route::delete('/users/{uid}/prices/{id}',[UserPricesController::class,'delete']);

    Route::get('/margins',[StockMarginsController::class,'index']);
    Route::post('/margins',[StockMarginsController::class,'add']);
    Route::get('/margins/{id}',[StockMarginsController::class,'get']);
    Route::post('/margins/{id}',[StockMarginsController::class,'edit']);
    Route::delete('/margins/{id}',[StockMarginsController::class,'delete']);

    Route::get('/stock',[StockController::class, 'index']);
    Route::post('/stock',[StockController::class, 'add']);
    Route::post('/stock/order',[StockController::class, 'order']);
    Route::get('/stock/{id}',[StockController::class, 'get']);
    Route::post('/stock/{id}',[StockController::class, 'edit']);
    Route::delete('/stock/{id}',[StockController::class, 'delete']);

    /* Admin Countries */
    Route::post('/countries',[CountriesController::class, 'add']);
    Route::post('/countries/{id}',[CountriesController::class, 'edit']);
    Route::delete('/countries/{id}',[CountriesController::class, 'delete']);

    Route::get('/products',[ProductsController::class, 'index']);
    Route::post('/products',[ProductsController::class, 'add']);
    Route::post('/products/order',[ProductsController::class, 'order']);
    Route::get('/products/{id}',[ProductsController::class, 'get']);
    Route::post('/products/{id}',[ProductsController::class, 'edit']);
    Route::delete('/products/{id}',[ProductsController::class, 'delete']);

    Route::post('/products/{pid}/stock',[ProductsController::class, 'addStock']);
    Route::delete('/products/{pid}/stock/{id}',[ProductsController::class, 'removeStock']);

    Route::get('/orders',[OrdersController::class, 'index']);
    Route::post('/orders',[OrdersController::class, 'add']);
    Route::get('/orders/{id}',[OrdersController::class, 'get']);
    Route::post('/orders/{id}',[OrdersController::class, 'edit']);
    Route::delete('/orders/{id}',[OrdersController::class, 'delete']);
    Route::get('/orders/{id}/confirm',[OrdersController::class, 'confirm']);
    Route::get('/orders/{id}/cancel',[OrdersController::class, 'cancel']);
    Route::post('/orders/{id}/status',[OrdersController::class, 'editStatus']);
    Route::post('/orders/{id}/savenotes',[OrdersController::class, 'saveNotes']);
    Route::post('/orders/{id}/savetracking',[OrdersController::class, 'saveTracking']);
    Route::get('/orders/{id}/setDelivery/{did}',[OrdersController::class, 'setDelivery']);

    Route::get('/items',[OrdersItemsController::class, 'index']);
    Route::post('/items',[OrdersItemsController::class, 'add']);
    Route::get('/items/{id}',[OrdersItemsController::class, 'get']);
    Route::get('/items/{id}/image',[OrdersItemsController::class, 'getImage']);
    Route::get('/items/{id}/pdf',[OrdersItemsController::class, 'getPDF']);
    Route::post('/items/{id}',[OrdersItemsController::class, 'edit']);
    Route::delete('/items/{id}',[OrdersItemsController::class, 'delete']);


    Route::get('/settings',[SettingsController::class, 'index']);
    Route::post('/settings/{id}',[SettingsController::class, 'edit']);


    /*Delivery Types */
    Route::get('/delivery',[DeliveryTypesController::class, 'index']);
    Route::post('/delivery',[DeliveryTypesController::class, 'add']);
    Route::get('/delivery/types',[DeliveryTypesController::class, 'getTypes']);
    Route::get('/delivery/{id}',[DeliveryTypesController::class, 'get']);
    Route::post('/delivery/{id}',[DeliveryTypesController::class, 'edit']);
    Route::delete('/delivery/{id}',[DeliveryTypesController::class, 'delete']);

    Route::post('/delivery/{id}/prices',[DeliveryTypesController::class, 'addPrice']);
    Route::get('/delivery/{id}/prices/{pid}',[DeliveryTypesController::class, 'getPrice']);
    Route::post('/delivery/{id}/prices/{pid}',[DeliveryTypesController::class, 'editPrice']);
    Route::delete('/delivery/{id}/prices/{pid}',[DeliveryTypesController::class, 'deletePrice']);
    Route::get('/calcdelivery',[DeliveryTypesController::class,'calcPrice']);


    // Delivery Types Country
    Route::post('/dtc',[DeliveryTypesCountriesController::class,'add']);
    Route::delete('/dtc/{id}',[DeliveryTypesCountriesController::class,'delete']);

    Route::get('/batches',[BatchesController::class, 'index']);
    Route::get('/batches/run',[BatchesController::class, 'run']);
    Route::get('/batches/{id}',[BatchesController::class, 'download']);

    Route::post('price',[OrdersItemsController::class,'getPrice']);

    Route::get('/tickets',[TicketsController::class, 'index']);
    Route::post('/tickets',[TicketsController::class, 'add']);
    Route::get('/tickets/{id}',[TicketsController::class, 'get']);
    Route::post('/tickets/{id}',[TicketsController::class, 'edit']);
    Route::delete('/tickets/{id}',[TicketsController::class, 'delete']);

    Route::post('/tickets/{tid}/replies',[TicketsRepliesController::class, 'add']);
    Route::delete('/tickets/{tid}/replies/{id}',[TicketsRepliesController::class, 'delete']);

    Route::post('/tickets/{tid}/images',[TicketsController::class, 'addImage']);
    Route::get('/tickets/{tid}/images/{id}',[TicketsController::class, 'getImage']);
    Route::get('/tickets/{tid}/close',[TicketsController::class, 'closeTicket']);




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

Route::get('/settings/{id}',[SettingsController::class, 'get']);
