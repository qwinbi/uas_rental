<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public API Routes
Route::post('/login', [AuthController::class, 'login']);
Route::get('/mobil', [CarController::class, 'index']);

// Protected API Routes (Require Authentication)
Route::middleware(['auth:sanctum'])->group(function () {
    // Authentication
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Car Management (Admin only for write operations)
    Route::post('/mobil', [CarController::class, 'store'])->middleware('admin');
    Route::get('/mobil/{car}', [CarController::class, 'show']);
    Route::put('/mobil/{car}', [CarController::class, 'update'])->middleware('admin');
    Route::delete('/mobil/{car}', [CarController::class, 'destroy'])->middleware('admin');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    
    // Payment
    Route::post('/pembayaran', [PaymentController::class, 'store']);
    Route::post('/pembayaran/{payment}/confirm', [PaymentController::class, 'confirm']);
    
    // Transactions
    Route::get('/transaksi', [TransactionController::class, 'index']);
    Route::get('/transaksi/{transaction}', [TransactionController::class, 'show']);
});