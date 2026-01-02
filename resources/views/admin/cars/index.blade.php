@extends('layouts.app')

@section('title', 'Manage Cars - HoppWheels Admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-3 mb-4 border-bottom">
        <h1 class="h2"><i class="fas fa-car me-2"></i>Manage Cars</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Car
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-notification">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.cars.index') }}" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by name..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="Brio" {{ request('type') == 'Brio' ? 'selected' : '' }}>Brio</option>
                        <option value="Jazz" {{ request('type') == 'Jazz' ? 'selected' : '' }}>Jazz</option>
                        <option value="Civic" {{ request('type') == 'Civic' ? 'selected' : '' }}>Civic</option>
                        <option value="HR-V" {{ request('type') == 'HR-V' ? 'selected' : '' }}>HR-V</option>
                        <option value="CR-V" {{ request('type') == 'CR-V' ? 'selected' : '' }}>CR-V</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="available" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" {{ request('available') == '1' ? 'selected' : '' }}>Available</option>
                        <option value="0" {{ request('available') == '0' ? 'selected' : '' }}>Not Available</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cars Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Price/Day</th>
                            <th>Seats</th>
                            <th>Availability</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $car)
                        <tr>
                            <td>{{ $loop->iteration + ($cars->currentPage() - 1) * $cars->perPage() }}</td>
                            <td>
                                <img src="{{ $car->image_url }}" alt="{{ $car->name }}" 
                                     style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                            </td>
                            <td>{{ $car->name }}</td>
                            <td><span class="badge bg-soft-berry">{{ $car->type }}</span></td>
                            <td>Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</td>
                            <td>{{ $car->seats }}</td>
                            <td>
                                @if($car->available)
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-danger">Booked</span>
                                @endif
                            </td>
                            <td>{{ $car->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" 
                                            data-bs-target="#carModal{{ $car->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" 
                                                onclick="return confirm('Are you sure you want to delete this car?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Car Details Modal -->
                                <div class="modal fade" id="carModal{{ $car->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ $car->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <img src="{{ $car->image_url }}" alt="{{ $car->name }}" 
                                                             class="img-fluid rounded mb-3">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <table class="table table-sm">
                                                            <tr>
                                                                <th>Type:</th>
                                                                <td>{{ $car->type }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Price/Day:</th>
                                                                <td>Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Seats:</th>
                                                                <td>{{ $car->seats }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Transmission:</th>
                                                                <td>{{ $car->transmission }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Fuel Type:</th>
                                                                <td>{{ $car->fuel_type }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Availability:</th>
                                                                <td>
                                                                    @if($car->available)
                                                                        <span class="badge bg-success">Available</span>
                                                                    @else
                                                                        <span class="badge bg-danger">Booked</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Created:</th>
                                                                <td>{{ $car->created_at->format('d F Y H:i') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Last Updated:</th>
                                                                <td>{{ $car->updated_at->format('d F Y H:i') }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <h6>Description:</h6>
                                                    <p>{{ $car->description }}</p>
                                                </div>
                                                <div class="mt-3">
                                                    <h6>Rental Stats:</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Total Rentals</small>
                                                            <h5>{{ $car->transactions()->count() }}</h5>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Favorite Count</small>
                                                            <h5>{{ $car->favorites()->count() }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-primary">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($cars->hasPages())
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($cars->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $cars->previousPageUrl() }}" rel="prev">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($cars->getUrlRange(1, $cars->lastPage()) as $page => $url)
                            @if ($page == $cars->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($cars->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $cars->nextPageUrl() }}" rel="next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>
@endsection

@php
    // Default values for cars index
    $cars = \App\Models\Car::query()
        ->when(request('search'), function($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
        ->when(request('type'), function($query, $type) {
            return $query->where('type', $type);
        })
        ->when(request('available') !== null, function($query) {
            return $query->where('available', request('available'));
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();
@endphp