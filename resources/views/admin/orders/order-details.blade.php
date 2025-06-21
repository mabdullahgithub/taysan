@extends('admin.layout.app')
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
        --warning: #ED8936;
        --danger: #F56565;
        --info: #4299E1;
    }

    .order-detail-container {
        background-color: var(--background);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .order-card {
        background: var(--white);
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(139, 123, 168, 0.08);
        border: 1px solid rgba(139, 123, 168, 0.06);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .order-card-header {
        background: var(--primary-lightest);
        color: var(--text-dark);
        padding: 1.25rem;
        border-bottom: 1px solid var(--border-light);
        margin: 0;
    }

    .order-card-title {
        font-size: 1.125rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .order-card-body {
        padding: 1.5rem;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        color: var(--white);
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        opacity: 0.85;
        font-size: 1rem;
        margin: 0;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-badge.badge-lg {
        font-size: 1rem;
        padding: 0.75rem 1.5rem;
    }

    .status-pending {
        background: rgba(237, 137, 54, 0.1);
        color: var(--warning);
    }

    .status-processing {
        background: rgba(66, 153, 225, 0.1);
        color: var(--info);
    }

    .status-shipped {
        background: rgba(139, 123, 168, 0.1);
        color: var(--primary-dark);
    }

    .status-delivered {
        background: rgba(72, 187, 120, 0.1);
        color: var(--success);
    }

    .status-cancelled {
        background: rgba(245, 101, 101, 0.1);
        color: var(--danger);
    }

    .info-table {
        width: 100%;
        margin: 0;
    }

    .info-table td {
        padding: 0.75rem 0;
        border: none;
        vertical-align: top;
    }

    .info-table td:first-child {
        font-weight: 600;
        color: var(--text-medium);
        width: 35%;
    }

    .info-table td:last-child {
        color: var(--text-dark);
    }

    .order-items-table {
        width: 100%;
        margin: 0;
    }

    .order-items-table th {
        background: var(--primary-lightest);
        color: var(--text-dark);
        border: none;
        padding: 1rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .order-items-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-light);
        vertical-align: middle;
    }

    .order-items-table tbody tr:hover {
        background-color: rgba(139, 123, 168, 0.02);
    }

    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border-light);
    }

    .product-image-placeholder {
        width: 60px;
        height: 60px;
        background: var(--background);
        border: 1px solid var(--border-light);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
    }

    .quantity-badge {
        background: var(--primary-lighter);
        color: var(--primary-dark);
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .btn-custom {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-primary-custom {
        background: var(--primary-color);
        color: var(--white);
    }

    .btn-primary-custom:hover {
        background: var(--primary-dark);
        color: var(--white);
        transform: translateY(-1px);
    }

    .btn-secondary-custom {
        background: var(--background);
        color: var(--text-medium);
        border: 1px solid var(--border-light);
    }

    .btn-secondary-custom:hover {
        background: var(--border-light);
        color: var(--text-dark);
    }

    .btn-info-custom {
        background: rgba(66, 153, 225, 0.1);
        color: var(--info);
        border: 1px solid rgba(66, 153, 225, 0.2);
    }

    .btn-info-custom:hover {
        background: rgba(66, 153, 225, 0.2);
        color: var(--info);
    }

    .form-control-custom {
        padding: 0.75rem;
        border: 1px solid var(--border-light);
        border-radius: 8px;
        transition: border-color 0.2s ease;
    }

    .form-control-custom:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(139, 123, 168, 0.1);
    }

    .breadcrumb-custom {
        background: var(--white);
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-light);
    }

    .breadcrumb-custom .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
    }

    .breadcrumb-custom .breadcrumb-item.active {
        color: var(--text-medium);
    }

    .total-amount {
        background: var(--primary-lightest);
        color: var(--primary-dark);
        font-size: 1.25rem;
        font-weight: 700;
        padding: 1rem;
        border-radius: 8px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .order-detail-container {
            padding: 1rem 0;
        }
        
        .page-header {
            padding: 1.5rem;
            text-align: center;
        }
        
        .page-title {
            font-size: 1.5rem;
            justify-content: center;
        }
        
        .order-card-body {
            padding: 1rem;
        }
        
        .order-items-table th,
        .order-items-table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .product-image,
        .product-image-placeholder {
            width: 50px;
            height: 50px;
        }
    }

    /* Print Styles */
    @media print {
        .btn-custom, .order-card-header, .breadcrumb-custom, .page-header .status-badge {
            display: none !important;
        }
        
        .order-card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
            margin-bottom: 1rem !important;
        }
        
        .order-items-table {
            font-size: 12px;
        }
        
        .page-header {
            background: none !important;
            color: #000 !important;
            border: 1px solid #ddd !important;
        }
    }
</style>

<div class="order-detail-container">
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</li>
            </ol>
        </nav>
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">
                        <i class="fas fa-shopping-cart"></i>
                        Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                    </h1>
                    <p class="page-subtitle">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <span class="status-badge status-{{ $order->status }} badge-lg">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Customer & Shipping Information -->
        <div class="row">
            <!-- Customer Information -->
            <div class="col-lg-6">
                <div class="order-card">
                    <div class="order-card-header">
                        <h6 class="order-card-title">
                            <i class="fas fa-user"></i>
                            Customer Information
                        </h6>
                    </div>
                    <div class="order-card-body">
                        <table class="info-table">
                            <tr>
                                <td>Name:</td>
                                <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>
                                    <a href="mailto:{{ $order->email }}" style="color: var(--primary-color);">
                                        {{ $order->email }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Phone:</td>
                                <td>
                                    <a href="tel:{{ $order->phone }}" style="color: var(--primary-color);">
                                        {{ $order->phone }}
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Shipping Information -->
            <div class="col-lg-6">
                <div class="order-card">
                    <div class="order-card-header">
                        <h6 class="order-card-title">
                            <i class="fas fa-map-marker-alt"></i>
                            Shipping Information
                        </h6>
                    </div>
                    <div class="order-card-body">
                        <table class="info-table">
                            @if(isset($order->address))
                            <tr>
                                <td>Address:</td>
                                <td>{{ $order->address }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>City:</td>
                                <td>{{ $order->city }}</td>
                            </tr>
                            <tr>
                                <td>Country:</td>
                                <td>{{ $order->country }}</td>
                            </tr>
                            <tr>
                                <td>Postal Code:</td>
                                <td>{{ $order->postal_code ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="order-card">
            <div class="order-card-header">
                <h6 class="order-card-title">
                    <i class="fas fa-list"></i>
                    Order Items ({{ $order->orderItems->count() }} items)
                </h6>
            </div>
            <div class="order-card-body p-0">
                <div class="table-responsive">
                    <table class="order-items-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th style="text-align: right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div>
                                        <strong style="color: var(--text-dark);">{{ $item->product_name }}</strong>
                                        <br>
                                        <small style="color: var(--text-light);">Product ID: #{{ $item->product_id }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if($item->product_image)
                                        <img src="{{ $item->product_image }}" 
                                             alt="{{ $item->product_name }}" 
                                             class="product-image">
                                    @else
                                        <div class="product-image-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong style="color: var(--text-dark);">PKR {{ number_format($item->product_price, 2) }}</strong>
                                </td>
                                <td>
                                    <span class="quantity-badge">{{ $item->quantity }}</span>
                                </td>
                                <td style="text-align: right;">
                                    <strong style="color: var(--text-dark);">PKR {{ number_format($item->subtotal, 2) }}</strong>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 3rem;">
                                    <div style="color: var(--text-light);">
                                        <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                                        <p>No items found for this order.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="text-align: right; padding: 1.5rem 1rem; font-weight: 600;">
                                    Total Amount:
                                </td>
                                <td style="text-align: right; padding: 1.5rem 1rem;">
                                    <div class="total-amount">
                                        PKR {{ number_format($order->total, 2) }}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Summary & Actions -->
        <div class="row">
            <!-- Order Summary -->
            <div class="col-lg-6">
                <div class="order-card">
                    <div class="order-card-header">
                        <h6 class="order-card-title">
                            <i class="fas fa-info-circle"></i>
                            Order Summary
                        </h6>
                    </div>
                    <div class="order-card-body">
                        <table class="info-table">
                            <tr>
                                <td>Order ID:</td>
                                <td>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            </tr>
                            <tr>
                                <td>Status:</td>
                                <td>
                                    <span class="status-badge status-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Order Date:</td>
                                <td>{{ $order->created_at->format('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <td>Order Time:</td>
                                <td>{{ $order->created_at->format('h:i A') }}</td>
                            </tr>
                            <tr>
                                <td>Total Items:</td>
                                <td>{{ $order->orderItems->sum('quantity') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="col-lg-6">
                <div class="order-card">
                    <div class="order-card-header">
                        <h6 class="order-card-title">
                            <i class="fas fa-cogs"></i>
                            Actions
                        </h6>
                    </div>
                    <div class="order-card-body">
                        <div style="margin-bottom: 1.5rem;">
                            <label style="font-weight: 600; color: var(--text-medium); margin-bottom: 0.5rem; display: block;">
                                Update Status:
                            </label>
<form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div style="display: flex; gap: 0.5rem;">
        <select name="status" class="form-control-custom" style="flex: 1;">
            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button type="submit" class="btn-custom btn-primary-custom">
            Update
        </button>
    </div>
</form>
                        </div>
                        
                        <div style="display: grid; gap: 0.75rem;">
                            <a href="{{ route('admin.orders.index') }}" class="btn-custom btn-secondary-custom" style="text-decoration: none; text-align: center;">
                                <i class="fas fa-arrow-left" style="margin-right: 0.5rem;"></i>Back to Orders
                            </a>
                            <button class="btn-custom btn-info-custom" onclick="window.print()">
                                <i class="fas fa-print" style="margin-right: 0.5rem;"></i>Print Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection