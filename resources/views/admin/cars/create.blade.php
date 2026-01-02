@extends('layouts.app')

@section('title', 'Add New Car - HoppWheels Admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 mb-4 border-bottom">
        <h1 class="h2"><i class="fas fa-car me-2"></i>Add New Car</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Cars
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-notification">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.cars.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Car Image -->
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <img id="carImagePreview" src="{{ asset('images/default-car.jpg') }}" 
                                         alt="Car Preview" class="img-fluid rounded" 
                                         style="max-height: 200px; width: 100%; object-fit: cover;">
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Car Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Recommended: 800x600px, max 2MB</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Fields -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Car Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Car Type *</label>
                                <select class="form-select @error('type') is-invalid @enderror" 
                                        id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="Brio" {{ old('type') == 'Brio' ? 'selected' : '' }}>Brio</option>
                                    <option value="Jazz" {{ old('type') == 'Jazz' ? 'selected' : '' }}>Jazz</option>
                                    <option value="Civic" {{ old('type') == 'Civic' ? 'selected' : '' }}>Civic</option>
                                    <option value="HR-V" {{ old('type') == 'HR-V' ? 'selected' : '' }}>HR-V</option>
                                    <option value="CR-V" {{ old('type') == 'CR-V' ? 'selected' : '' }}>CR-V</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price_per_day" class="form-label">Price per Day (Rp) *</label>
                                <input type="number" class="form-control @error('price_per_day') is-invalid @enderror" 
                                       id="price_per_day" name="price_per_day" value="{{ old('price_per_day') }}" 
                                       min="0" step="1000" required>
                                @error('price_per_day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="seats" class="form-label">Number of Seats *</label>
                                <input type="number" class="form-control @error('seats') is-invalid @enderror" 
                                       id="seats" name="seats" value="{{ old('seats', 5) }}" 
                                       min="1" max="10" required>
                                @error('seats')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="transmission" class="form-label">Transmission *</label>
                                <select class="form-select @error('transmission') is-invalid @enderror" 
                                        id="transmission" name="transmission" required>
                                    <option value="">Select Transmission</option>
                                    <option value="Automatic" {{ old('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                    <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="CVT" {{ old('transmission') == 'CVT' ? 'selected' : '' }}>CVT</option>
                                </select>
                                @error('transmission')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="fuel_type" class="form-label">Fuel Type *</label>
                                <select class="form-select @error('fuel_type') is-invalid @enderror" 
                                        id="fuel_type" name="fuel_type" required>
                                    <option value="">Select Fuel Type</option>
                                    <option value="Petrol" {{ old('fuel_type') == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                                    <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="Hybrid" {{ old('fuel_type') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    <option value="Electric" {{ old('fuel_type') == 'Electric' ? 'selected' : '' }}>Electric</option>
                                </select>
                                @error('fuel_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                       id="available" name="available" value="1" 
                                       {{ old('available', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="available">
                                    Car is available for rental
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-end mt-4">
                    <button type="reset" class="btn btn-secondary me-2">
                        <i class="fas fa-redo me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Car
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Help Information -->
    <div class="card mt-4">
        <div class="card-body">
            <h5><i class="fas fa-info-circle me-2 text-primary"></i>Information</h5>
            <ul class="mb-0">
                <li>Car name should be descriptive (e.g., "Honda Brio RS 2023")</li>
                <li>Price per day should be in Indonesian Rupiah (Rp)</li>
                <li>Description should include key features and specifications</li>
                <li>Make sure the car image is clear and professional</li>
                <li>If car is not available, it won't appear in public listings</li>
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Preview car image
    document.getElementById('image').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('carImagePreview').src = e.target.result;
        }
        reader.readAsDataURL(e.target.files[0]);
    });
    
    // Format price input
    document.getElementById('price_per_day').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
@endsection