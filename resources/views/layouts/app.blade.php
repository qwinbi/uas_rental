<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @php
        $logo = \App\Models\Logo::first();
        $favicon = $logo->favicon_url ?? asset('images/favicon.png');
        $pageTitle = isset($title) ? $title . ' | HoppWheels' : 'HoppWheels - Honda Car Rental';
    @endphp
    
    <title>{{ $pageTitle }}</title>
    <link rel="icon" href="{{ $favicon }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --indigo-night: #16202b;
            --ocean-noir: #114665;
            --berry-wine: #720f32;
            --soft-berry: #7b445a;
            --pale-ash: #d1d1d6;
        }
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .bg-indigo-night {
            background-color: var(--indigo-night) !important;
        }
        
        .bg-ocean-noir {
            background-color: var(--ocean-noir) !important;
        }
        
        .bg-berry-wine {
            background-color: var(--berry-wine) !important;
        }
        
        .bg-soft-berry {
            background-color: var(--soft-berry) !important;
        }
        
        .bg-pale-ash {
            background-color: var(--pale-ash) !important;
        }
        
        .text-indigo-night {
            color: var(--indigo-night) !important;
        }
        
        .text-ocean-noir {
            color: var(--ocean-noir) !important;
        }
        
        .text-berry-wine {
            color: var(--berry-wine) !important;
        }
        
        .text-soft-berry {
            color: var(--soft-berry) !important;
        }
        
        .text-pale-ash {
            color: var(--pale-ash) !important;
        }
        
        .btn-primary {
            background-color: var(--ocean-noir) !important;
            border-color: var(--ocean-noir) !important;
            color: white !important;
        }
        
        .btn-primary:hover {
            background-color: var(--indigo-night) !important;
            border-color: var(--indigo-night) !important;
        }
        
        .btn-secondary {
            background-color: var(--soft-berry) !important;
            border-color: var(--soft-berry) !important;
            color: white !important;
        }
        
        .btn-secondary:hover {
            background-color: var(--berry-wine) !important;
            border-color: var(--berry-wine) !important;
        }
        
        .btn-outline-primary {
            color: var(--ocean-noir) !important;
            border-color: var(--ocean-noir) !important;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--ocean-noir) !important;
            color: white !important;
        }
        
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }
        
        .card {
            border-radius: 16px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }
        
        .car-card {
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }
        
        .car-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        
        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-paid {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .badge-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .badge-failed {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .alert-notification {
            border-radius: 12px !important;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 1050;
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .avatar-lg {
            width: 100px;
            height: 100px;
        }
        
        .navbar-brand img {
            height: 40px;
        }
        
        .sidebar {
            min-height: calc(100vh - 73px);
            background-color: var(--indigo-night);
            color: white;
            position: fixed;
            width: 250px;
            z-index: 100;
        }
        
        .sidebar .nav-link {
            color: var(--pale-ash);
            padding: 12px 20px;
            margin: 4px 0;
            border-radius: 8px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar .nav-link.active {
            background-color: var(--ocean-noir);
            color: white;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        
        .main-content {
            margin-left: 250px;
            flex: 1;
        }
        
        @media (max-width: 991.98px) {
            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }
            .main-content {
                margin-left: 0;
            }
        }
        
        .footer {
            background-color: var(--indigo-night);
            color: white;
            padding: 40px 0 20px;
            margin-top: auto;
        }
        
        .footer a {
            color: var(--pale-ash);
            text-decoration: none;
        }
        
        .footer a:hover {
            color: white;
        }
        
        .qris-container {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            margin: 0 auto;
        }
        
        .qris-image {
            width: 250px;
            height: 250px;
            object-fit: contain;
            border: 2px dashed #ddd;
            padding: 15px;
            border-radius: 12px;
            margin: 20px 0;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--indigo-night) 0%, var(--ocean-noir) 100%);
            color: white;
            padding: 80px 0;
            border-radius: 0 0 40px 40px;
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background-color: var(--ocean-noir);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 24px;
        }
        
        .heart-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s;
            border: none;
        }
        
        .heart-btn:hover {
            transform: scale(1.1);
        }
        
        .heart-btn.active {
            background-color: var(--berry-wine);
            color: white;
        }
        
        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--berry-wine);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 6px 20px rgba(114, 15, 50, 0.4);
            z-index: 1000;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .floating-btn:hover {
            transform: scale(1.1);
            color: white;
        }
        
        .page-title {
            color: var(--indigo-night);
            font-weight: 700;
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background-color: var(--berry-wine);
            border-radius: 2px;
        }
        
        .stat-card {
            border-radius: 16px;
            padding: 25px;
            color: white;
            transition: all 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card i {
            font-size: 40px;
            margin-bottom: 15px;
            opacity: 0.9;
        }
        
        .stat-card h3 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-card p {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }
        
        .main {
            flex: 1;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    @if(!request()->is('admin/*') || !auth()->check())
    <nav class="navbar navbar-expand-lg navbar-dark bg-indigo-night shadow-sm">
        <div class="container">
            @php
                $logo = \App\Models\Logo::first();
                $logoUrl = $logo->logo_url ?? asset('images/logo.png');
            @endphp
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ $logoUrl }}" alt="HoppWheels Logo" class="me-2">
                <span class="fw-bold">HoppWheels</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cars') ? 'active' : '' }}" href="{{ route('cars') }}">
                            <i class="fas fa-car me-1"></i> Cars
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                            <i class="fas fa-info-circle me-1"></i> About
                        </a>
                    </li>
                    
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link btn btn-sm btn-primary text-white ms-2" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-cog me-1"></i> Admin Panel
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="avatar me-2">
                                    @else
                                        <div class="avatar bg-soft-berry text-white d-flex align-items-center justify-content-center me-2">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                    {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile.history') }}"><i class="fas fa-history me-2"></i>History</a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile.favorites') }}"><i class="fas fa-heart me-2"></i>Favorites</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-sm btn-outline-light ms-2" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    @endif
    
    <!-- Main Content -->
    <main class="main">
        @if(request()->is('admin/*') && auth()->check() && auth()->user()->isAdmin())
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-md-3 col-lg-2 px-0 sidebar d-none d-md-block">
                        <div class="p-4">
                            <h5 class="text-center mb-4">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="avatar mb-2">
                                @endif
                                <div>{{ auth()->user()->name }}</div>
                                <small class="text-pale-ash">Administrator</small>
                            </h5>
                            
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}" href="{{ route('admin.cars.index') }}">
                                        <i class="fas fa-car me-2"></i> Cars
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                        <i class="fas fa-users me-2"></i> Users
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.payment.*') ? 'active' : '' }}" href="{{ route('admin.payment.transactions') }}">
                                        <i class="fas fa-credit-card me-2"></i> Payments
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}" href="{{ route('admin.about.edit') }}">
                                        <i class="fas fa-info-circle me-2"></i> About Page
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.logo.*') ? 'active' : '' }}" href="{{ route('admin.logo.edit') }}">
                                        <i class="fas fa-image me-2"></i> Logo
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('home') }}" target="_blank">
                                        <i class="fas fa-external-link-alt me-2"></i> View Site
                                    </a>
                                </li>
                                <li class="nav-item mt-4">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="nav-link text-start w-100 border-0 bg-transparent text-pale-ash">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Main Content Area -->
                    <div class="col-md-9 col-lg-10 ms-sm-auto px-4 py-4 main-content">
                        @yield('content')
                    </div>
                </div>
            </div>
        @else
            <div class="container-fluid px-0">
                @yield('content')
            </div>
        @endif
    </main>
    
    <!-- Footer -->
    @if(!request()->is('admin/*'))
        @php
            $footer = \App\Models\Footer::first();
        @endphp
        
        @if($footer)
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <h5 class="mb-3">{{ $footer->company_name }}</h5>
                        <p class="text-pale-ash">{{ $footer->address }}</p>
                        <p class="text-pale-ash mb-1"><i class="fas fa-phone me-2"></i> {{ $footer->phone }}</p>
                        <p class="text-pale-ash"><i class="fas fa-envelope me-2"></i> {{ $footer->email }}</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h5 class="mb-3">Quick Links</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="{{ route('home') }}"><i class="fas fa-chevron-right me-2"></i>Home</a></li>
                            <li class="mb-2"><a href="{{ route('cars') }}"><i class="fas fa-chevron-right me-2"></i>Cars</a></li>
                            <li class="mb-2"><a href="{{ route('about') }}"><i class="fas fa-chevron-right me-2"></i>About</a></li>
                            @auth
                                <li class="mb-2"><a href="{{ route('profile.edit') }}"><i class="fas fa-chevron-right me-2"></i>Profile</a></li>
                            @endauth
                        </ul>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h5 class="mb-3">Connect With Us</h5>
                        <div class="d-flex">
                            @php
                                $socialLinks = $footer->social_links_array;
                            @endphp
                            @if(!empty($socialLinks['facebook']))
                                <a href="{{ $socialLinks['facebook'] }}" class="text-pale-ash me-3" target="_blank"><i class="fab fa-facebook fa-2x"></i></a>
                            @endif
                            @if(!empty($socialLinks['instagram']))
                                <a href="{{ $socialLinks['instagram'] }}" class="text-pale-ash me-3" target="_blank"><i class="fab fa-instagram fa-2x"></i></a>
                            @endif
                            @if(!empty($socialLinks['twitter']))
                                <a href="{{ $socialLinks['twitter'] }}" class="text-pale-ash me-3" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>
                            @endif
                            @if(!empty($socialLinks['whatsapp']))
                                <a href="{{ $socialLinks['whatsapp'] }}" class="text-pale-ash" target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>
                            @endif
                        </div>
                        <p class="text-pale-ash mt-4">{{ $footer->copyright }}</p>
                    </div>
                </div>
                <hr class="border-secondary mt-0">
                <div class="text-center text-pale-ash">
                    <p class="mb-0">© {{ date('Y') }} HoppWheels. All rights reserved.</p>
                </div>
            </div>
        </footer>
        @endif
    @endif
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-dismiss alerts after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
            
            // Close alert on button click
            $('.alert .btn-close').click(function() {
                $(this).closest('.alert').alert('close');
            });
        });
        
        // Toggle favorite
        $(document).on('click', '.heart-btn', function(e) {
            e.preventDefault();
            const $btn = $(this);
            const carId = $btn.data('car-id');
            const isFavorite = $btn.hasClass('active');
            
            $.ajax({
                url: '{{ route("favorite.toggle") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    car_id: carId
                },
                success: function(response) {
                    if (response.success) {
                        if (response.is_favorite) {
                            $btn.addClass('active');
                            $btn.html('<i class="fas fa-heart"></i>');
                        } else {
                            $btn.removeClass('active');
                            $btn.html('<i class="far fa-heart"></i>');
                        }
                        
                        // Show notification
                        showNotification(response.message, 'success');
                    }
                },
                error: function() {
                    showNotification('An error occurred. Please try again.', 'danger');
                }
            });
        });
        
        // Show notification
        function showNotification(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            
            const $alert = $(`
                <div class="alert ${alertClass} alert-notification alert-dismissible fade show position-fixed" 
                     style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
            
            $('body').append($alert);
            
            setTimeout(function() {
                $alert.alert('close');
            }, 3000);
        }
        
        // Handle payment confirmation
        function confirmPayment(transactionId) {
            if (confirm('Have you completed the QRIS payment?')) {
                window.location.href = `/payment/${transactionId}/confirm`;
            }
        }
        
        // Calculate total price
        function calculateTotalPrice() {
            const pricePerDay = parseFloat($('#price_per_day').val()) || 0;
            const startDate = new Date($('#start_date').val());
            const endDate = new Date($('#end_date').val());
            
            if (startDate && endDate && startDate < endDate) {
                const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
                const totalPrice = pricePerDay * days;
                
                $('#total_days').val(days);
                $('#total_price').val(totalPrice.toFixed(2));
                $('#total_display').text(days + ' days');
                $('#price_display').text('Rp ' + totalPrice.toLocaleString('id-ID'));
            }
        }
        
        // Initialize date pickers
        $(document).ready(function() {
            const today = new Date().toISOString().split('T')[0];
            $('input[type="date"]').attr('min', today);
            
            // Trigger calculation when dates change
            $('#start_date, #end_date').on('change', calculateTotalPrice);
        });
        
        // Preview image before upload
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $(`#${previewId}`).attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Handle image previews
        $(document).ready(function() {
            $('#avatar').change(function() {
                previewImage(this, 'avatarPreview');
            });
            
            $('#car_image').change(function() {
                previewImage(this, 'carImagePreview');
            });
            
            $('#qris_image').change(function() {
                previewImage(this, 'qrisPreview');
            });
            
            $('#logo').change(function() {
                previewImage(this, 'logoPreview');
            });
            
            $('#favicon').change(function() {
                previewImage(this, 'faviconPreview');
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>