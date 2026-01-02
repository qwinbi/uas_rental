@extends('layouts.app')

@section('title', 'Home - HoppWheels')

@section('content')
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Drive Your Dream Honda with <span class="text-warning">HoppWheels</span></h1>
                    <p class="lead mb-4">Experience the joy of driving with our premium Honda car rental service. From compact Brio to spacious CR-V, we have the perfect car for your journey.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('cars') }}" class="btn btn-light btn-lg px-4">
                            <i class="fas fa-car me-2"></i> Rent a Car
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-info-circle me-2"></i> Learn More
                        </a>
                        @guest
                        <a href="{{ route('register') }}" class="btn btn-warning btn-lg px-4">
                            <i class="fas fa-user-plus me-2"></i> Sign Up Free
                        </a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('images/car-hero.png') }}" alt="Honda Car" class="img-fluid" style="max-height: 400px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="page-title">Why Choose HoppWheels?</h2>
                <p class="text-muted">We provide the best car rental experience with our premium services</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <h4>Premium Honda Fleet</h4>
                        <p class="text-muted">Choose from our selection of well-maintained Honda vehicles: Brio, Jazz, Civic, HR-V, and CR-V.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Safe & Secure</h4>
                        <p class="text-muted">All our cars undergo regular maintenance and safety checks to ensure your peace of mind.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <h4>Easy QRIS Payment</h4>
                        <p class="text-muted">Quick and secure payments through QRIS. No hassle, just scan and pay!</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>24/7 Support</h4>
                        <p class="text-muted">Our customer service team is available round the clock to assist you with any queries.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4>Easy Booking</h4>
                        <p class="text-muted">Simple and quick booking process. Get your car in just a few clicks!</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 text-center p-4">
                        <div class="feature-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h4>Best Price Guarantee</h4>
                        <p class="text-muted">We offer the most competitive prices in the market with no hidden charges.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Cars Section -->
    <div class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="page-title mb-0">Popular Honda Cars</h2>
                    <p class="text-muted">Most rented cars by our customers</p>
                </div>
                <a href="{{ route('cars') }}" class="btn btn-primary">
                    View All Cars <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
            
            <div class="row g-4">
                @php
                    $popularCars = \App\Models\Car::where('available', true)->take(3)->get();
                @endphp
                
                @forelse($popularCars as $car)
                <div class="col-md-4">
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
                            <p class="card-text text-muted small">{{ Str::limit($car->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="fw-bold text-ocean-noir">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                                    <small class="text-muted d-block">/day</small>
                                </div>
                                <div class="text-end">
                                    <div class="small text-muted">
                                        <i class="fas fa-users me-1"></i> {{ $car->seats }} seats
                                    </div>
                                    <div class="small text-muted">
                                        <i class="fas fa-cog me-1"></i> {{ $car->transmission }}
                                    </div>
                                </div>
                            </div>
                            @if($car->available)
                                <a href="{{ route('payment.form') }}?car_id={{ $car->id }}" class="btn btn-primary w-100 mt-3">
                                    <i class="fas fa-calendar-alt me-2"></i> Rent Now
                                </a>
                            @else
                                <button class="btn btn-secondary w-100 mt-3" disabled>
                                    <i class="fas fa-times me-2"></i> Not Available
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-car fa-4x text-muted mb-3"></i>
                        <h4>No cars available at the moment</h4>
                        <p class="text-muted">Please check back later or contact us for more information.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-5" style="background: linear-gradient(135deg, var(--soft-berry) 0%, var(--berry-wine) 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 text-white">
                    <h2 class="mb-3">Ready to Start Your Journey?</h2>
                    <p class="mb-4">Join thousands of satisfied customers who have experienced the HoppWheels difference. Rent your dream Honda today!</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    @auth
                        <a href="{{ route('cars') }}" class="btn btn-light btn-lg px-4">
                            <i class="fas fa-car me-2"></i> Rent a Car Now
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 me-2">
                            <i class="fas fa-user-plus me-2"></i> Sign Up
                        </a>
                        <a href="{{ route('cars') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-car me-2"></i> Browse Cars
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection