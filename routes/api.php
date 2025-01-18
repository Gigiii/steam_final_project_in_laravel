<?php

use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('test', [JWTAuthController::class, 'register']);
Route::prefix('auth')->group(function () {
    Route::post('register', [JWTAuthController::class, 'register']);
    Route::post('login', [JWTAuthController::class, 'login']);
    Route::post('refresh', [JWTAuthController::class, 'refresh']);

    Route::middleware([JwtMiddleware::class])->group(function () {
        Route::get('user', [JWTAuthController::class, 'getUser']);
        Route::post('logout', [JWTAuthController::class, 'logout']);
    });
});
