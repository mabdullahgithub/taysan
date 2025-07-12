@extends('admin.layout.app')

@section('title', 'Edit Review')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Edit Review</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Reviews</a></li>
                        <li class="breadcrumb-item active">Edit Review</li>
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
                            <h4 class="card-title mb-0">Edit Review #{{ $review->id }}</h4>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye me-1"></i> View Review
                            </a>
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.reviews.update', $review) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Product Information (Read-only) -->
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

                            <!-- Basic Review Info (Read-only) -->
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Review Info</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Created:</label>
                                            <span class="ms-2">{{ $review->created_at->format('M d, Y \a\t g:i A') }}</span>
                                        </div>

                                        @if($review->order_reference)
                                            <div class="mb-3">
                                                <label class="form-label">Order Reference:</label>
                                                <span class="ms-2 font-monospace">#{{ $review->order_reference }}</span>
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <label class="form-label">Verified Buyer:</label>
                                            @if($review->is_verified_buyer)
                                                <span class="badge bg-info ms-2">Yes</span>
                                            @else
                                                <span class="badge bg-secondary ms-2">No</span>
                                            @endif
                                        </div>
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
                                            <label for="name" class="form-label">Name *</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $review->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email', $review->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="location" class="form-label">Location</label>
                                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                                   id="location" name="location" value="{{ old('location', $review->location) }}">
                                            @error('location')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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
                                            <label for="rating" class="form-label">Rating *</label>
                                            <select class="form-select @error('rating') is-invalid @enderror" 
                                                    id="rating" name="rating" required>
                                                <option value="">Select Rating</option>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>
                                                        {{ str_repeat('⭐', $i) }} ({{ $i }}/5)
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('rating')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="title" class="form-label">Review Title *</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                                   id="title" name="title" value="{{ old('title', $review->title) }}" 
                                                   maxlength="255" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="comment" class="form-label">Review Comment</label>
                                            <textarea class="form-control @error('comment') is-invalid @enderror" 
                                                      id="comment" name="comment" rows="5" maxlength="1000">{{ old('comment', $review->comment) }}</textarea>
                                            <div class="form-text">Maximum 1000 characters</div>
                                            @error('comment')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_approved" name="is_approved" 
                                                       value="1" {{ old('is_approved', $review->is_approved) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_approved">
                                                    Approved
                                                </label>
                                            </div>
                                            <div class="form-text">Check to approve this review for public display</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-center gap-3">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-1"></i> Update Review
                                    </button>
                                    
                                    <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-outline-info btn-lg">
                                        <i class="fas fa-eye me-1"></i> View Review
                                    </a>
                                    
                                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
