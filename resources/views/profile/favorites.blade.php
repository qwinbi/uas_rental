@extends('layouts.app')

@section('title', 'Favorite Cars - HoppWheels')

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
                        <a href="{{ route('profile.history') }}" class="nav-link text-dark mb-2">
                            <i class="fas fa-history me-2"></i> Rental History
                        </a>
                        <a href="{{ route('profile.favorites') }}" class="nav-link active bg-light rounded mb-2">
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
                            <h4 class="mb-0"><i class="fas fa-heart me-2 text-berry-wine"></i>Favorite Cars</h4>
                            <p class="text-muted">Your saved cars for easy access</p>
                        </div>
                        <a href="{{ route('cars') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add More
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-notification">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    
                    @if($favorites->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-heart fa-4x text-muted mb-3"></i>
                        <h4>No favorite cars yet</h4>
                        <p class="text-muted">Start adding cars to your favorites by clicking the heart icon on any car.</p>
                        <a href="{{ route('cars') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-car me-2"></i>Browse Cars
                        </a>
                    </div>
                    @else
                    <div class="row g-4">
                        @foreach($favorites as $favorite)
                        <div class="col-md-6 col-lg-4">
                            <div class="car-card card h-100">
                                <div class="position-relative">
                                    <img src="{{ $favorite->car->image_url }}" 
                                         class="car-image card-img-top" alt="{{ $favorite->car->name }}">
                                    <button class="heart-btn active" 
                                            data-car-id="{{ $favorite->car->id }}">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">{{ $favorite->car->name }}</h5>
                                        <span class="badge bg-soft-berry">{{ $favorite->car->type }}</span>
                                    </div>
                                    <p class="card-text text-muted small">{{ Str::limit($favorite->car->description, 80) }}</p>
                                    
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-users text-ocean-noir me-2"></i>
                                                <small>{{ $favorite->car->seats }} Seats</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-cog text-ocean-noir me-2"></i>
                                                <small>{{ $favorite->car->transmission }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <div>
                                            <span class="fw-bold text-ocean-noir">Rp {{ number_format($favorite->car->price_per_day, 0, ',', '.') }}</span>
                                            <small class="text-muted d-block">/day</small>
                                        </div>
                                        
                                        @if($favorite->car->available)
                                            <a href="{{ route('payment.form') }}?car_id={{ $favorite->car->id }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-calendar-alt me-1"></i>Rent
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="fas fa-times me-1"></i>Booked
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-0 text-end py-2">
                                    <small class="text-muted">
                                        Added {{ $favorite->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    @if($favorites->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($favorites->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $favorites->previousPageUrl() }}" rel="prev">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($favorites->getUrlRange(1, $favorites->lastPage()) as $page => $url)
                                    @if ($page == $favorites->currentPage())
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
                                @if ($favorites->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $favorites->nextPageUrl() }}" rel="next">
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
    .car-card .heart-btn {
        top: 10px;
        right: 10px;
    }
</style>

@php
    // This would come from controller
    $favorites = auth()->user()->favorites()->with('car')->latest()->paginate(6);
@endphp
@endsection