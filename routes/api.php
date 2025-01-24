<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [JWTAuthController::class, 'register']);
    Route::post('login', [JWTAuthController::class, 'login']);
    Route::post('refresh', [JWTAuthController::class, 'refresh']);

    Route::middleware([JwtMiddleware::class])->group(function () {
        Route::get('user', [JWTAuthController::class, 'getUser']);
        Route::post('logout', [JWTAuthController::class, 'logout']);
    });
});

Route::prefix('games')->group(function () {
    Route::get('/', [GameController::class, 'index']);
    Route::get('/{game}', [GameController::class, 'show']);

    Route::middleware([JwtMiddleware::class])->group(function () {
        Route::post('/', [GameController::class, 'store']); 
        Route::put('/{game}', [GameController::class, 'update']); 
        Route::delete('/{game}', [GameController::class, 'destroy']);
    });
});

Route::prefix('images')->group(function () {
    Route::post('/', [ImageController::class, 'store']);
    Route::get('/by-type', [ImageController::class, 'getImagesByType']);
});

Route::get('/genres', GenreController::class);
