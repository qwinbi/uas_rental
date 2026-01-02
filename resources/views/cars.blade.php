@extends('layouts.app')

@section('title', 'Available Cars - HoppWheels')

@section('content')
    <div class="container py-5">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="page-title">Our Honda Fleet</h1>
                <p class="text-muted">Choose from our premium selection of Honda vehicles</p>
            </div>
            
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-filter me-2"></i> Filter by Type
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('cars') }}">All Cars</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('cars', ['type' => 'Brio']) }}">Brio</a></li>
                    <li><a class="dropdown-item" href="{{ route('cars', ['type' => 'Jazz']) }}">Jazz</a></li>
                    <li><a class="dropdown-item" href="{{ route('cars', ['type' => 'Civic']) }}">Civic</a></li>
                    <li><a class="dropdown-item" href="{{ route('cars', ['type' => 'HR-V']) }}">HR-V</a></li>
                    <li><a class="dropdown-item" href="{{ route('cars', ['type' => 'CR-V']) }}">CR-V</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Filter Status -->
        @if(request()->has('type'))
        <div class="alert alert-info mb-4">
            Showing cars for type: <strong>{{ request('type') }}</strong>
            <a href="{{ route('cars') }}" class="float-end">Clear filter</a>
        </div>
        @endif
        
        <!-- Car Grid -->
        <div class="row g-4">
            @php
                $cars = \App\Models\Car::when(request('type'), function($query, $type) {
                    return $query->where('type', $type);
                })->where('available', true)->paginate(9);
            @endphp
            
            @forelse($cars as $car)
            <div class="col-lg-4 col-md-6">
                <div class="car-card card h-100">
                    <div class="position-relative">
                        <img src="{{ $car->image_url }}" class="car-image card-img-top" alt="{{ $car->name }}">
                        @auth
                            <button class="heart-btn {{ auth()->user()->hasFavorite($car->id) ? 'active' : '' }}" 
                                    data-car-id="{{ $car->id }}">
                                <i class="{{ auth()->user()->hasFavorite($car->id) ? 'fas' : 'far' }} fa-heart"></i>
                            </button>
                        @endauth
                        @if(!$car->available)
                            <div class="position-absolute top-0 start-0 w-100 bg-danger text-white text-center py-1">
                                Not Available
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $car->name }}</h5>
                            <span class="badge bg-soft-berry">{{ $car->type }}</span>
                        </div>
                        <p class="card-text text-muted">{{ Str::limit($car->description, 120) }}</p>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users text-ocean-noir me-2"></i>
                                    <small>{{ $car->seats }} Seats</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-cog text-ocean-noir me-2"></i>
                                    <small>{{ $car->transmission }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-gas-pump text-ocean-noir me-2"></i>
                                    <small>{{ $car->fuel_type }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-ocean-noir me-2"></i>
                                    <small>{{ $car->available ? 'Available' : 'Booked' }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div>
                                <span class="fw-bold text-ocean-noir fs-4">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                                <small class="text-muted d-block">per day</small>
                            </div>
                            
                            @if($car->available)
                                <a href="{{ route('payment.form') }}?car_id={{ $car->id }}" class="btn btn-primary">
                                    <i class="fas fa-calendar-alt me-2"></i> Rent
                                </a>
                            @else
                                <button class="btn btn-secondary" disabled>
                                    <i class="fas fa-times me-2"></i> Booked
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-car fa-4x text-muted mb-3"></i>
                    <h4>No cars available at the moment</h4>
                    <p class="text-muted">Please check back later or contact us for more information.</p>
                    <a href="{{ route('cars') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-redo me-2"></i> Refresh
                    </a>
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($cars->hasPages())
        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($cars->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $cars->previousPageUrl() }}" rel="prev">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($cars->getUrlRange(1, $cars->lastPage()) as $page => $url)
                        @if ($page == $cars->currentPage())
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
                    @if ($cars->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $cars->nextPageUrl() }}" rel="next">
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
    </div>
    
    <!-- Floating Action Button -->
    @auth
        <a href="{{ route('profile.favorites') }}" class="floating-btn">
            <i class="fas fa-heart"></i>
        </a>
    @endauth
    
    @guest
        <a href="{{ route('register') }}" class="floating-btn" style="bottom: 100px;">
            <i class="fas fa-user-plus"></i>
        </a>
    @endguest
@endsection