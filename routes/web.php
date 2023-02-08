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
Route::get('/product', [App\Http\Controllers\HomeController::class, 'product'])
    ->name('product');

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

    Route::get('/mywishlist', [App\Http\Controllers\WishlistController::class, 'index'])
        ->name('myWishlist');
    Route::post('/wishlist', [App\Http\Controllers\WishlistController::class, 'wishlist'])
        ->name('wishlist');

    // Cart
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])
        ->name('cart');
    Route::get('/cart/pricing', [App\Http\Controllers\CartController::class, 'pricing'])
        ->name('cart-pricing');
    Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'delete'])
        ->name('cart-delete');

    //Midtrans
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])
        ->name('checkout');
    Route::get('/payment/{id}', [App\Http\Controllers\CheckoutController::class, 'payment'])
        ->name('payment');

    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard/transactions', [App\Http\Controllers\DashboardTransactionController::class, 'index'])
        ->name('dashboard-transaction');
    Route::get('/dashboard/transactions/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'detail'])
        ->name('dashboard-transaction-details');
    Route::get('/dashboard/transactions/review/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'review'])
        ->name('dashboard-transaction-review');
    Route::post('/dashboard/transactions/review/add', [App\Http\Controllers\DashboardTransactionController::class, 'addReview'])
        ->name('dashboard-transaction-add-review');
    Route::get('/dashboard/transactions/success/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'success'])
        ->name('dashboard-transaction-success');
    Route::get('/dashboard/transactions/cancel/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'cancel'])
        ->name('dashboard-transaction-cancel');

    Route::get('/dashboard/account', [App\Http\Controllers\DashboardSettingController::class, 'account'])
        ->name('dashboard-settings-account');
    Route::post('/dashboard/account/update', [App\Http\Controllers\DashboardSettingController::class, 'update'])
        ->name('dashboard-settings-account-update');
});

Route::get('/admin/product/search', [App\Http\Controllers\Admin\ProductController::class, 'search'])
    ->name('admin-dashboard-product-search');

// Admin Routes
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('admin-dashboard');

        // Category
        Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);
        Route::get('/category/delete/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])
            ->name('admin-dashboard-category-delete');

        // User
        Route::resource('user', App\Http\Controllers\Admin\UserController::class);

        // Products
        Route::resource('product', App\Http\Controllers\Admin\ProductController::class);
        Route::get('/product/delete/{id}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])
            ->name('admin-dashboard-product-delete');


        Route::get('/product/detail/{id}', [App\Http\Controllers\Admin\ProductController::class, 'detail'])
            ->name('admin-dashboard-product-details');
        Route::post('/product/detail/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update'])
            ->name('admin-dashboard-product-update');

        Route::post('/product/gallery/upload', [App\Http\Controllers\Admin\ProductController::class, 'uploadGallery'])
            ->name('admin-dashboard-product-gallery-upload');
        Route::get('/product/gallery/delete/{id}', [App\Http\Controllers\Admin\ProductController::class, 'deleteGallery'])
            ->name('admin-dashboard-product-gallery-delete');

        Route::get('/dashboard/transactions', [App\Http\Controllers\Admin\DashboardTransactionController::class, 'index'])
            ->name('admin-dashboard-transactions');
        Route::get('/dashboard/transactions/{id}', [App\Http\Controllers\Admin\DashboardTransactionController::class, 'detail'])
            ->name('admin-dashboard-transaction-details');
        Route::get('/dashboard/transactions/success/{id}', [App\Http\Controllers\Admin\DashboardTransactionController::class, 'success'])
            ->name('admin-dashboard-transaction-success');

        Route::post('/dashboard/transactions/{id}', [App\Http\Controllers\Admin\DashboardTransactionController::class, 'update'])
            ->name('admin-dashboard-transaction-update');
    });

Auth::routes();
