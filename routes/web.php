<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])
    ->name('categories');
Route::get('/categories/{id}', [App\Http\Controllers\CategoryController::class, 'detail'])
    ->name('categories-detail');

Route::get('/details/{id}', [App\Http\Controllers\DetailController::class, 'index'])
    ->name('detail');
Route::post('/details/{id}', [App\Http\Controllers\DetailController::class, 'add'])
    ->name('detail-add');

Route::post('/checkout/callback', [App\Http\Controllers\CheckoutController::class, 'callback'])
    ->name('midtrans-callback');

Route::get('/success', [App\Http\Controllers\CartController::class, 'success'])
    ->name('success');

Route::get('/register/success', [App\Http\Controllers\Auth\RegisterController::class, 'success'])
    ->name('register-success');

Route::group(['middleware' => ['auth']], function () {

    // Cart
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])
        ->name('cart');
    Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'delete'])
        ->name('cart-delete');

    //Midtrans
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])
        ->name('checkout');

    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/dashboard/transactions/{id}', [App\Http\Controllers\DashboardController::class, 'details'])
        ->name('dashboard-transaction-details');
    Route::get('/dashboard/account', [App\Http\Controllers\DashboardSettingController::class, 'account'])
        ->name('dashboard-settings-account');
});

// Admin Routes
Route::prefix('admin')
    // ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('admin-dashboard');

        // Category
        Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);

        // User
        Route::resource('user', App\Http\Controllers\Admin\UserController::class);

        // Products
        Route::resource('product', App\Http\Controllers\Admin\ProductController::class);

        // Product Gallery
        Route::resource('product-gallery', App\Http\Controllers\Admin\ProductGalleryController::class);

        Route::get('/dashboard/transactions', [App\Http\Controllers\Admin\DashboardTransactionController::class, 'index'])
            ->name('admin-dashboard-transactions');
    });

Auth::routes();
