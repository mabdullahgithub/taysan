@extends('admin.layout.app')

@section('title', 'Reviews Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Reviews Management</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Reviews</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-1">
                            <h4 class="mb-2 text-primary fw-bold">{{ number_format($stats['total']) }}</h4>
                            <p class="text-muted mb-1">Total Reviews</p>
                            <small class="text-muted">All time</small>
                        </div>
                        <div class="ms-3">
                            <div class="icon-circle bg-primary bg-gradient d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 50%;">
                                <i class="fas fa-comments fa-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-1">
                            <h4 class="mb-2 text-success fw-bold">{{ number_format($stats['approved']) }}</h4>
                            <p class="text-muted mb-1">Approved</p>
                            <small class="text-success">{{ $stats['total'] > 0 ? round(($stats['approved'] / $stats['total']) * 100, 1) : 0 }}% of total</small>
                        </div>
                        <div class="ms-3">
                            <div class="icon-circle bg-success bg-gradient d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 50%;">
                                <i class="fas fa-check-circle fa-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-1">
                            <h4 class="mb-2 text-warning fw-bold">{{ number_format($stats['pending']) }}</h4>
                            <p class="text-muted mb-1">Pending Review</p>
                            <small class="text-warning">{{ $stats['total'] > 0 ? round(($stats['pending'] / $stats['total']) * 100, 1) : 0 }}% of total</small>
                        </div>
                        <div class="ms-3">
                            <div class="icon-circle bg-warning bg-gradient d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 50%;">
                                <i class="fas fa-clock fa-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-1">
                            <h4 class="mb-2 text-info fw-bold">{{ number_format($stats['verified_buyers']) }}</h4>
                            <p class="text-muted mb-1">Verified Buyers</p>
                            <small class="text-info">{{ $stats['total'] > 0 ? round(($stats['verified_buyers'] / $stats['total']) * 100, 1) : 0 }}% verified</small>
                        </div>
                        <div class="ms-3">
                            <div class="icon-circle bg-info bg-gradient d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 50%;">
                                <i class="fas fa-shield-alt fa-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">All Reviews</h4>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Add Review
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('admin.reviews.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Search</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" name="search" class="form-control" 
                                           value="{{ request('search') }}" 
                                           placeholder="Search reviews...">
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        ✅ Approved
                                    </option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        ⏳ Pending
                                    </option>
                                </select>
                            </div>
                            
                            <div class="col-md-2">
                                <label class="form-label fw-bold">Rating</label>
                                <select name="rating" class="form-select">
                                    <option value="">All Ratings</option>
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                            {{ str_repeat('⭐', $i) }} ({{ $i }})
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Product</label>
                                <select name="product_id" class="form-select">
                                    <option value="">All Products</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" 
                                                {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ Str::limit($product->name, 40) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="btn-group w-100">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter me-1"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Bulk Actions -->
                    <form id="bulkForm" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="review_ids" id="bulkReviewIds">
                    </form>
                    
                    <div class="mb-3 p-3 bg-light rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Bulk Actions:</strong>
                                <span id="selectedCount" class="text-muted ms-2">0 selected</span>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-success btn-sm px-3 py-2" onclick="bulkAction('approve')" id="bulkApproveBtn" disabled>
                                    <i class="fas fa-check me-1"></i> Approve Selected
                                </button>
                                <button type="button" class="btn btn-danger btn-sm px-3 py-2" onclick="bulkAction('delete')" id="bulkDeleteBtn" disabled>
                                    <i class="fas fa-trash me-1"></i> Delete Selected
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                    </th>
                                    <th>Product</th>
                                    <th>Reviewer</th>
                                    <th>Rating</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="review-checkbox" value="{{ $review->id }}">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $review->product->image_url }}" 
                                                 alt="{{ $review->product->name }}" 
                                                 class="me-2 rounded" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                            <div>
                                                <div class="fw-bold">{{ Str::limit($review->product->name, 30) }}</div>
                                                <small class="text-muted">ID: {{ $review->product->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-bold">{{ $review->name }}</div>
                                            <small class="text-muted">{{ $review->email }}</small>
                                            @if($review->location)
                                                <br><small class="text-muted">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $review->location }}
                                                </small>
                                            @endif
                                            @if($review->is_verified_buyer)
                                                <br><span class="badge bg-info">Verified Buyer</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-bold">{{ Str::limit($review->title, 40) }}</div>
                                            <small class="text-muted">{{ Str::limit($review->comment, 80) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($review->is_approved)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <div>{{ $review->formatted_date }}</div>
                                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-start">
                                            <!-- Quick Actions with proper spacing -->
                                            <button class="btn btn-outline-info btn-sm px-2 py-1" 
                                                    onclick="showReview({{ $review->id }})"
                                                    title="View Review"
                                                    data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            
                                            @if($review->is_approved)
                                                <button class="btn btn-outline-warning btn-sm px-2 py-1" 
                                                        onclick="toggleApproval({{ $review->id }}, false)"
                                                        title="Unapprove"
                                                        data-bs-toggle="tooltip">
                                                    <i class="fas fa-pause"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-outline-success btn-sm px-2 py-1" 
                                                        onclick="toggleApproval({{ $review->id }}, true)"
                                                        title="Approve"
                                                        data-bs-toggle="tooltip">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            
                                            <button class="btn btn-outline-primary btn-sm px-2 py-1" 
                                                    onclick="editReview({{ $review->id }})"
                                                    title="Edit"
                                                    data-bs-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <button class="btn btn-outline-danger btn-sm px-2 py-1" 
                                                    onclick="deleteReview({{ $review->id }})"
                                                    title="Delete"
                                                    data-bs-toggle="tooltip">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-comments fa-3x mb-3"></i>
                                            <p>No reviews found</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($reviews->hasPages())
                        <div class="d-flex justify-content-center mt-4 pt-3 border-top">
                            {{ $reviews->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateBulkActionButtons() {
    const selectedCheckboxes = document.querySelectorAll('.review-checkbox:checked');
    const count = selectedCheckboxes.length;
    
    // Update counter
    document.getElementById('selectedCount').textContent = `${count} selected`;
    
    // Enable/disable buttons
    document.getElementById('bulkApproveBtn').disabled = count === 0;
    document.getElementById('bulkDeleteBtn').disabled = count === 0;
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.review-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateBulkActionButtons();
}

function bulkAction(action) {
    const selectedIds = Array.from(document.querySelectorAll('.review-checkbox:checked'))
                            .map(checkbox => checkbox.value);
    
    if (selectedIds.length === 0) {
        alert('Please select at least one review.');
        return;
    }
    
    let confirmMessage;
    let actionUrl;
    
    if (action === 'approve') {
        confirmMessage = `Are you sure you want to approve ${selectedIds.length} review(s)?`;
        actionUrl = '{{ route("admin.reviews.bulk-approve") }}';
    } else if (action === 'delete') {
        confirmMessage = `⚠️ Are you sure you want to delete ${selectedIds.length} review(s)?\n\nThis action cannot be undone!`;
        actionUrl = '{{ route("admin.reviews.bulk-delete") }}';
    }
    
    if (confirm(confirmMessage)) {
        // Show loading
        const button = document.getElementById(action === 'approve' ? 'bulkApproveBtn' : 'bulkDeleteBtn');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';
        button.disabled = true;
        
        const form = document.getElementById('bulkForm');
        document.getElementById('bulkReviewIds').value = selectedIds.join(',');
        form.action = actionUrl;
        form.submit();
    }
}

// Quick action functions
function showReview(reviewId) {
    window.location.href = `/admin/reviews/${reviewId}`;
}

function editReview(reviewId) {
    window.location.href = `/admin/reviews/${reviewId}/edit`;
}

function toggleApproval(reviewId, approve) {
    const action = approve ? 'approve' : 'unapprove';
    
    if (confirm(`Are you sure you want to ${action} this review?`)) {
        // Create and submit form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/reviews/${reviewId}/toggle-approval`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        
        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function deleteReview(reviewId) {
    if (confirm('⚠️ Are you sure you want to delete this review?\n\nThis action cannot be undone!')) {
        // Create and submit form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/reviews/${reviewId}`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Update select all checkbox and bulk action buttons when individual checkboxes change
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    const checkboxes = document.querySelectorAll('.review-checkbox');
    const selectAll = document.getElementById('selectAll');
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            const noneChecked = Array.from(checkboxes).every(cb => !cb.checked);
            
            if (allChecked) {
                selectAll.checked = true;
                selectAll.indeterminate = false;
            } else if (noneChecked) {
                selectAll.checked = false;
                selectAll.indeterminate = false;
            } else {
                selectAll.checked = false;
                selectAll.indeterminate = true;
            }
            
            updateBulkActionButtons();
        });
    });
    
    // Initial update
    updateBulkActionButtons();
    
    // Add loading states to quick action buttons
    document.querySelectorAll('[onclick*="toggleApproval"], [onclick*="deleteReview"]').forEach(button => {
        button.addEventListener('click', function() {
            const originalHtml = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            this.disabled = true;
        });
    });
});
</script>

<style>
/* Enhanced Admin Styling */
.icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.stats-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 1rem;
    overflow: hidden;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 2rem rgba(0,0,0,0.15);
}

.stats-card .card-body {
    padding: 1.5rem;
    background: linear-gradient(135deg, #ffffff, #f8f9fa);
}

.table-hover tbody tr:hover {
    background-color: rgba(0,123,255,0.08) !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}

.badge {
    font-size: 0.75em;
    padding: 0.5em 0.75em;
    border-radius: 0.5rem;
    font-weight: 600;
}

.badge.bg-success {
    background: linear-gradient(45deg, #28a745, #20c997) !important;
}

.badge.bg-warning {
    background: linear-gradient(45deg, #ffc107, #fd7e14) !important;
    color: #000 !important;
}

.badge.bg-info {
    background: linear-gradient(45deg, #17a2b8, #6f42c1) !important;
}

.btn-group-sm .btn {
    transition: all 0.2s ease;
    border-radius: 0.375rem !important;
    margin: 0 1px;
    font-size: 0.8rem;
    padding: 0.4rem 0.6rem;
}

.btn-group-sm .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn-outline-success:hover {
    background: linear-gradient(45deg, #28a745, #20c997);
    border-color: #28a745;
}

.btn-outline-warning:hover {
    background: linear-gradient(45deg, #ffc107, #fd7e14);
    border-color: #ffc107;
    color: #000;
}

.btn-outline-danger:hover {
    background: linear-gradient(45deg, #dc3545, #e83e8c);
    border-color: #dc3545;
}

.btn-outline-info:hover {
    background: linear-gradient(45deg, #17a2b8, #6f42c1);
    border-color: #17a2b8;
}

.btn-outline-primary:hover {
    background: linear-gradient(45deg, #007bff, #6f42c1);
    border-color: #007bff;
}

.table td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

.table th {
    font-weight: 600;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-bottom: 2px solid #dee2e6;
    color: #495057;
}

.review-checkbox, #selectAll {
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: #007bff;
}

.bg-light {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
    border: 1px solid #dee2e6;
}

.card {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    border: none;
    border-radius: 1rem;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-bottom: 1px solid #dee2e6;
    border-radius: 1rem 1rem 0 0 !important;
    padding: 1.5rem;
    font-weight: 600;
}

.card-body {
    padding: 1.5rem;
}

.form-control, .form-select {
    border-radius: 0.5rem;
    border: 1px solid #ced4da;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    transform: translateY(-1px);
}

.btn {
    border-radius: 0.5rem;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
}

.btn-success {
    background: linear-gradient(45deg, #28a745, #20c997);
    border: none;
}

.btn-danger {
    background: linear-gradient(45deg, #dc3545, #e83e8c);
    border: none;
}

.page-title-box {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 2rem;
    border-radius: 1rem;
    margin-bottom: 1.5rem;
    border: 1px solid #dee2e6;
}

.input-group-text {
    background: linear-gradient(135deg, #e9ecef, #f8f9fa);
    border: 1px solid #ced4da;
    border-right: none;
}

/* Animated loading states */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.loading {
    animation: pulse 1.5s ease-in-out infinite;
}

/* Product image styling */
.table img {
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}

.table img:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Star ratings */
.text-warning i {
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .btn-group-sm .btn {
        padding: 0.25rem 0.4rem;
        font-size: 0.7rem;
        margin: 0;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .page-title-box {
        padding: 1rem;
    }
    
    .stats-card .card-body {
        padding: 1rem;
    }
    
    .icon-circle {
        width: 50px;
        height: 50px;
    }
    
    .icon-circle i {
        font-size: 1.5rem !important;
    }
}

/* Animation for new rows */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.table tbody tr {
    animation: slideIn 0.3s ease-out;
}

/* Enhanced pagination */
.pagination .page-link {
    border-radius: 0.5rem;
    margin: 0 2px;
    border: none;
    color: #007bff;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
}

.pagination .page-link:hover {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
}

/* Additional styling for improved design */
.table th {
    font-weight: 600;
    background-color: #f8f9fa;
    border-top: none;
    vertical-align: middle;
    padding: 15px 12px;
}

.table td {
    vertical-align: middle;
    padding: 12px;
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.stats-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.icon-circle {
    transition: transform 0.2s ease;
}

.stats-card:hover .icon-circle {
    transform: scale(1.1);
}

.table-responsive {
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
}
</style>
@endpush
@endsection
