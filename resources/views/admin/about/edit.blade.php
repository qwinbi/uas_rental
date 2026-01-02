@extends('layouts.app')

@section('title', 'Edit About Page - HoppWheels Admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 mb-4 border-bottom">
        <h1 class="h2"><i class="fas fa-info-circle me-2"></i>About Page Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('about') }}" target="_blank" class="btn btn-outline-primary">
                <i class="fas fa-eye me-2"></i>View Page
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
            <form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Profile Picture -->
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    @if($about && $about->avatar)
                                        <img id="avatarPreview" src="{{ $about->avatar_url }}" 
                                             alt="Profile" class="img-fluid rounded-circle" 
                                             style="width: 200px; height: 200px; object-fit: cover;">
                                    @else
                                        <div id="avatarPreview" class="rounded-circle bg-soft-berry text-white d-flex align-items-center justify-content-center mx-auto"
                                             style="width: 200px; height: 200px;">
                                            <i class="fas fa-user fa-4x"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Profile Picture</label>
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" 
                                           id="avatar" name="avatar" accept="image/*">
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Square image, max 2MB</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Personal Information -->
                    <div class="col-md-8">
                        <h5 class="mb-4 text-primary"><i class="fas fa-user-graduate me-2"></i>Personal Information</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $about->name ?? '') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nim" class="form-label">NIM *</label>
                                <input type="text" class="form-control @error('nim') is-invalid @enderror" 
                                       id="nim" name="nim" value="{{ old('nim', $about->nim ?? '') }}" required>
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="class" class="form-label">Class *</label>
                                <input type="text" class="form-control @error('class') is-invalid @enderror" 
                                       id="class" name="class" value="{{ old('class', $about->class ?? '') }}" required>
                                @error('class')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="major" class="form-label">Major *</label>
                                <input type="text" class="form-control @error('major') is-invalid @enderror" 
                                       id="major" name="major" value="{{ old('major', $about->major ?? '') }}" required>
                                @error('major')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Project Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description', $about->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Describe the project, its purpose, and features</small>
                        </div>
                    </div>
                </div>
                
                <!-- Features Section -->
                <div class="mt-4">
                    <h5 class="mb-4 text-primary"><i class="fas fa-cogs me-2"></i>Technologies & Features</h5>
                    
                    <div class="mb-3">
                        <label for="features" class="form-label">Features Used (comma separated)</label>
                        <textarea class="form-control @error('features') is-invalid @enderror" 
                                  id="features" name="features" rows="3">{{ old('features', $about->features ?? '') }}</textarea>
                        @error('features')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            Enter features separated by commas. Example: Laravel 10, Blade Template, QRIS Payment, etc.
                        </small>
                    </div>
                    
                    <!-- Preview of Features -->
                    @if($about && $about->features)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Features Preview</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($about->features_array as $feature)
                                <div class="col-md-3 mb-2">
                                    <span class="badge bg-primary">{{ trim($feature) }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Preview Section -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Page Preview</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if($about && $about->avatar)
                        <img src="{{ $about->avatar_url }}" 
                             alt="Profile Preview" class="img-fluid rounded-circle mb-3"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3"
                             style="width: 150px; height: 150px;">
                            <i class="fas fa-user fa-3x text-muted"></i>
                        </div>
                    @endif
                    <h5>{{ $about->name ?? 'Your Name' }}</h5>
                    <p class="text-muted mb-0">Developer</p>
                </div>
                <div class="col-md-8">
                    <table class="table table-sm">
                        <tr>
                            <th width="30%">NIM:</th>
                            <td>{{ $about->nim ?? '241011701321' }}</td>
                        </tr>
                        <tr>
                            <th>Class:</th>
                            <td>{{ $about->class ?? '03SIFP014' }}</td>
                        </tr>
                        <tr>
                            <th>Major:</th>
                            <td>{{ $about->major ?? 'Sistem Informasi' }}</td>
                        </tr>
                    </table>
                    <div class="mt-3">
                        <h6>Project Description:</h6>
                        <p class="text-muted">{{ Str::limit($about->description ?? 'Project description will appear here.', 200) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('about') }}" target="_blank" class="btn btn-outline-primary">
                    <i class="fas fa-external-link-alt me-2"></i>View Full About Page
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
                img.className = 'img-fluid rounded-circle';
                img.style = 'width: 200px; height: 200px; object-fit: cover;';
                preview.parentNode.replaceChild(img, preview);
            }
        }
        reader.readAsDataURL(e.target.files[0]);
    });
    
    // Features counter
    document.getElementById('features').addEventListener('input', function(e) {
        const features = this.value.split(',').filter(f => f.trim() !== '');
        const counter = document.getElementById('featuresCounter') || (() => {
            const counter = document.createElement('small');
            counter.id = 'featuresCounter';
            counter.className = 'text-muted d-block mt-1';
            this.parentNode.appendChild(counter);
            return counter;
        })();
        
        counter.textContent = `${features.length} feature(s) entered`;
    });
</script>
@endsection

@php
    $about = \App\Models\About::first();
@endphp