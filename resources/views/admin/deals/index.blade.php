@extends('admin.layout.app')
@section('title', 'Deal of the Day Management')

@section('content')

<style>
    :root {
        --primary-color: #8B7BA8;
        --primary-light: #A893C4;
        --primary-lighter: #C4B5D8;
        --primary-lightest: #E9E3F0;
        --primary-dark: #6B5B7D;
        --background: #F8F9FA;
        --white: #FFFFFF;
        --text-dark: #2D3748;
        --text-medium: #4A5568;
        --text-light: #718096;
        --border-light: #E2E8F0;
        --success: #48BB78;
        --danger: #F56565;
        --warning: #ED8936;
        --info: #4299E1;
    }

    .deals-container {
        background-color: var(--background);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        color: var(--white);
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
    }

    .deal-card {
        background: var(--white);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        border: 1px solid var(--border-light);
        transition: all 0.3s ease;
    }

    .deal-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .deal-product-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .deal-product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid var(--border-light);
    }

    .deal-product-placeholder {
        width: 80px;
        height: 80px;
        background: var(--primary-lightest);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 1.5rem;
    }

    .deal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }

    .deal-subtitle {
        color: var(--text-medium);
        font-size: 0.9rem;
        margin: 0;
    }

    .deal-pricing {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 1rem 0;
    }

    .original-price {
        text-decoration: line-through;
        color: var(--text-light);
        font-size: 0.9rem;
    }

    .deal-price {
        color: var(--danger);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .savings-badge {
        background: var(--success);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .deal-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 1rem 0;
    }

    .status-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .status-active { background: var(--success); }
    .status-inactive { background: var(--text-light); }
    .status-expired { background: var(--danger); }

    .deal-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .btn-edit {
        background: var(--info);
        color: white;
    }

    .btn-view {
        background: var(--success);
        color: white;
    }

    .btn-toggle {
        background: var(--warning);
        color: white;
    }

    .btn-delete {
        background: var(--danger);
        color: white;
    }

    .btn-action:hover {
        transform: translateY(-1px);
        opacity: 0.9;
    }

    .add-deal-form {
        background: var(--white);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }

    .form-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-group {
        flex: 1;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-dark);
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--border-light);
        border-radius: 8px;
        font-size: 0.9rem;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(139, 123, 168, 0.1);
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .deals-grid {
        display: grid;
        gap: 1.5rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--text-light);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--primary-light);
    }

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }
        
        .deal-product-info {
            flex-direction: column;
            text-align: center;
        }
        
        .deal-actions {
            justify-content: center;
        }
    }
</style>

<div class="deals-container">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="display-6 fw-bold mb-2">
                <i class="fas fa-fire me-3"></i>Deal of the Day Management
            </h1>
            <p class="mb-0 opacity-85">Create and manage attractive product deals for your customers</p>
        </div>

        <!-- Add New Deal Form -->
        <div class="add-deal-form">
            <h3 class="mb-3">
                <i class="fas fa-plus-circle me-2 text-primary"></i>Add New Deal
            </h3>
            
            <form action="{{ route('admin.deals.store') }}" method="POST">
                @csrf
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Product</label>
                        <select name="product_id" class="form-control" required>
                            <option value="">Select a product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} - PKR {{ number_format($product->price, 2) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Deal Title</label>
                        <input type="text" name="deal_title" class="form-control" placeholder="e.g., Flash Sale, Limited Time Offer">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Discount Percentage (%)</label>
                        <input type="number" name="discount_percentage" class="form-control" min="0" max="100" step="0.01" placeholder="e.g., 25.50">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Deal Price (PKR) - Optional</label>
                        <input type="number" name="deal_price" class="form-control" min="0" step="0.01" placeholder="Override with fixed price">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0" min="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Start Date</label>
                        <input type="datetime-local" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">End Date</label>
                        <input type="datetime-local" name="end_date" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Deal Description</label>
                    <textarea name="deal_description" class="form-control" rows="3" placeholder="Describe the deal..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-check-label">
                        <input type="checkbox" name="is_active" value="1" checked> Active
                    </label>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Deal
                </button>
            </form>
        </div>

        <!-- Deals List -->
        <div class="deals-grid">
            @forelse($deals as $deal)
                <div class="deal-card">
                    <div class="deal-product-info">
                        @if($deal->product->image)
                            <img src="{{ asset('storage/' . $deal->product->image) }}" 
                                 alt="{{ $deal->product->name }}" 
                                 class="deal-product-image">
                        @else
                            <div class="deal-product-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        
                        <div>
                            <h4 class="deal-title">{{ $deal->deal_title ?: $deal->product->name }}</h4>
                            <p class="deal-subtitle">{{ $deal->product->name }}</p>
                            @if($deal->deal_description)
                                <p class="text-muted small">{{ Str::limit($deal->deal_description, 100) }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="deal-pricing">
                        <span class="original-price">PKR {{ number_format($deal->product->price, 2) }}</span>
                        <span class="deal-price">PKR {{ number_format($deal->final_price, 2) }}</span>
                        @if($deal->savings > 0)
                            <span class="savings-badge">Save PKR {{ number_format($deal->savings, 2) }}</span>
                        @endif
                    </div>

                    <div class="deal-status">
                        <span class="status-indicator {{ $deal->is_currently_active ? 'status-active' : ($deal->end_date < now() ? 'status-expired' : 'status-inactive') }}"></span>
                        <span>
                            @if($deal->is_currently_active)
                                Active
                            @elseif($deal->end_date < now())
                                Expired
                            @else
                                Inactive
                            @endif
                        </span>
                        <span class="text-muted">
                            | {{ $deal->start_date->format('M j, Y') }} - {{ $deal->end_date->format('M j, Y') }}
                        </span>
                    </div>

                    <div class="deal-actions">
                        <a href="{{ route('web.view.index') }}#deal-{{ $deal->id }}" target="_blank" class="btn-action btn-view">
                            <i class="fas fa-eye"></i>View
                        </a>
                        
                        <button class="btn-action btn-toggle toggle-deal" data-id="{{ $deal->id }}">
                            <i class="fas fa-toggle-{{ $deal->is_active ? 'on' : 'off' }}"></i>
                            {{ $deal->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                        
                        <button class="btn-action btn-edit edit-deal" data-deal="{{ json_encode($deal->toArray()) }}">
                            <i class="fas fa-edit"></i>Edit
                        </button>
                        
                        <button class="btn-action btn-delete delete-deal" data-id="{{ $deal->id }}" data-title="{{ $deal->deal_title ?: $deal->product->name }}">
                            <i class="fas fa-trash"></i>Delete
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-fire"></i>
                    <h3>No deals created yet</h3>
                    <p>Create your first deal to attract customers with special offers!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Edit Deal Modal -->
<div class="modal fade" id="editDealModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Deal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editDealForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Product</label>
                            <select name="product_id" id="edit_product_id" class="form-control" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} - PKR {{ number_format($product->price, 2) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Deal Title</label>
                            <input type="text" name="deal_title" id="edit_deal_title" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Discount Percentage (%)</label>
                            <input type="number" name="discount_percentage" id="edit_discount_percentage" class="form-control" min="0" max="100" step="0.01">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Deal Price (PKR)</label>
                            <input type="number" name="deal_price" id="edit_deal_price" class="form-control" min="0" step="0.01">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="edit_sort_order" class="form-control" min="0">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Start Date</label>
                            <input type="datetime-local" name="start_date" id="edit_start_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">End Date</label>
                            <input type="datetime-local" name="end_date" id="edit_end_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deal Description</label>
                        <textarea name="deal_description" id="edit_deal_description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-check-label">
                            <input type="checkbox" name="is_active" id="edit_is_active" value="1"> Active
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary">Update Deal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Edit deal
    $('.edit-deal').click(function() {
        const deal = JSON.parse($(this).attr('data-deal'));
        
        $('#editDealForm').attr('action', `/admin/deals/${deal.id}`);
        $('#edit_product_id').val(deal.product_id);
        $('#edit_deal_title').val(deal.deal_title);
        $('#edit_discount_percentage').val(deal.discount_percentage);
        $('#edit_deal_price').val(deal.deal_price);
        $('#edit_sort_order').val(deal.sort_order);
        $('#edit_deal_description').val(deal.deal_description);
        $('#edit_is_active').prop('checked', deal.is_active);
        
        // Format dates for datetime-local input
        if(deal.start_date) {
            $('#edit_start_date').val(new Date(deal.start_date).toISOString().slice(0, 16));
        }
        if(deal.end_date) {
            $('#edit_end_date').val(new Date(deal.end_date).toISOString().slice(0, 16));
        }
        
        $('#editDealModal').modal('show');
    });

    // Toggle deal status
    $('.toggle-deal').click(function() {
        const dealId = $(this).data('id');
        const button = $(this);
        
        $.post(`/admin/deals/${dealId}/toggle-status`, {
            _token: $('meta[name="csrf-token"]').attr('content')
        })
        .done(function(response) {
            if(response.success) {
                location.reload();
            } else {
                Swal.fire('Error!', response.message, 'error');
            }
        })
        .fail(function() {
            Swal.fire('Error!', 'Failed to update deal status.', 'error');
        });
    });

    // Delete deal
    $('.delete-deal').click(function() {
        const dealId = $(this).data('id');
        const dealTitle = $(this).data('title');
        
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete the deal "${dealTitle}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F56565',
            cancelButtonColor: '#6B5B7D',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/deals/${dealId}`,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success) {
                            Swal.fire('Deleted!', response.message, 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Failed to delete deal.', 'error');
                    }
                });
            }
        });
    });

    // Set default dates
    const now = new Date();
    const tomorrow = new Date(now.getTime() + 24 * 60 * 60 * 1000);
    const nextWeek = new Date(now.getTime() + 7 * 24 * 60 * 60 * 1000);
    
    $('input[name="start_date"]').val(now.toISOString().slice(0, 16));
    $('input[name="end_date"]').val(nextWeek.toISOString().slice(0, 16));
});
</script>

@endsection
