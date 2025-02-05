<?php

use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

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
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
    Route::get('profile', [\App\Http\Controllers\AuthController::class, 'profile']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'users'
], function () {
    Route::post('register', [App\Http\Controllers\UserController::class, 'signup']);
    Route::put('edit', [App\Http\Controllers\UserController::class, 'updateProfile']);
});
