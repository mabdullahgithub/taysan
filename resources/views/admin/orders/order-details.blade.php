@extends('admin.layout.app')
@section('title', 'Order Details')

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
        --shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .order-detail-container {
        background: var(--background);
        min-height: 100vh;
        padding: 2rem;
    }

    .breadcrumb-custom {
        background: var(--white);
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
    }

    .breadcrumb-custom .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: var(--white);
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        opacity: 0.9;
        margin: 0;
        font-size: 1rem;
    }

    .order-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .order-card {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .card-header {
        background: var(--primary-lightest);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-light);
    }

    .card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-light);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: var(--text-medium);
    }

    .info-value {
        font-weight: 600;
        color: var(--text-dark);
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
        background: rgba(72, 187, 120, 0.1);
        color: var(--success);
    }

    .status-delivered {
        background: rgba(72, 187, 120, 0.2);
        color: var(--success);
    }

    .status-cancelled {
        background: rgba(245, 101, 101, 0.1);
        color: var(--danger);
    }

    .order-items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .order-items-table th {
        background: var(--primary-lightest);
        color: var(--text-dark);
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid var(--border-light);
    }

    .order-items-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-light);
        vertical-align: middle;
    }

    .order-items-table tr:last-child td {
        border-bottom: none;
    }

    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid var(--border-light);
    }

    .product-image-placeholder {
        width: 60px;
        height: 60px;
        background: var(--primary-lightest);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
        font-size: 1.5rem;
    }

    .product-name {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .product-id {
        color: var(--text-light);
        font-size: 0.875rem;
    }

    .price-value {
        font-weight: 700;
        color: var(--success);
        font-size: 1rem;
    }

    .total-section {
        background: var(--primary-lightest);
        padding: 1.5rem;
        border-radius: 12px;
        margin-top: 1rem;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
    }

    .total-label {
        font-weight: 500;
        color: var(--text-medium);
    }

    .total-value {
        font-weight: 600;
        color: var(--text-dark);
    }

    .grand-total {
        border-top: 2px solid var(--primary-color);
        padding-top: 1rem;
        margin-top: 1rem;
    }

    .grand-total .total-label {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .grand-total .total-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .status-update-form {
        margin-top: 1rem;
    }

    .form-select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border-light);
        border-radius: 8px;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }

    .btn-primary {
        background: var(--primary-color);
        color: var(--white);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        width: 100%;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    .print-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: var(--white);
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(139, 123, 168, 0.1);
    }

    .print-btn:hover {
        background: var(--primary-color);
        color: var(--white);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(139, 123, 168, 0.2);
    }

    @media (max-width: 768px) {
        .order-detail-container {
            padding: 1rem;
        }
        
        .order-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .page-header {
            padding: 1.5rem;
        }
        
        .order-items-table {
            font-size: 0.875rem;
        }
        
        .order-items-table th,
        .order-items-table td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>

<div class="order-detail-container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-custom">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Order #{{ $order->id }}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-receipt"></i>
                    Order #{{ $order->id }}
                </h1>
                <p class="page-subtitle">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
            </div>
            <div>
                <a href="{{ route('admin.orders.print', $order->id) }}" class="print-btn" target="_blank">
                    <i class="fas fa-print"></i>
                    Print Order
                </a>
            </div>
        </div>
    </div>

    <!-- Order Content Grid -->
    <div class="order-grid">
        <!-- Left Column: Order Items -->
        <div class="order-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-shopping-bag"></i>
                    Order Items
                </h3>
            </div>
            <div class="card-body">
                <table class="order-items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>
                                <div class="product-name">{{ $item->product_name }}</div>
                                <div class="product-id">ID: #{{ $item->product_id }}</div>
                            </td>
                            <td>
                                @if($item->product_image)
                                    @php
                                        $imagePath = $item->product_image;
                                        if (!str_starts_with($imagePath, 'http') && !str_starts_with($imagePath, '/')) {
                                            $imagePath = asset('storage/' . $imagePath);
                                        } elseif (str_starts_with($imagePath, '/') && !str_starts_with($imagePath, '/storage/')) {
                                            $imagePath = asset('storage' . $imagePath);
                                        }
                                    @endphp
                                    <img src="{{ $imagePath }}" 
                                         alt="{{ $item->product_name }}" 
                                         class="product-image"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="product-image-placeholder" style="display: none;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @elseif($item->product && $item->product->image)
                                    <img src="{{ $item->product->image_url }}" 
                                         alt="{{ $item->product_name }}" 
                                         class="product-image"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="product-image-placeholder" style="display: none;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @else
                                    <div class="product-image-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="price-value">PKR {{ number_format($item->product_price, 0) }}</div>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>
                                <div class="price-value">PKR {{ number_format($item->subtotal, 0) }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Order Total -->
                <div class="total-section">
                    <div class="total-row">
                        <span class="total-label">Subtotal:</span>
                        <span class="total-value">PKR {{ number_format($order->subtotal ?? 0, 0) }}</span>
                    </div>
                    <div class="total-row">
                        <span class="total-label">Shipping:</span>
                        <span class="total-value">
                            @if($order->shipping_cost == 0)
                                <span style="color: var(--success);">FREE</span>
                            @else
                                PKR {{ number_format($order->shipping_cost, 0) }}
                            @endif
                        </span>
                    </div>
                    <div class="total-row grand-total">
                        <span class="total-label">Total Amount:</span>
                        <span class="total-value">PKR {{ number_format($order->total, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Order & Customer Info -->
        <div>
            <!-- Order Status -->
            <div class="order-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Order Status
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">Current Status:</span>
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    
                    <!-- Status Update Form -->
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="status-update-form">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn-primary">Update Status</button>
                    </form>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="order-card" style="margin-top: 1rem;">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i>
                        Customer Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">Name:</span>
                        <span class="info-value">{{ $order->full_name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $order->email }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Phone:</span>
                        <span class="info-value">{{ $order->phone }}</span>
                    </div>
                    @if($order->address)
                    <div class="info-row">
                        <span class="info-label">Address:</span>
                        <span class="info-value">{{ $order->address }}</span>
                    </div>
                    @endif
                    <div class="info-row">
                        <span class="info-label">City:</span>
                        <span class="info-value">{{ $order->city }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Country:</span>
                        <span class="info-value">{{ $order->country }}</span>
                    </div>
                    @if($order->postal_code)
                    <div class="info-row">
                        <span class="info-label">Postal Code:</span>
                        <span class="info-value">{{ $order->postal_code }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection