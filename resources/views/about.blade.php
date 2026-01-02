@extends('layouts.app')

@section('title', 'About Us - HoppWheels')

@section('content')
    <div class="container py-5">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h1 class="page-title">About HoppWheels</h1>
            <p class="lead text-muted">Your trusted partner for Honda car rentals</p>
        </div>
        
        @php
            $about = \App\Models\About::first();
        @endphp
        
        @if($about)
        <!-- Profile Card -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <img src="{{ $about->avatar_url }}" 
                                     alt="{{ $about->name }}" 
                                     class="avatar-lg rounded-circle border border-4 border-primary mb-3"
                                     style="width: 200px; height: 200px; object-fit: cover;">
                                <h4 class="mb-1">{{ $about->name }}</h4>
                                <p class="text-muted mb-0">Developer & Creator</p>
                                <div class="mt-3">
                                    <a href="#" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fab fa-github"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h3 class="mb-4 text-berry-wine">Project Information</h3>
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-3 me-3">
                                                <i class="fas fa-id-card text-ocean-noir"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">NIM</small>
                                                <strong>{{ $about->nim }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-3 me-3">
                                                <i class="fas fa-users text-ocean-noir"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Class</small>
                                                <strong>{{ $about->class }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-3 me-3">
                                                <i class="fas fa-graduation-cap text-ocean-noir"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Major</small>
                                                <strong>{{ $about->major }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-3 me-3">
                                                <i class="fas fa-laptop-code text-ocean-noir"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Program</small>
                                                <strong>Sistem Informasi</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-light p-4 rounded mb-4">
                                    <h5 class="mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Project Description</h5>
                                    <p class="mb-0">{{ $about->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-warning text-center">
            <i class="fas fa-exclamation-triangle me-2"></i>
            About page content has not been set up yet. Please contact administrator.
        </div>
        @endif
        
        <!-- Technologies & Features Used -->
        <div class="mb-5">
            <h2 class="text-center mb-4">Technologies & Features Used</h2>
            <div class="row g-4">
                @php
                    $features = [
                        ['name' => 'Laravel 10', 'icon' => 'fab fa-laravel', 'description' => 'Latest PHP framework for robust web applications'],
                        ['name' => 'Laravel Breeze', 'icon' => 'fas fa-wind', 'description' => 'Authentication scaffolding with Blade templates'],
                        ['name' => 'Blade Template', 'icon' => 'fas fa-code', 'description' => 'Powerful templating engine for dynamic views'],
                        ['name' => 'Role & Middleware', 'icon' => 'fas fa-user-tag', 'description' => 'Secure role-based access control system'],
                        ['name' => 'CRUD Operations', 'icon' => 'fas fa-database', 'description' => 'Complete Create, Read, Update, Delete functionality'],
                        ['name' => 'File Upload', 'icon' => 'fas fa-upload', 'description' => 'Secure file uploads with storage link'],
                        ['name' => 'QRIS Payment', 'icon' => 'fas fa-qrcode', 'description' => 'Digital payment system with QR code'],
                        ['name' => 'Notification System', 'icon' => 'fas fa-bell', 'description' => 'Real-time alerts and notifications'],
                        ['name' => 'REST API', 'icon' => 'fas fa-server', 'description' => 'Full RESTful API for mobile/third-party apps'],
                        ['name' => 'Aesthetic UI', 'icon' => 'fas fa-palette', 'description' => 'Beautiful, responsive user interface design'],
                        ['name' => 'MySQL Database', 'icon' => 'fas fa-database', 'description' => 'Relational database management system'],
                        ['name' => 'Bootstrap 5', 'icon' => 'fab fa-bootstrap', 'description' => 'Frontend framework for responsive design'],
                    ];
                @endphp
                
                @foreach($features as $feature)
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3" style="background-color: var(--ocean-noir);">
                                <i class="{{ $feature['icon'] }}"></i>
                            </div>
                            <h5 class="card-title">{{ $feature['name'] }}</h5>
                            <p class="card-text text-muted small">{{ $feature['description'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Website Features -->
        <div class="mb-5">
            <h2 class="text-center mb-4">Website Features</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-berry-wine"><i class="fas fa-user-shield me-2"></i>User & Admin System</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Role-based authentication (User & Admin)</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>User profile management with avatar upload</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Admin dashboard with comprehensive controls</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Secure login/logout system with Laravel Breeze</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Email verification system</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-berry-wine"><i class="fas fa-car me-2"></i>Car Rental System</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Complete Honda car fleet (Brio, Jazz, Civic, HR-V, CR-V)</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Car availability management</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Favorite cars system with heart button</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Rental history tracking</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Car filtering by type</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-berry-wine"><i class="fas fa-qrcode me-2"></i>QRIS Payment System</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Admin can upload QRIS image</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Secure payment processing</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Payment confirmation with proof upload</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Payment success/failure notifications</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Transaction status tracking</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-berry-wine"><i class="fas fa-cog me-2"></i>Admin Management</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>CRUD operations for all data</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>About page content management</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Logo and website branding control</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Transaction and user management</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Dashboard with statistics</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- API Documentation -->
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-indigo-night text-white">
                <h4 class="mb-0"><i class="fas fa-code me-2"></i>API Endpoints Documentation</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Note:</strong> All API endpoints return JSON responses. Protected endpoints require Bearer token authentication.
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Method</th>
                                <th>Endpoint</th>
                                <th>Description</th>
                                <th>Auth Required</th>
                                <th>Role Required</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-success">POST</span></td>
                                <td><code>/api/login</code></td>
                                <td>User authentication (returns token)</td>
                                <td><span class="badge bg-danger">No</span></td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">GET</span></td>
                                <td><code>/api/mobil</code></td>
                                <td>Get all available cars</td>
                                <td><span class="badge bg-danger">No</span></td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success">POST</span></td>
                                <td><code>/api/mobil</code></td>
                                <td>Create new car</td>
                                <td><span class="badge bg-success">Yes</span></td>
                                <td>Admin</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-warning">PUT</span></td>
                                <td><code>/api/mobil/{id}</code></td>
                                <td>Update car data</td>
                                <td><span class="badge bg-success">Yes</span></td>
                                <td>Admin</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">DELETE</span></td>
                                <td><code>/api/mobil/{id}</code></td>
                                <td>Delete car</td>
                                <td><span class="badge bg-success">Yes</span></td>
                                <td>Admin</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">GET</span></td>
                                <td><code>/api/profile</code></td>
                                <td>Get user profile</td>
                                <td><span class="badge bg-success">Yes</span></td>
                                <td>User/Admin</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-warning">PUT</span></td>
                                <td><code>/api/profile</code></td>
                                <td>Update user profile</td>
                                <td><span class="badge bg-success">Yes</span></td>
                                <td>User/Admin</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success">POST</span></td>
                                <td><code>/api/pembayaran</code></td>
                                <td>Create payment transaction</td>
                                <td><span class="badge bg-success">Yes</span></td>
                                <td>User/Admin</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">GET</span></td>
                                <td><code>/api/transaksi</code></td>
                                <td>Get user transactions</td>
                                <td><span class="badge bg-success">Yes</span></td>
                                <td>User/Admin</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">GET</span></td>
                                <td><code>/api/user</code></td>
                                <td>Get authenticated user data</td>
                                <td><span class="badge bg-success">Yes</span></td>
                                <td>User/Admin</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success">POST</span></td>
                                <td><code>/api/logout</code></td>
                                <td>Logout user (revoke token)</td>
                                <td><span class="badge bg-success">Yes</span></td>
                                <td>User/Admin</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="fas fa-key me-2"></i>Authentication Example</h6>
                                <pre class="bg-dark text-light p-3 rounded small"><code>POST /api/login
Content-Type: application/json

{
    "email": "user@gmail.com",
    "password": "user123",
    "device_name": "postman"
}</code></pre>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="fas fa-shield-alt me-2"></i>Protected Request Example</h6>
                                <pre class="bg-dark text-light p-3 rounded small"><code>GET /api/profile
Authorization: Bearer your_token_here
Accept: application/json</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection