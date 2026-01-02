@extends('layouts.app')

@section('title', 'Rental History - HoppWheels')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar Menu -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                 alt="Profile" class="avatar-lg rounded-circle mb-3">
                        @else
                            <div class="avatar-lg rounded-circle bg-soft-berry text-white d-flex align-items-center justify-content-center mb-3 mx-auto"
                                 style="width: 100px; height: 100px;">
                                <span class="display-5">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                        <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                    </div>
                    
                    <div class="nav flex-column">
                        <a href="{{ route('profile.edit') }}" class="nav-link text-dark mb-2">
                            <i class="fas fa-user me-2"></i> Profile
                        </a>
                        <a href="{{ route('profile.history') }}" class="nav-link active bg-light rounded mb-2">
                            <i class="fas fa-history me-2"></i> Rental History
                        </a>
                        <a href="{{ route('profile.favorites') }}" class="nav-link text-dark mb-2">
                            <i class="fas fa-heart me-2"></i> Favorite Cars
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-3">
                            @csrf
                            <button type="submit" class="nav-link text-dark border-0 bg-transparent w-100 text-start">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><i class="fas fa-history me-2"></i>Rental History</h4>
                            <p class="text-muted">All your car rental transactions</p>
                        </div>
                        <a href="{{ route('cars') }}" class="btn btn-primary">
                            <i class="fas fa-car me-2"></i>Rent New Car
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-notification">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('info'))
                        <div class="alert alert-info alert-notification">
                            <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                        </div>
                    @endif
                    
                    @if($transactions->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-history fa-4x text-muted mb-3"></i>
                        <h4>No rental history yet</h4>
                        <p class="text-muted">You haven't rented any cars yet. Start your journey now!</p>
                        <a href="{{ route('cars') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-car me-2"></i>Browse Cars
                        </a>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Booking Code</th>
                                    <th>Car</th>
                                    <th>Rental Period</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Payment Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>
                                        <code>{{ $transaction->transaction_code }}</code>
                                        <br>
                                        <small class="text-muted">{{ $transaction->created_at->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $transaction->car->image_url }}" 
                                                 alt="{{ $transaction->car->name }}" 
                                                 class="rounded me-2" style="width: 50px; height: 35px; object-fit: cover;">
                                            <div>
                                                <strong>{{ $transaction->car->name }}</strong><br>
                                                <small class="text-muted">{{ $transaction->car->type }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $transaction->start_date->format('d/m/Y') }}<br>
                                        <small class="text-muted">to {{ $transaction->end_date->format('d/m/Y') }}</small><br>
                                        <small class="text-primary">{{ $transaction->total_days }} days</small>
                                    </td>
                                    <td>
                                        <strong class="text-ocean-noir">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong>
                                    </td>
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
                                    <td>
                                        @if($transaction->payment_date)
                                            {{ $transaction->payment_date->format('d/m/Y H:i') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction->status == 'pending')
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('payment.status', $transaction) }}" 
                                                   class="btn btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('payment.cancel', $transaction) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-outline-danger" 
                                                            onclick="return confirm('Cancel this booking?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($transaction->status == 'paid')
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <a href="{{ route('cars') }}" class="btn btn-sm btn-outline-primary">
                                                Rent Again
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($transactions->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($transactions->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $transactions->previousPageUrl() }}" rel="prev">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                                    @if ($page == $transactions->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($transactions->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $transactions->nextPageUrl() }}" rel="next">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table th {
        background-color: var(--indigo-night);
        color: white;
        border-color: var(--indigo-night);
    }
    
    .table td {
        vertical-align: middle;
    }
</style>
@endsection

@php
    // This would come from controller
    $transactions = auth()->user()->transactions()->with('car')->latest()->paginate(10);
@endphp