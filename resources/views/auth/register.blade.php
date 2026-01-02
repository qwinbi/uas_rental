@extends('layouts.app')

@section('title', 'Register - HoppWheels')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white border-0 text-center py-4">
                    <a href="{{ route('home') }}" class="d-inline-block mb-3">
                        @php
                            $logo = \App\Models\Logo::first();
                            $logoUrl = $logo->logo_url ?? asset('images/logo.png');
                        @endphp
                        <img src="{{ $logoUrl }}" alt="HoppWheels Logo" height="40">
                    </a>
                    <h2 class="text-indigo-night fw-bold mb-0">Create Account</h2>
                    <p class="text-muted mb-0">Join HoppWheels and start your journey</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="name" class="form-label text-ocean-noir fw-semibold">
                                    <i class="fas fa-user me-2"></i>Full Name
                                </label>
                                <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                       placeholder="Enter your full name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label text-ocean-noir fw-semibold">
                                    <i class="fas fa-phone me-2"></i>Phone Number
                                </label>
                                <input id="phone" type="text" class="form-control form-control-lg @error('phone') is-invalid @enderror" 
                                       name="phone" value="{{ old('phone') }}" autocomplete="phone"
                                       placeholder="Enter phone number">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label text-ocean-noir fw-semibold">
                                <i class="fas fa-envelope me-2"></i>Email Address
                            </label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email"
                                   placeholder="Enter your email address">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="password" class="form-label text-ocean-noir fw-semibold">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password"
                                       placeholder="Create password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password-confirm" class="form-label text-ocean-noir fw-semibold">
                                    <i class="fas fa-lock me-2"></i>Confirm Password
                                </label>
                                <input id="password-confirm" type="password" class="form-control form-control-lg" 
                                       name="password_confirmation" required autocomplete="new-password"
                                       placeholder="Confirm password">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label text-ocean-noir fw-semibold">
                                <i class="fas fa-map-marker-alt me-2"></i>Address
                            </label>
                            <textarea id="address" class="form-control form-control-lg @error('address') is-invalid @enderror" 
                                      name="address" rows="2" autocomplete="address"
                                      placeholder="Enter your address">{{ old('address') }}</textarea>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" required>
                                <label class="form-check-label text-muted" for="terms">
                                    I agree to the 
                                    <a href="#" class="text-decoration-none text-ocean-noir">Terms of Service</a> and 
                                    <a href="#" class="text-decoration-none text-ocean-noir">Privacy Policy</a>
                                </label>
                                @error('terms')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-semibold">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </button>
                        </div>

                        <div class="text-center pt-3 border-top">
                            <p class="text-muted mb-0">Already have an account?
                                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-berry-wine">
                                    Sign In
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Demo Accounts:</strong><br>
                    Admin: admin@email.com / admin123<br>
                    User: user@gmail.com / user123
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control-lg {
        padding: 12px 16px;
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s;
    }
    
    .form-control-lg:focus {
        border-color: var(--ocean-noir);
        box-shadow: 0 0 0 0.25rem rgba(17, 70, 101, 0.25);
    }
    
    .form-check-input:checked {
        background-color: var(--ocean-noir);
        border-color: var(--ocean-noir);
    }
    
    .card {
        border-radius: 20px;
    }
    
    textarea.form-control-lg {
        resize: none;
    }
</style>
@endsection