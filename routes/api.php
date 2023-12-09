<?php

use App\Http\Controllers\Api\Auth\AccountController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\ProductCommentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\ProductOptionController;
use App\Http\Controllers\Api\ProductReviewController;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\PersonalAccessToken;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth Route
Route::post('/login', [AccountController::class, 'login'])->name('login');
Route::post('/register', [AccountController::class, 'register'])->name('register');
// Public Route
Route::resource('banners', BannerController::class)->only([
    'index', 'show'
]);
Route::resource('categories', CategoryController::class)->only([
    'index', 'show'
]);
Route::get('categories/{category}/products', [ProductController::class, 'getByCategory'])->name('category.products');

Route::resource('coupons', CouponController::class)->only([
    'index', 'show'
]);
Route::post('coupons/find', [CouponController::class, 'findByCode'])->name('coupon.find');
Route::get('coupons/apply/{code}', [CouponController::class, 'apply'])->name('coupon.apply');

Route::resource('products', ProductController::class)->only([
    'index', 'show'
]);
Route::get('products/{product}/images', [ProductImageController::class, 'getByProduct'])->name('products.images');
Route::get('products/{product}/comments', [ProductCommentController::class, 'getByProduct'])->name('products.comments');
Route::get('products/{product}/options', [ProductOptionController::class, 'getByProduct'])->name('products.options');
Route::get('products/{product}/reviews', [ProductReviewController::class, 'getByProduct'])->name('products.reviews');
Route::resource('products-comments', ProductCommentController::class)->only([
    'index', 'show'
]);
// Member Route
Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('users/{user}', [ProfileController::class, 'get'])->name('users.get');
    Route::put('users/{user}', [ProfileController::class, 'update'])->name('users.update');
    Route::post('users/{user}/avatar', [ProfileController::class, 'avatar'])->name('users.avatar');
});
// Admin Route
Route::middleware(['auth:sanctum', 'checkRole'])->group(function () {
    Route::resource('banners', BannerController::class)->only([
        'store', 'update', 'destroy'
    ]);
    Route::resource('categories', CategoryController::class)->only([
        'store', 'update', 'destroy'
    ]);
    Route::resource('coupons', CouponController::class)->only([
        'store', 'update', 'destroy'
    ]);
    Route::resource('products', ProductController::class)->only([
        'store', 'update', 'destroy'
    ]);
    Route::resource('products-images', ProductImageController::class)->only([
        'store', 'destroy'
    ]);
    Route::resource('products-options', ProductOptionController::class)->only([
        'store', 'update', 'destroy'
    ]);
    Route::resource('products-comments', ProductCommentController::class)->only([
        'store', 'update', 'destroy'
    ]);
    Route::resource('products-reviews', ProductReviewController::class)->only([
        'store', 'update', 'destroy'
    ]);
    Route::get('users', [ProfileController::class, 'all'])->name('users.all');
    Route::put('users/{user}/role', [ProfileController::class, 'role'])->name('users.role');
    Route::delete('users/{user}', [ProfileController::class, 'destroy'])->name('users.destroy');
});


Route::get('/do-not-permission', function () {
    return response()->json(['message' => 'Unauthorized'], 403);
})->name('not_auth');
