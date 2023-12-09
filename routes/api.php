<?php

use App\Http\Controllers\Api\Auth\AccountController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CouponController;
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
Route::resource('coupons', CouponController::class)->only([
    'index', 'show'
]);
Route::post('coupons/find', [CouponController::class, 'findByCode'])->name('coupon.find');
Route::get('coupons/apply/{code}', [CouponController::class, 'apply'])->name('coupon.apply');
// Member Route

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
});


Route::get('/do-not-permission', function () {
    return response()->json(['message' => 'Unauthorized'], 403);
})->name('not_auth');
