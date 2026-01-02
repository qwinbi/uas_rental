@extends('layouts.app')

@section('title', 'QRIS Management - HoppWheels Admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 mb-4 border-bottom">
        <h1 class="h2"><i class="fas fa-qrcode me-2"></i>QRIS Payment Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.payment.transactions') }}" class="btn btn-outline-primary">
                <i class="fas fa-history me-2"></i>View Transactions
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-notification">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Update QRIS Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.payment.qris.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="bank_name" class="form-label">Bank Name *</label>
                                <input type="text" class="form-control @error('bank_name') is-invalid @enderror" 
                                       id="bank_name" name="bank_name" 
                                       value="{{ old('bank_name', $qris->bank_name ?? '') }}" required>
                                @error('bank_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">e.g., Bank Central Asia, Bank Mandiri, etc.</small>
                            </div>
                            <div class="col-md-6">
                                <label for="account_name" class="form-label">Account Name *</label>
                                <input type="text" class="form-control @error('account_name') is-invalid @enderror" 
                                       id="account_name" name="account_name" 
                                       value="{{ old('account_name', $qris->account_name ?? '') }}" required>
                                @error('account_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Name as it appears in the bank account</small>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="qris_image" class="form-label">QRIS Image</label>
                            <input type="file" class="form-control @error('qris_image') is-invalid @enderror" 
                                   id="qris_image" name="qris_image" accept="image/*">
                            @error('qris_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Upload a clear QRIS image (PNG, JPG, max 2MB). Leave empty to keep current image.</small>
                        </div>
                        
                        @if($qris && $qris->qris_image)
                        <div class="mb-4">
                            <label class="form-label">Current QRIS Image</label>
                            <div class="text-center">
                                <img src="{{ $qris->qris_image_url }}" alt="QRIS" 
                                     class="img-thumbnail" style="max-width: 200px;">
                                <div class="mt-2">
                                    <small class="text-muted">Upload new image to replace this one</small>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                       id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', $qris->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Enable QRIS Payments
                                </label>
                            </div>
                            <small class="text-muted">When disabled, users cannot make QRIS payments</small>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update QRIS
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- QRIS Testing -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-vial me-2"></i>Test QRIS</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Test the QRIS functionality before making it live.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Test Payment Flow</h6>
                                    <ol class="small">
                                        <li>Log in as a regular user</li>
                                        <li>Select a car and proceed to payment</li>
                                        <li>Scan the QRIS with a mobile banking app</li>
                                        <li>Complete payment (use test mode if available)</li>
                                        <li>Upload payment proof</li>
                                        <li>Verify payment confirmation</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Testing Tips</h6>
                                    <ul class="small">
                                        <li>Use test QR code if available from bank</li>
                                        <li>Test with small amounts first</li>
                                        <li>Verify mobile compatibility</li>
                                        <li>Check payment confirmation flow</li>
                                        <li>Test cancellation process</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Preview Section -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">QRIS Preview</h5>
                </div>
                <div class="card-body text-center">
                    @if($qris && $qris->qris_image)
                        <div class="qris-container mb-4">
                            <h6 class="mb-3">{{ $qris->bank_name }}</h6>
                            <p class="text-muted mb-2">Scan to Pay</p>
                            <img src="{{ $qris->qris_image_url }}" alt="QRIS" class="qris-image mb-3">
                            <p class="mb-2"><strong>{{ $qris->account_name }}</strong></p>
                            <div class="alert alert-info small mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                This QRIS will appear on user payment pages
                            </div>
                        </div>
                        
                        <div class="text-start">
                            <h6>QRIS Status:</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Bank:</span>
                                <span class="fw-bold">{{ $qris->bank_name }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Account:</span>
                                <span class="fw-bold">{{ $qris->account_name }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Status:</span>
                                <span class="badge {{ $qris->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $qris->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Last Updated:</span>
                                <span>{{ $qris->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-qrcode fa-4x text-muted mb-3"></i>
                            <p class="text-muted">No QRIS image uploaded yet.</p>
                            <p class="small text-muted">Upload a QRIS image to enable QRIS payments.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- QRIS Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>QRIS Information</h5>
                </div>
                <div class="card-body">
                    <h6>What is QRIS?</h6>
                    <p class="small text-muted">
                        QRIS (Quick Response Code Indonesian Standard) is a standardized QR code payment system in Indonesia.
                    </p>
                    
                    <h6 class="mt-3">Benefits:</h6>
                    <ul class="small text-muted">
                        <li>Secure and fast payments</li>
                        <li>Compatible with most Indonesian banks</li>
                        <li>No transaction fees for customers</li>
                        <li>Easy to use with mobile banking apps</li>
                    </ul>
                    
                    <h6 class="mt-3">Requirements:</h6>
                    <ul class="small text-muted">
                        <li>Business bank account</li>
                        <li>QRIS registration with bank</li>
                        <li>Clear QR code image</li>
                        <li>Proper bank account setup</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Preview QRIS image
    document.getElementById('qris_image').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Update preview if exists
            const preview = document.querySelector('.qris-container img');
            if (preview) {
                preview.src = e.target.result;
            }
        }
        reader.readAsDataURL(e.target.files[0]);
    });
    
    // Toggle active status info
    document.getElementById('is_active').addEventListener('change', function(e) {
        const statusText = document.querySelector('.qris-preview-status');
        if (statusText) {
            if (this.checked) {
                statusText.textContent = 'Active';
                statusText.className = 'badge bg-success';
            } else {
                statusText.textContent = 'Inactive';
                statusText.className = 'badge bg-danger';
            }
        }
    });
</script>
@endsection

@php
    $qris = \App\Models\Qris::first();
@endphp