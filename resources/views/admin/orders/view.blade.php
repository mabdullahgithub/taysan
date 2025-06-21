@extends('admin.layout.app')
@section('title', 'Orders Management')

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

    .main-content {
        min-height: 100vh;
        background: var(--background);
        padding: 2rem;
    }

    .header-section {
        background: var(--white);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .header-title {
        color: var(--text-dark);
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
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

    .filters-section {
        background: var(--white);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .filter-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 0.75rem 1.5rem;
        background: var(--primary-lightest);
        color: var(--primary-dark);
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-tab.active {
        background: var(--primary-color);
        color: var(--white);
    }

    .tab-count {
        background: rgba(255,255,255,0.2);
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .orders-table {
        background: var(--white);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .table thead th {
        background: var(--primary-lightest);
        color: var(--primary-dark);
        font-weight: 600;
        padding: 1rem;
        border: none;
    }

    .table tbody td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-light);
        vertical-align: middle;
    }

    .order-id {
        font-weight: 600;
        color: var(--primary-color);
    }

    .customer-info {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 2px;
    }

    .customer-contact {
        color: var(--text-light);
        font-size: 0.8rem;
    }

    .total-amount {
        font-weight: 700;
        color: var(--success);
        font-size: 1.1rem;
    }

    .action-btn {
        background: none;
        border: none;
        padding: 0.5rem;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .action-btn:hover {
        background: var(--primary-lightest);
        transform: scale(1.1);
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--text-light);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--primary-lighter);
    }

    /* Pagination info text */
    .pagination-info {
        background: var(--white);
        padding: 1rem 2rem;
        border-top: 1px solid var(--border-light);
        text-align: center;
        color: var(--text-medium);
        font-size: 0.875rem;
        border-radius: 0;
        margin-top: 1rem;
    }

    .pagination-info strong {
        color: var(--primary-color);
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .pagination-info {
            padding: 0.75rem 1rem;
            font-size: 0.8rem;
        }
    }
</style>

<div class="main-content">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-custom">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orders</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="header-section">
        <h1 class="header-title">Orders Management</h1>
        <p>View and manage all customer orders</p>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="filter-tabs">
            <a href="{{ route('admin.orders.index') }}" class="filter-tab {{ !request('status') && !request('shipping') && !request('deal') ? 'active' : '' }}">
                <i class="fas fa-list"></i>
                All Orders
                <span class="tab-count">{{ $orderCounts['all'] ?? 0 }}</span>
            </a>
            
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}">
                <i class="fas fa-clock"></i>
                Pending
                <span class="tab-count">{{ $orderCounts['pending'] ?? 0 }}</span>
            </a>
            
            <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="filter-tab {{ request('status') == 'processing' ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                Processing
                <span class="tab-count">{{ $orderCounts['processing'] ?? 0 }}</span>
            </a>
            
            <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="filter-tab {{ request('status') == 'shipped' ? 'active' : '' }}">
                <i class="fas fa-truck"></i>
                Shipped
                <span class="tab-count">{{ $orderCounts['shipped'] ?? 0 }}</span>
            </a>
            
            <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="filter-tab {{ request('status') == 'delivered' ? 'active' : '' }}">
                <i class="fas fa-check-circle"></i>
                Delivered
                <span class="tab-count">{{ $orderCounts['delivered'] ?? 0 }}</span>
            </a>
            
            <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="filter-tab {{ request('status') == 'cancelled' ? 'active' : '' }}">
                <i class="fas fa-times-circle"></i>
                Cancelled
                <span class="tab-count">{{ $orderCounts['cancelled'] ?? 0 }}</span>
            </a>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="orders-table">
        @if($orders->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <span class="order-id">#{{ $order->id }}</span>
                        </td>
                        <td>
                            <div class="customer-info">{{ $order->full_name }}</div>
                            <div class="customer-contact">{{ $order->email }}</div>
                        </td>
                        <td>
                            <div class="total-amount">PKR {{ number_format($order->total ?? 0, 0) }}</div>
                        </td>
                        <td>
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="action-btn" 
                                   title="View Order Details">
                                    <i class="fas fa-eye text-primary"></i>
                                </a>
                                <a href="{{ route('admin.orders.print', $order->id) }}" 
                                   class="action-btn" 
                                   title="Print Order"
                                   target="_blank">
                                    <i class="fas fa-print text-success"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            @if($orders->hasPages())
                <!-- Pagination Info -->
                <div class="pagination-info">
                    Showing <strong>{{ $orders->firstItem() }}</strong> to <strong>{{ $orders->lastItem() }}</strong> 
                    of <strong>{{ $orders->total() }}</strong> orders
                </div>
                
                <!-- Custom Modern Pagination -->
                {{ $orders->appends(request()->query())->links('custom.pagination') }}
            @endif
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h4>No Orders Found</h4>
                <p>There are no orders matching your current filter criteria.</p>
            </div>
        @endif
    </div>
</div>

@endsection