@extends('layouts.app')

@section('title', 'Login - HoppWheels')

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
                    <h2 class="text-indigo-night fw-bold mb-0">Welcome Back!</h2>
                    <p class="text-muted mb-0">Sign in to your HoppWheels account</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label text-ocean-noir fw-semibold">
                                <i class="fas fa-envelope me-2"></i>Email Address
                            </label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="Enter your email address">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label text-ocean-noir fw-semibold">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link p-0 text-decoration-none text-soft-berry" href="{{ route('password.request') }}">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password"
                                   placeholder="Enter your password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">
                                    Remember me
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-semibold">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                        </div>

                        <div class="text-center mb-4">
                            <p class="text-muted mb-2">Or sign in with</p>
                            <div class="d-flex justify-content-center gap-3">
                                <button type="button" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-google me-2"></i>Google
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-facebook me-2"></i>Facebook
                                </button>
                            </div>
                        </div>

                        <div class="text-center pt-3 border-top">
                            <p class="text-muted mb-0">Don't have an account?
                                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-berry-wine">
                                    Create one now
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted">
                    By signing in, you agree to our 
                    <a href="#" class="text-decoration-none text-ocean-noir">Terms of Service</a> and 
                    <a href="#" class="text-decoration-none text-ocean-noir">Privacy Policy</a>
                </p>
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
</style>
@endsection