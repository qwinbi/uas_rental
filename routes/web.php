<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cars', [HomeController::class, 'cars'])->name('cars');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
});

// Authenticated User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/history', [ProfileController::class, 'history'])->name('profile.history');
        Route::get('/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
        Route::post('/favorite/toggle', [ProfileController::class, 'toggleFavorite'])->name('favorite.toggle');
    });
    
    // Payment Routes
    Route::prefix('payment')->group(function () {
        Route::get('/form', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
        Route::post('/process', [PaymentController::class, 'processPayment'])->name('payment.process');
        Route::get('/status/{transaction}', [PaymentController::class, 'paymentStatus'])->name('payment.status');
        Route::post('/confirm/{transaction}', [PaymentController::class, 'confirmPayment'])->name('payment.confirm');
        Route::post('/cancel/{transaction}', [PaymentController::class, 'cancelPayment'])->name('payment.cancel');
    });
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Car Management
    Route::resource('cars', AdminCarController::class)->except(['show']);
    
    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    
    // Payment Management
    Route::prefix('payment')->group(function () {
        Route::get('/qris', [AdminPaymentController::class, 'qris'])->name('admin.payment.qris');
        Route::put('/qris', [AdminPaymentController::class, 'updateQris'])->name('admin.payment.qris.update');
        Route::get('/transactions', [AdminPaymentController::class, 'transactions'])->name('admin.payment.transactions');
        Route::post('/transactions/{transaction}/status', [AdminPaymentController::class, 'updateTransactionStatus'])->name('admin.payment.update-status');
    });
    
    // About Page Management
    Route::get('/about', [AboutController::class, 'edit'])->name('admin.about.edit');
    Route::put('/about', [AboutController::class, 'update'])->name('admin.about.update');
    
    // Logo Management
    Route::get('/logo', [LogoController::class, 'edit'])->name('admin.logo.edit');
    Route::put('/logo', [LogoController::class, 'update'])->name('admin.logo.update');
});

// Fallback Route
Route::fallback(function () {
    return redirect()->route('home');
});