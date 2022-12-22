<?php

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
Route::get('/details/{id}', [App\Http\Controllers\DetailController::class, 'index'])->name('detail');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::get('/success', [App\Http\Controllers\CartController::class, 'success'])->name('success');

Route::get('/register/success', [App\Http\Controllers\Auth\RegisterController::class, 'success'])->name('register-success');

// User Routes
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/transactions', [App\Http\Controllers\DashboardController::class, 'transaction'])->name('dashboard-transactions');
Route::get('/dashboard/account', [App\Http\Controllers\DashboardSettingController::class, 'account'])->name('dashboard-settings-account');

// Admin Routes
Route::get('/admin/dashboard/products', [App\Http\Controllers\Admin\DashboardProductController::class, 'index'])->name('dashboard-product');
Route::get('/admin/dashboard/products/create', [App\Http\Controllers\Admin\DashboardProductController::class, 'create'])->name('dashboard-product-create');
Route::get('/admin/dashboard/products/{id}', [App\Http\Controllers\Admin\DashboardProductController::class, 'detail'])->name('dashboard-product-detail');

Route::get('/admin/dashboard/transactions', [App\Http\Controllers\Admin\DashboardTransactionController::class, 'index'])->name('dashboard-transactions');
Auth::routes();
