@extends('layouts.app')

@section('title', 'Logo Management - HoppWheels Admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 mb-4 border-bottom">
        <h1 class="h2"><i class="fas fa-image me-2"></i>Logo & Branding</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-primary">
                <i class="fas fa-eye me-2"></i>View Website
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
            <form method="POST" action="{{ route('admin.logo.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Logo Upload -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-image me-2"></i>Main Logo</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-4">
                                    @if($logo && $logo->logo_path)
                                        <img id="logoPreview" src="{{ $logo->logo_url }}" 
                                             alt="Logo Preview" class="img-fluid" 
                                             style="max-height: 150px;">
                                    @else
                                        <div id="logoPreview" class="bg-light d-flex align-items-center justify-content-center mx-auto"
                                             style="width: 200px; height: 150px;">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Upload Logo</label>
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                           id="logo" name="logo" accept="image/*">
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Recommended: PNG with transparent background, max 2MB</small>
                                </div>
                                <div class="alert alert-info small">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Logo will appear in the navigation bar and footer.
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Favicon Upload -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-favicon me-2"></i>Favicon</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-4">
                                    @if($logo && $logo->favicon_path)
                                        <img id="faviconPreview" src="{{ $logo->favicon_url }}" 
                                             alt="Favicon Preview" class="img-fluid" 
                                             style="max-height: 64px; max-width: 64px;">
                                    @else
                                        <div id="faviconPreview" class="bg-light d-flex align-items-center justify-content-center mx-auto"
                                             style="width: 64px; height: 64px;">
                                            <i class="fas fa-flag fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="favicon" class="form-label">Upload Favicon</label>
                                    <input type="file" class="form-control @error('favicon') is-invalid @enderror" 
                                           id="favicon" name="favicon" accept="image/*,.ico">
                                    @error('favicon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Recommended: ICO or PNG, 32x32 or 64x64 pixels</small>
                                </div>
                                <div class="alert alert-info small">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Favicon appears in browser tabs and bookmarks.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Preview Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-desktop me-2"></i>Website Preview</h5>
                    </div>
                    <div class="card-body">
                        <div class="bg-light p-4 rounded">
                            <!-- Navigation Bar Preview -->
                            <div class="d-flex align-items-center justify-content-between mb-4 p-3 bg-indigo-night rounded">
                                <div class="d-flex align-items-center">
                                    @if($logo && $logo->logo_path)
                                        <img src="{{ $logo->logo_url }}" alt="Logo" height="30" class="me-2">
                                    @else
                                        <div class="bg-white rounded d-flex align-items-center justify-content-center me-2" 
                                             style="width: 30px; height: 30px;">
                                            <span class="fw-bold text-dark">H</span>
                                        </div>
                                    @endif
                                    <span class="text-white fw-bold">HoppWheels</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="text-white me-3">Home</span>
                                    <span class="text-white me-3">Cars</span>
                                    <span class="text-white">About</span>
                                </div>
                            </div>
                            
                            <!-- Browser Tab Preview -->
                            <div class="d-flex align-items-center bg-white border rounded p-2 mb-3">
                                @if($logo && $logo->favicon_path)
                                    <img src="{{ $logo->favicon_url }}" alt="Favicon" width="16" height="16" class="me-2">
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center me-2" 
                                         style="width: 16px; height: 16px;">
                                        <span class="text-white" style="font-size: 8px;">H</span>
                                    </div>
                                @endif
                                <span class="small">HoppWheels - Honda Car Rental</span>
                            </div>
                            
                            <p class="text-muted small mb-0">This preview shows how your logo and favicon will appear on the website.</p>
                        </div>
                    </div>
                </div>
                
                <div class="text-end mt-4">
                    <button type="reset" class="btn btn-secondary me-2">
                        <i class="fas fa-redo me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Guidelines -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Guidelines</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="fas fa-palette me-2 text-primary"></i>Logo Guidelines</h6>
                    <ul class="small">
                        <li>Use high-resolution images for best quality</li>
                        <li>PNG format with transparent background recommended</li>
                        <li>Optimal size: 200-400px width</li>
                        <li>Keep file size under 2MB</li>
                        <li>Logo should be clearly visible on dark backgrounds</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6><i class="fas fa-crop me-2 text-primary"></i>Favicon Guidelines</h6>
                    <ul class="small">
                        <li>Square images work best (1:1 ratio)</li>
                        <li>Optimal sizes: 32x32 or 64x64 pixels</li>
                        <li>Simple designs are more recognizable</li>
                        <li>Can use .ico or .png format</li>
                        <li>Test visibility at small sizes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Preview logo
    document.getElementById('logo').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('logoPreview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.id = 'logoPreview';
                img.src = e.target.result;
                img.className = 'img-fluid';
                img.style = 'max-height: 150px;';
                preview.parentNode.replaceChild(img, preview);
            }
        }
        reader.readAsDataURL(e.target.files[0]);
    });
    
    // Preview favicon
    document.getElementById('favicon').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('faviconPreview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.id = 'faviconPreview';
                img.src = e.target.result;
                img.className = 'img-fluid';
                img.style = 'max-height: 64px; max-width: 64px;';
                preview.parentNode.replaceChild(img, preview);
            }
        }
        reader.readAsDataURL(e.target.files[0]);
    });
</script>
@endsection

@php
    $logo = \App\Models\Logo::first();
@endphp