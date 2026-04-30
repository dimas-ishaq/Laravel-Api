<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Authentication Routing
    Route::get('/users', [AuthController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Book Routing
    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'create']);

    // Category Routing
    Route::post('/categories', [CategoryController::class, 'create']);
});





// Route Buku
