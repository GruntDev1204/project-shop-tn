<?php

use Illuminate\Support\Facades\Route;
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

Route::middleware(['api'])->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/', [App\Http\Controllers\ProductController::class, 'getAll']);
        Route::get('/{id}', [App\Http\Controllers\ProductController::class, 'getById']);
        Route::post('/', [App\Http\Controllers\ProductController::class, 'create']);
        Route::delete('/{id}', [App\Http\Controllers\ProductController::class, 'destroy']);
        Route::put('/{id}', [App\Http\Controllers\ProductController::class, 'update']);
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [App\Http\Controllers\CategoryController::class, 'getAll']);
        Route::get('/{id}', [App\Http\Controllers\CategoryController::class, 'getById']);
        Route::post('/', [App\Http\Controllers\CategoryController::class, 'create']);
        Route::delete('/{id}', [App\Http\Controllers\CategoryController::class, 'destroy']);
        Route::put('/{id}', [App\Http\Controllers\CategoryController::class, 'update']);
    });

    Route::group([
        'prefix' => 'auth'
    ], function () {
        Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
        Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
        Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
        Route::get('profile', [\App\Http\Controllers\AuthController::class, 'profile']);
        Route::post('reset-password', [\App\Http\Controllers\AuthController::class, 'resetPassword']);
        Route::get('check-auth', [\App\Http\Controllers\AuthController::class, 'checkAuth']);
    });

    Route::group([
        'prefix' => 'users'
    ], function () {
        Route::post('/', [App\Http\Controllers\UserController::class, 'signup']);
        Route::put('/', [App\Http\Controllers\UserController::class, 'updateProfile']);
        Route::get('/active/send-mail', [App\Http\Controllers\UserController::class, 'sendMail']);
        Route::get('/active/{hash}', [App\Http\Controllers\UserController::class, 'activeUsers']);
        Route::get('/change-role/{hash}', [App\Http\Controllers\UserController::class, 'changeRole']);
    });
});
