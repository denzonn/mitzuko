<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('register/check', [App\Http\Controllers\Auth\RegisterController::class, 'check'])->name('api-register-check');

Route::POST('cart/increment', [App\Http\Controllers\Api\CartIncDecController::class, 'cartIncrement'])->name('api-cart-increment');
Route::POST('cart/decrement', [App\Http\Controllers\Api\CartIncDecController::class, 'cartDecrement'])->name('api-cart-decrement');

Route::get('provinces', [App\Http\Controllers\Api\LocationController::class, 'provinces'])->name('api-provinces');
Route::get('regencies/{provinces_id}', [App\Http\Controllers\Api\LocationController::class, 'regencies'])->name('api-regencies');
