@extends('layouts.app')

@section('title', 'Admin Dashboard - HoppWheels')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 mb-4 border-bottom">
        <h1 class="h2"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Export Report</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <i class="fas fa-calendar me-1"></i>
                This week
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-ocean-noir rounded">
                <i class="fas fa-car"></i>
                <h3>{{ $stats['total_cars'] }}</h3>
                <p>Total Cars</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-berry-wine rounded">
                <i class="fas fa-users"></i>
                <h3>{{ $stats['total_users'] }}</h3>
                <p>Total Users</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-soft-berry rounded">
                <i class="fas fa-exchange-alt"></i>
                <h3>{{ $stats['total_transactions'] }}</h3>
                <p>Total Transactions</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-indigo-night rounded">
                <i class="fas fa-money-bill-wave"></i>
                <h3>Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</h3>
                <p>Total Revenue</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-success rounded">
                <i class="fas fa-check-circle"></i>
                <h3>{{ $stats['available_cars'] }}</h3>
                <p>Available Cars</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-warning rounded">
                <i class="fas fa-clock"></i>
                <h3>{{ $stats['pending_payments'] }}</h3>
                <p>Pending Payments</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-info rounded">
                <i class="fas fa-heart"></i>
                <h3>{{ \App\Models\Favorite::count() }}</h3>
                <p>Total Favorites</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card bg-secondary rounded">
                <i class="fas fa-star"></i>
                <h3>{{ number_format($stats['revenue'] / max($stats['total_transactions'], 1), 0, ',', '.') }}</h3>
                <p>Avg. Transaction</p>
            </div>
        </div>
    </div>

    <!-- Charts & Recent Activity -->
    <div class="row">
        <!-- Recent Transactions -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Transactions</h5>
                    <a href="{{ route('admin.payment.transactions') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Customer</th>
                                    <th>Car</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTransactions as $transaction)
                                <tr>
                                    <td><code>{{ $transaction->transaction_code }}</code></td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>{{ $transaction->car->name }}</td>
                                    <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'pending' => 'badge-pending',
                                                'paid' => 'badge-paid',
                                                'cancelled' => 'badge-cancelled',
                                                'failed' => 'badge-failed'
                                            ][$transaction->status];
                                        @endphp
                                        <span class="badge-status {{ $statusClass }}">{{ ucfirst($transaction->status) }}</span>
                                    </td>
                                    <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Cars & Quick Stats -->
        <div class="col-lg-4 mb-4">
            <!-- Popular Cars -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Popular Cars</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($popularCars as $car)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ $car->name }}</h6>
                                <small class="text-muted">{{ $car->transactions_count }} rentals</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $car->type }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-car text-primary"></i>
                            </div>
                            <h4 class="mb-0">{{ $stats['available_cars'] }}</h4>
                            <small class="text-muted">Available</small>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-users text-success"></i>
                            </div>
                            <h4 class="mb-0">{{ $stats['total_users'] }}</h4>
                            <small class="text-muted">Users</small>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-check-circle text-info"></i>
                            </div>
                            <h4 class="mb-0">{{ \App\Models\Transaction::where('status', 'paid')->count() }}</h4>
                            <small class="text-muted">Completed</small>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-clock text-warning"></i>
                            </div>
                            <h4 class="mb-0">{{ $stats['pending_payments'] }}</h4>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('admin.cars.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-plus me-2"></i>Add New Car
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.payment.qris') }}" class="btn btn-success w-100">
                                <i class="fas fa-qrcode me-2"></i>Update QRIS
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.about.edit') }}" class="btn btn-info w-100">
                                <i class="fas fa-edit me-2"></i>Edit About Page
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.logo.edit') }}" class="btn btn-warning w-100">
                                <i class="fas fa-image me-2"></i>Change Logo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Users -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Recent Users</h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Joined Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\User::where('role', 'user')->latest()->take(5)->get() as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($user->avatar)
                                                <img src="{{ asset('storage/' . $user->avatar) }}" 
                                                     alt="Avatar" class="avatar me-2">
                                            @else
                                                <div class="avatar bg-soft-berry text-white d-flex align-items-center justify-content-center me-2">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                            @endif
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    // Default values for dashboard
    $stats = [
        'total_cars' => \App\Models\Car::count(),
        'total_users' => \App\Models\User::where('role', 'user')->count(),
        'total_transactions' => \App\Models\Transaction::count(),
        'pending_payments' => \App\Models\Transaction::where('status', 'pending')->count(),
        'revenue' => \App\Models\Transaction::where('status', 'paid')->sum('total_price'),
        'available_cars' => \App\Models\Car::where('available', true)->count()
    ];
    
    $recentTransactions = \App\Models\Transaction::with(['user', 'car'])
        ->latest()
        ->take(5)
        ->get();
    
    $popularCars = \App\Models\Car::withCount('transactions')
        ->orderBy('transactions_count', 'desc')
        ->take(5)
        ->get();
@endphp