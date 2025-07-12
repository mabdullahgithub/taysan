@extends('admin.layout.app')

@section('title', 'Create Review')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Create New Review</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Reviews</a></li>
                        <li class="breadcrumb-item active">Create Review</li>
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
                            <h4 class="card-title mb-0">Create New Review</h4>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.reviews.store') }}">
                        @csrf

                        <div class="row">
                            <!-- Product Selection -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Product Selection</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="product_id" class="form-label">Product *</label>
                                            <select class="form-select @error('product_id') is-invalid @enderror" 
                                                    id="product_id" name="product_id" required>
                                                <option value="">Select a Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                        {{ $product->name }} - ${{ $product->price }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('product_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="order_reference" class="form-label">Order Reference</label>
                                            <input type="text" class="form-control @error('order_reference') is-invalid @enderror" 
                                                   id="order_reference" name="order_reference" value="{{ old('order_reference') }}" 
                                                   placeholder="8-digit order number" maxlength="8">
                                            <div class="form-text">Leave empty if not from a verified purchase</div>
                                            @error('order_reference')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_verified_buyer" 
                                                       name="is_verified_buyer" value="1" {{ old('is_verified_buyer') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_verified_buyer">
                                                    Verified Buyer
                                                </label>
                                            </div>
                                            <div class="form-text">Check if this review is from a verified purchase</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                                   id="name" name="name" value="{{ old('name') }}" required maxlength="255">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email') }}" required maxlength="255">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="location" class="form-label">Location</label>
                                            <select class="form-select @error('location') is-invalid @enderror" 
                                                    id="location" name="location">
                                                <option value="">Select Location</option>
                                                <option value="Pakistan" {{ old('location') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                                <option value="India" {{ old('location') == 'India' ? 'selected' : '' }}>India</option>
                                                <option value="Bangladesh" {{ old('location') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                                <option value="United States" {{ old('location') == 'United States' ? 'selected' : '' }}>United States</option>
                                                <option value="United Kingdom" {{ old('location') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                                <option value="Canada" {{ old('location') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                                <option value="Australia" {{ old('location') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                                <option value="Germany" {{ old('location') == 'Germany' ? 'selected' : '' }}>Germany</option>
                                                <option value="France" {{ old('location') == 'France' ? 'selected' : '' }}>France</option>
                                                <option value="Other" {{ old('location') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('location')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <!-- Review Content -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Review Content</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="rating" class="form-label">Rating *</label>
                                                    <select class="form-select @error('rating') is-invalid @enderror" 
                                                            id="rating" name="rating" required>
                                                        <option value="">Select Rating</option>
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
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
                                                           id="title" name="title" value="{{ old('title') }}" 
                                                           required maxlength="255" placeholder="Give your review a title">
                                                    @error('title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="is_approved" 
                                                               name="is_approved" value="1" {{ old('is_approved', true) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_approved">
                                                            Approved
                                                        </label>
                                                    </div>
                                                    <div class="form-text">Check to approve this review for public display</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="comment" class="form-label">Review Comment</label>
                                                    <textarea class="form-control @error('comment') is-invalid @enderror" 
                                                              id="comment" name="comment" rows="6" maxlength="1000" 
                                                              placeholder="Share your experience with this product...">{{ old('comment') }}</textarea>
                                                    <div class="form-text">Maximum 1000 characters</div>
                                                    @error('comment')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
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
                                        <i class="fas fa-save me-1"></i> Create Review
                                    </button>
                                    
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

@push('scripts')
<script>
// Auto-check verified buyer if order reference is entered
document.getElementById('order_reference').addEventListener('input', function() {
    const orderRef = this.value.trim();
    const verifiedBuyerCheckbox = document.getElementById('is_verified_buyer');
    
    if (orderRef.length === 8 && /^\d+$/.test(orderRef)) {
        verifiedBuyerCheckbox.checked = true;
    }
});
</script>
@endpush
@endsection
