@extends('layouts.app')

@section('title', 'Rental Payment - HoppWheels')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white border-0 text-center py-4">
                    <h2 class="text-indigo-night fw-bold mb-2">Complete Your Rental</h2>
                    <p class="text-muted mb-0">Fill in the details below to book your car</p>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="GET" action="{{ route('payment.form') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Select Car</label>
                                <select name="car_id" class="form-select" required onchange="this.form.submit()">
                                    <option value="">Choose a car...</option>
                                    @foreach($cars as $carOption)
                                        <option value="{{ $carOption->id }}" 
                                                {{ $car && $car->id == $carOption->id ? 'selected' : '' }}
                                                data-price="{{ $carOption->price_per_day }}">
                                            {{ $carOption->name }} - Rp {{ number_format($carOption->price_per_day, 0, ',', '.') }}/day
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control" 
                                       value="{{ old('start_date', $startDate ?? '') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control" 
                                       value="{{ old('end_date', $endDate ?? '') }}" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i>Check
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    @if($car && $startDate && $endDate)
                    <form method="POST" action="{{ route('payment.process') }}" id="paymentForm">
                        @csrf
                        
                        <input type="hidden" name="car_id" value="{{ $car->id }}">
                        <input type="hidden" name="start_date" value="{{ $startDate }}">
                        <input type="hidden" name="end_date" value="{{ $endDate }}">
                        <input type="hidden" name="total_days" id="total_days" value="{{ $days }}">
                        <input type="hidden" name="total_price" id="total_price" value="{{ $totalPrice }}">
                        <input type="hidden" name="payment_method" value="qris">
                        
                        <div class="row">
                            <!-- Car Details -->
                            <div class="col-lg-5 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title text-center mb-4">Car Details</h5>
                                        <div class="text-center mb-4">
                                            <img src="{{ $car->image_url }}" alt="{{ $car->name }}" 
                                                 class="img-fluid rounded" style="max-height: 200px;">
                                        </div>
                                        <h4 class="text-center mb-3">{{ $car->name }}</h4>
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-car text-ocean-noir me-2"></i>
                                                    <small>{{ $car->type }}</small>
                                                </div>
                                            </div>
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
                                        </div>
                                        <p class="card-text text-muted small">{{ $car->description }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment Details -->
                            <div class="col-lg-7">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title text-center mb-4">Rental Summary</h5>
                                        
                                        <!-- Rental Period -->
                                        <div class="mb-4">
                                            <h6><i class="fas fa-calendar-alt me-2 text-primary"></i>Rental Period</h6>
                                            <div class="bg-light p-3 rounded">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Start Date</small>
                                                        <strong>{{ \Carbon\Carbon::parse($startDate)->format('d F Y') }}</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">End Date</small>
                                                        <strong>{{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Price Breakdown -->
                                        <div class="mb-4">
                                            <h6><i class="fas fa-receipt me-2 text-primary"></i>Price Breakdown</h6>
                                            <div class="bg-light p-3 rounded">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Daily Rate</span>
                                                    <span>Rp {{ number_format($car->price_per_day, 0, ',', '.') }}/day</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Rental Duration</span>
                                                    <span>{{ $days }} days</span>
                                                </div>
                                                <hr class="my-2">
                                                <div class="d-flex justify-content-between fw-bold">
                                                    <span>Total Amount</span>
                                                    <span class="text-ocean-noir fs-5">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Payment Method -->
                                        <div class="mb-4">
                                            <h6><i class="fas fa-credit-card me-2 text-primary"></i>Payment Method</h6>
                                            <div class="bg-light p-3 rounded">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method" 
                                                           id="qris" value="qris" checked disabled>
                                                    <label class="form-check-label" for="qris">
                                                        <i class="fas fa-qrcode me-2"></i>QRIS Payment
                                                    </label>
                                                </div>
                                                <small class="text-muted d-block mt-2">
                                                    Pay using QRIS. Scan the QR code after booking.
                                                </small>
                                            </div>
                                        </div>
                                        
                                        <!-- Terms & Conditions -->
                                        <div class="mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input @error('terms') is-invalid @enderror" 
                                                       type="checkbox" name="terms" id="terms" required>
                                                <label class="form-check-label" for="terms">
                                                    I agree to the 
                                                    <a href="#" class="text-decoration-none text-ocean-noir">Terms & Conditions</a>
                                                    and understand that:
                                                </label>
                                                <ul class="small text-muted mt-2 ps-4">
                                                    <li>Payment must be completed within 1 hour of booking</li>
                                                    <li>Cancellations may incur fees</li>
                                                    <li>Security deposit may be required</li>
                                                    <li>Additional charges for late returns</li>
                                                </ul>
                                                @error('terms')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- Submit Button -->
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                                <i class="fas fa-lock me-2"></i>Proceed to Payment
                                            </button>
                                            <p class="text-muted small mt-2">
                                                You will be redirected to QRIS payment page
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
            
            <!-- FAQ Section -->
            @if($car)
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="mb-3"><i class="fas fa-question-circle me-2 text-primary"></i>Frequently Asked Questions</h5>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    How do I pay with QRIS?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    After booking, you will receive a QR code. Scan it using your mobile banking app or e-wallet to complete payment.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    What if I need to cancel?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    You can cancel your booking from your Rental History page. Cancellation fees may apply depending on timing.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Can I extend my rental?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, you can request an extension by contacting our support team at least 24 hours before your rental ends.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .accordion-button:not(.collapsed) {
        background-color: var(--ocean-noir);
        color: white;
    }
    
    .form-check-input:checked {
        background-color: var(--ocean-noir);
        border-color: var(--ocean-noir);
    }
</style>

<script>
    // Calculate days and total price
    function calculateTotal() {
        const startDate = new Date('{{ $startDate }}');
        const endDate = new Date('{{ $endDate }}');
        const pricePerDay = {{ $car->price_per_day ?? 0 }};
        
        if (startDate && endDate && startDate < endDate) {
            const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
            const totalPrice = pricePerDay * days;
            
            document.getElementById('total_days').value = days;
            document.getElementById('total_price').value = totalPrice;
        }
    }
    
    // Initialize calculation
    document.addEventListener('DOMContentLoaded', calculateTotal);
</script>

@php
    // Default values from controller
    $cars = \App\Models\Car::where('available', true)->get();
    $car = isset($_GET['car_id']) ? \App\Models\Car::find($_GET['car_id']) : null;
    $startDate = $_GET['start_date'] ?? '';
    $endDate = $_GET['end_date'] ?? '';
    
    if ($car && $startDate && $endDate) {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        $days = $start->diffInDays($end) + 1;
        $totalPrice = $car->price_per_day * $days;
    }
@endphp
@endsection