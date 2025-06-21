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
        --info: #4299E1;
    }

    .orders-container {
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

    .table-container {
        background: var(--white);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(139, 123, 168, 0.08);
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

    .location-info {
        font-weight: 500;
        color: var(--text-dark);
        margin-bottom: 2px;
    }

    .location-detail {
        color: var(--text-light);
        font-size: 0.8rem;
    }

    .items-badge {
        background: var(--primary-lightest);
        color: var(--primary-dark);
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .total-amount {
        color: var(--success);
        font-size: 1rem;
        font-weight: 700;
    }

    .order-date {
        color: var(--text-medium);
        font-weight: 500;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        background: transparent;
        border: 1px solid var(--border-light);
        color: var(--text-light);
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        background-color: var(--background);
        transform: translateY(-1px);
        text-decoration: none;
    }

    .action-btn.btn-view:hover {
        border-color: var(--info);
        color: var(--info);
    }

    .table thead th {
        background: var(--primary-lightest);
        color: var(--text-dark);
        border: none;
        padding: 1rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .table tbody td {
        padding: 1rem;
        border-color: var(--border-light);
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: rgba(139, 123, 168, 0.02);
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid var(--border-light);
        border-radius: 8px;
        padding: 0.5rem;
        color: var(--text-dark);
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(139, 123, 168, 0.1);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem 1rem;
        margin: 0 0.25rem;
        border-radius: 6px;
        border: 1px solid var(--border-light);
        color: var(--text-medium);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--primary-color) !important;
        color: var(--white) !important;
        border-color: var(--primary-color) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary-color) !important;
        color: var(--white) !important;
        border-color: var(--primary-color) !important;
    }
</style>

<div class="orders-container">
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Orders</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <h1 class="page-title">
                        <i class="fas fa-shopping-cart"></i>
                        Orders Management
                    </h1>
                    <p class="page-subtitle">Manage customer orders and track order details</p>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="table-container">
            <table id="ordersTable" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Location</th>
                        <th>Items</th>
                        <th>Total Amount</th>
                        <th>Order Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <div class="order-id">#{{ $order->id }}</div>
                        </td>
                        <td>
                            <div class="customer-info">{{ $order->first_name }} {{ $order->last_name }}</div>
                        </td>
                        <td>
                            <div class="customer-info">{{ $order->email }}</div>
                            <div class="customer-contact">{{ $order->phone }}</div>
                        </td>
                        <td>
                            <div class="location-info">{{ $order->city }}</div>
                            <div class="location-detail">{{ $order->country }}</div>
                        </td>
                        <td>
                            @php
                                $items = json_decode($order->order_items, true) ?: [];
                                $itemCount = collect($items)->sum('quantity');
                            @endphp
                            <span class="items-badge">{{ $itemCount }} items</span>
                        </td>
                        <td>
                            <div class="total-amount">PKR {{ number_format($order->total, 2) }}</div>
                        </td>
                        <td>
                            <div class="order-date">{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</div>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="action-btn btn-view" 
                               title="View Order">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#ordersTable').DataTable({
        responsive: true,
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        order: [[6, 'desc']], // Order by date descending
        columnDefs: [
            { targets: [7], orderable: false, searchable: false }
        ]
    });
});
</script>

@endsection