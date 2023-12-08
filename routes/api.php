<?php

use App\Http\Controllers\Api\Auth\AccountController;
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

Route::get('/do-not-permission', function () {
    return response()->json([], 403);
})->name('not_auth');
