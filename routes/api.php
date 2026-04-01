<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users', [AuthController::class, 'index']);
Route::post('/register', [AuthController::class, 'create']);

// Route Buku
// Route::get('/books', [BookController::class, 'index']);
// Route::post('/books', [BookController::class, 'create']);
