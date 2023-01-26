<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\HomeApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\ProductApiController;

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
Route::get('/home', [ HomeApiController::class, 'home']);
Route::get('/product/{slug}',[ ProductApiController::class, 'detail']);
Route::post('/review/{slug}', [ ReviewApiController::class, 'makeReview']);
Route::post('/add-tocart/{slug}', [ CartApiController::class, 'addToCart']);
Route::get('/get-cart',[ CartApiController::class, 'getCart']);
Route::post('/update-cart-qty',[ CartApiController::class, 'getUpdateCartQty']);
Route::post('/delete-cart',[ CartApiController::class, 'removeCart']);
Route::post('/check-out',[ CartApiController::class, 'checkout']);
Route::get('/order-list',[ CartApiController::class, 'orderList']);
Route::post('/change-password',[ AuthApiController::class, 'changePassword']);
Route::get('/profile',[ AuthApiController::class, 'profile']);
Route::post('/profile',[ AuthApiController::class, 'saveProfile']);
