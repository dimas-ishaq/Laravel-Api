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
    // Ambil semua buku
    Route::get('/books', [BookController::class, 'index']);
    // Tambahkan buku
    Route::post('/books', [BookController::class, 'create']);
    // Ambil buku by id
    Route::get('/books/{id}', [BookController::class, 'show']);
    // Update Buku By Id
    Route::put('/books/{id}', [BookController::class, 'update']);
    // Menghapus buku by id
    Route::delete('/books/{id}', [BookController::class, 'create']);

    // Category Routing
    // Add category
    Route::post('/categories', [CategoryController::class, 'create']);
});





// Route Buku
