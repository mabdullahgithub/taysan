@extends('admin.layout.app')

@section('title', 'View Review')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Review Details</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Reviews</a></li>
                        <li class="breadcrumb-item active">View Review</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Review #{{ $review->id }}</h4>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group">
                                <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-1"></i> Edit Review
                                </a>
                                <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Product Information -->
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Product Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <img src="{{ $review->product->image_url }}" 
                                             alt="{{ $review->product->name }}" 
                                             class="me-3 rounded" 
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                        <div>
                                            <h6 class="fw-bold">{{ $review->product->name }}</h6>
                                            <p class="text-muted mb-1">Product ID: #{{ $review->product->id }}</p>
                                            <p class="text-muted mb-0">Price: ${{ $review->product->price }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review Information -->
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Review Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Rating:</label>
                                        <div class="d-flex align-items-center">
                                            <div class="text-warning me-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="fw-bold">{{ $review->rating }}/5</span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status:</label>
                                        @if($review->is_approved)
                                            <span class="badge bg-success ms-2">Approved</span>
                                        @else
                                            <span class="badge bg-warning ms-2">Pending</span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Submitted:</label>
                                        <span class="ms-2">{{ $review->created_at->format('M d, Y \a\t g:i A') }}</span>
                                        <small class="text-muted">({{ $review->created_at->diffForHumans() }})</small>
                                    </div>

                                    @if($review->order_reference)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Order Reference:</label>
                                            <span class="ms-2 font-monospace">#{{ $review->order_reference }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <!-- Reviewer Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Reviewer Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Name:</label>
                                        <span class="ms-2">{{ $review->name }}</span>
                                        @if($review->is_verified_buyer)
                                            <span class="badge bg-info ms-2">Verified Buyer</span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email:</label>
                                        <span class="ms-2">{{ $review->email }}</span>
                                    </div>

                                    @if($review->location)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Location:</label>
                                            <span class="ms-2">
                                                <i class="fas fa-map-marker-alt me-1"></i>{{ $review->location }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Review Content -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Review Content</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Title:</label>
                                        <p class="mt-2">{{ $review->title }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Comment:</label>
                                        <div class="mt-2 p-3 bg-light rounded">
                                            <p class="mb-0">{{ $review->comment ?: 'No comment provided.' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-center gap-3">
                                @if($review->is_approved)
                                    <form method="POST" action="{{ route('admin.reviews.toggle-approval', $review) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to unapprove this review?')">
                                            <i class="fas fa-pause me-1"></i> Unapprove Review
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.reviews.toggle-approval', $review) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to approve this review?')">
                                            <i class="fas fa-check me-1"></i> Approve Review
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-1"></i> Edit Review
                                </a>

                                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('⚠️ Are you sure you want to delete this review?\n\nThis action cannot be undone!')">
                                        <i class="fas fa-trash me-1"></i> Delete Review
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
