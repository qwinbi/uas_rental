@extends('layouts.app')

@section('title', 'My Profile - HoppWheels')

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
                        <span class="badge bg-primary mt-2">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                    
                    <div class="nav flex-column">
                        <a href="{{ route('profile.edit') }}" class="nav-link active bg-light rounded mb-2">
                            <i class="fas fa-user me-2"></i> Profile
                        </a>
                        <a href="{{ route('profile.history') }}" class="nav-link text-dark mb-2">
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
                    <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edit Profile</h4>
                    <p class="text-muted">Update your personal information</p>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-notification">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Avatar Upload -->
                            <div class="col-md-4 text-center mb-4">
                                <div class="position-relative">
                                    @if(auth()->user()->avatar)
                                        <img id="avatarPreview" src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                             alt="Profile" class="img-fluid rounded-circle mb-3" 
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <div id="avatarPreview" class="rounded-circle bg-soft-berry text-white d-flex align-items-center justify-content-center mb-3 mx-auto"
                                             style="width: 150px; height: 150px;">
                                            <span class="display-4">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    
                                    <label for="avatar" class="btn btn-sm btn-primary position-absolute" 
                                           style="bottom: 10px; right: 50px; transform: translateX(50%);">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" class="d-none" id="avatar" name="avatar" accept="image/*">
                                </div>
                                <small class="text-muted">Click camera icon to upload photo</small>
                            </div>
                            
                            <!-- Form Fields -->
                            <div class="col-md-8">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address *</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="role" class="form-label">Account Type</label>
                                        <input type="text" class="form-control" value="{{ ucfirst(auth()->user()->role) }}" disabled>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" name="address" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Member Since</label>
                                    <input type="text" class="form-control" 
                                           value="{{ auth()->user()->created_at->format('d F Y') }}" disabled>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Account Stats -->
            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-history fa-2x mb-2"></i>
                            <h3>{{ auth()->user()->transactions()->count() }}</h3>
                            <p class="mb-0">Total Rentals</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-heart fa-2x mb-2"></i>
                            <h3>{{ auth()->user()->favorites()->count() }}</h3>
                            <p class="mb-0">Favorite Cars</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-berry-wine text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-car fa-2x mb-2"></i>
                            <h3>{{ auth()->user()->transactions()->where('status', 'paid')->count() }}</h3>
                            <p class="mb-0">Active Rentals</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-link.active {
        background-color: var(--ocean-noir) !important;
        color: white !important;
    }
    
    .nav-link {
        padding: 10px 15px;
        border-radius: 8px;
        transition: all 0.3s;
    }
    
    .nav-link:hover {
        background-color: #f8f9fa;
    }
</style>

<script>
    // Preview avatar image
    document.getElementById('avatar').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                // Replace div with image
                const img = document.createElement('img');
                img.id = 'avatarPreview';
                img.src = e.target.result;
                img.className = 'img-fluid rounded-circle mb-3';
                img.style = 'width: 150px; height: 150px; object-fit: cover;';
                preview.parentNode.replaceChild(img, preview);
            }
        }
        reader.readAsDataURL(e.target.files[0]);
    });
</script>
@endsection