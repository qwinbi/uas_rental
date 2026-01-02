<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_cars' => Car::count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_transactions' => Transaction::count(),
            'pending_payments' => Transaction::where('status', 'pending')->count(),
            'revenue' => Transaction::where('status', 'paid')->sum('total_price'),
            'available_cars' => Car::where('available', true)->count()
        ];

        $recentTransactions = Transaction::with(['user', 'car'])
            ->latest()
            ->take(5)
            ->get();

        $popularCars = Car::withCount('transactions')
            ->orderBy('transactions_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentTransactions', 'popularCars'));
    }
}