@extends('layouts.app')

@section('title', 'Payment Status - HoppWheels')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Payment Status Card -->
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white border-0 text-center py-4">
                    <h2 class="text-indigo-night fw-bold mb-2">Payment Status</h2>
                    <p class="text-muted mb-0">Transaction Code: <code>{{ $transaction->transaction_code }}</code></p>
                </div>
                
                <div class="card-body p-4 p-md-5">
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
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-notification">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif
                    
                    <!-- Status Indicator -->
                    <div class="text-center mb-5">
                        @if($transaction->status == 'paid')
                            <div class="status-icon bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-check fa-3x text-white"></i>
                            </div>
                            <h3 class="text-success">Payment Successful! 🎉</h3>
                            <p class="text-muted">Your car rental has been confirmed and is now active.</p>
                        @elseif($transaction->status == 'pending')
                            <div class="status-icon bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-clock fa-3x text-white"></i>
                            </div>
                            <h3 class="text-warning">Payment Pending</h3>
                            <p class="text-muted">Please complete your QRIS payment to confirm the booking.</p>
                        @elseif($transaction->status == 'cancelled')
                            <div class="status-icon bg-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-times fa-3x text-white"></i>
                            </div>
                            <h3 class="text-danger">Payment Cancelled</h3>
                            <p class="text-muted">This booking has been cancelled.</p>
                        @elseif($transaction->status == 'failed')
                            <div class="status-icon bg-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-exclamation-triangle fa-3x text-white"></i>
                            </div>
                            <h3 class="text-danger">Payment Failed</h3>
                            <p class="text-muted">There was an issue with your payment. Please try again.</p>
                        @endif
                    </div>
                    
                    <!-- Transaction Details -->
                    <div class="row mb-5">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title mb-4"><i class="fas fa-car me-2 text-primary"></i>Car Details</h5>
                                    <div class="text-center mb-3">
                                        <img src="{{ $transaction->car->image_url }}" 
                                             alt="{{ $transaction->car->name }}" 
                                             class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                    <h6 class="mb-2">{{ $transaction->car->name }}</h6>
                                    <p class="text-muted small mb-0">{{ $transaction->car->description }}</p>
                                    <div class="mt-3">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <small class="text-muted d-block">Type</small>
                                                <strong>{{ $transaction->car->type }}</strong>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block">Transmission</small>
                                                <strong>{{ $transaction->car->transmission }}</strong>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block">Seats</small>
                                                <strong>{{ $transaction->car->seats }}</strong>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block">Fuel Type</small>
                                                <strong>{{ $transaction->car->fuel_type }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title mb-4"><i class="fas fa-receipt me-2 text-primary"></i>Booking Details</h5>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Transaction Code</small>
                                        <code class="fs-5">{{ $transaction->transaction_code }}</code>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Rental Period</small>
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $transaction->start_date->format('d M Y') }}</strong>
                                            <i class="fas fa-arrow-right mx-2 text-muted"></i>
                                            <strong>{{ $transaction->end_date->format('d M Y') }}</strong>
                                        </div>
                                        <div class="text-center mt-1">
                                            <span class="badge bg-primary">{{ $transaction->total_days }} days</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Amount</small>
                                        <h4 class="text-ocean-noir">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</h4>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Status</small>
                                        @php
                                            $statusClass = [
                                                'pending' => 'badge-pending',
                                                'paid' => 'badge-paid',
                                                'cancelled' => 'badge-cancelled',
                                                'failed' => 'badge-failed'
                                            ][$transaction->status];
                                        @endphp
                                        <span class="badge-status {{ $statusClass }} fs-6">{{ ucfirst($transaction->status) }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Booking Date</small>
                                        <strong>{{ $transaction->created_at->format('d M Y H:i') }}</strong>
                                    </div>
                                    @if($transaction->payment_date)
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Payment Date</small>
                                        <strong>{{ $transaction->payment_date->format('d M Y H:i') }}</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- QRIS Payment Section (Only for pending payments) -->
                    @if($transaction->status == 'pending')
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4"><i class="fas fa-qrcode me-2 text-primary"></i>Complete Payment via QRIS</h5>
                            
                            <div class="row align-items-center">
                                <div class="col-lg-6 text-center mb-4 mb-lg-0">
                                    @if($qris && $qris->qris_image)
                                        <div class="qris-container">
                                            <h6 class="mb-3">{{ $qris->bank_name }}</h6>
                                            <p class="text-muted mb-2">Scan to Pay</p>
                                            <img src="{{ $qris->qris_image_url }}" alt="QRIS" class="qris-image mb-3">
                                            <p class="mb-2"><strong>{{ $qris->account_name }}</strong></p>
                                            <p class="text-muted small mb-0">Amount: Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-qrcode fa-4x text-muted mb-3"></i>
                                            <p class="text-muted">QRIS not available</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="col-lg-6">
                                    <h6>Payment Instructions:</h6>
                                    <ol class="text-muted">
                                        <li>Open your mobile banking or e-wallet app</li>
                                        <li>Tap on "Scan QR Code" or "QRIS"</li>
                                        <li>Scan the QR code displayed on the left</li>
                                        <li>Verify the amount and complete payment</li>
                                        <li>Upload payment proof below to confirm</li>
                                    </ol>
                                    
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Payment must be completed within <strong>1 hour</strong> to avoid automatic cancellation.
                                    </div>
                                    
                                    <!-- Payment Proof Upload -->
                                    <form method="POST" action="{{ route('payment.confirm', $transaction) }}" enctype="multipart/form-data" class="mt-4">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="payment_proof" class="form-label">Upload Payment Proof</label>
                                            <input type="file" class="form-control" id="payment_proof" name="payment_proof" accept="image/*" required>
                                            <small class="text-muted">Upload screenshot of successful payment (max 2MB)</small>
                                        </div>
                                        <button type="submit" class="btn btn-success w-100 py-3">
                                            <i class="fas fa-check-circle me-2"></i>Confirm Payment
                                        </button>
                                    </form>
                                    
                                    <!-- Cancel Button -->
                                    <form method="POST" action="{{ route('payment.cancel', $transaction) }}" class="mt-3">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger w-100" 
                                                onclick="return confirm('Are you sure you want to cancel this booking?')">
                                            <i class="fas fa-times me-2"></i>Cancel Booking
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Action Buttons -->
                    <div class="text-center mt-5">
                        @if($transaction->status == 'paid')
                            <a href="{{ route('profile.history') }}" class="btn btn-primary btn-lg px-5 me-3">
                                <i class="fas fa-history me-2"></i>View All Bookings
                            </a>
                            <a href="{{ route('cars') }}" class="btn btn-outline-primary btn-lg px-5">
                                <i class="fas fa-car me-2"></i>Rent Another Car
                            </a>
                        @elseif($transaction->status == 'pending')
                            <a href="{{ route('profile.history') }}" class="btn btn-outline-primary btn-lg px-5">
                                <i class="fas fa-history me-2"></i>View Booking History
                            </a>
                        @else
                            <a href="{{ route('cars') }}" class="btn btn-primary btn-lg px-5 me-3">
                                <i class="fas fa-redo me-2"></i>Try Again
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg px-5">
                                <i class="fas fa-home me-2"></i>Back to Home
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Support Information -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body text-center">
                    <h5 class="mb-3"><i class="fas fa-headset me-2 text-primary"></i>Need Help?</h5>
                    <p class="text-muted mb-3">Our support team is available 24/7 to assist you with any issues.</p>
                    <div class="row justify-content-center">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-phone text-primary me-3 fa-2x"></i>
                                <div>
                                    <small class="text-muted d-block">Call Us</small>
                                    <strong>+62 21 1234 5678</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-envelope text-primary me-3 fa-2x"></i>
                                <div>
                                    <small class="text-muted d-block">Email Us</small>
                                    <strong>support@hoppwheels.com</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-comments text-primary me-3 fa-2x"></i>
                                <div>
                                    <small class="text-muted d-block">Live Chat</small>
                                    <strong>Available 24/7</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .status-icon {
        transition: transform 0.3s;
    }
    
    .status-icon:hover {
        transform: scale(1.1);
    }
    
    .qris-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
</style>

@php
    // Default values from controller
    $qris = \App\Models\Qris::where('is_active', true)->first();
@endphp
@endsection