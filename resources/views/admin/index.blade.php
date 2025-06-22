@extends('admin.layout.app')
@section('content')

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

    body {
        background-color: var(--background);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .dashboard-card {
        background: var(--white);
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(139, 123, 168, 0.08);
        border: 1px solid rgba(139, 123, 168, 0.06);
        transition: all 0.2s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(139, 123, 168, 0.12);
    }

    .stat-card {
        background: linear-gradient(135deg, var(--white) 0%, var(--primary-lightest) 100%);
        border: 1px solid var(--primary-lighter);
        border-radius: 16px;
        padding: 1.75rem;
        height: 100%;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        background: var(--primary-lighter);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: var(--primary-dark);
        margin-bottom: 1rem;
    }

    .stat-number {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
        word-break: break-word;
    }

    .stat-label {
        color: var(--text-medium);
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .stat-trend {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.8rem;
        font-weight: 500;
        flex-wrap: wrap;
    }

    .trend-up { color: var(--success); }
    .trend-down { color: var(--danger); }
    .trend-neutral { color: var(--text-light); }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        color: var(--white);
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        opacity: 0.85;
        font-size: 1rem;
    }

    .quick-action {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: var(--white);
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .quick-action:hover {
        background: rgba(255, 255, 255, 0.25);
        color: var(--white);
        text-decoration: none;
        transform: translateY(-1px);
    }

    .chart-card {
        background: var(--white);
        border-radius: 16px;
        border: 1px solid var(--border-light);
        overflow: hidden;
    }

    .chart-header {
        background: var(--primary-lightest);
        color: var(--text-dark);
        padding: 1.25rem;
        border-bottom: 1px solid var(--border-light);
    }

    .chart-title {
        font-size: 1.125rem;
        font-weight: 600;
        margin: 0;
    }

    .chart-container {
        padding: 1.5rem;
        height: 300px;
    }

    .revenue-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
        padding: 1.25rem;
        background: var(--background);
        border-bottom: 1px solid var(--border-light);
    }

    .revenue-stat {
        text-align: center;
    }

    .revenue-stat-label {
        color: var(--text-light);
        font-size: 0.8rem;
        margin-bottom: 0.25rem;
    }

    .revenue-stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
        word-break: break-word;
    }

    .revenue-stat-change {
        font-size: 0.75rem;
        font-weight: 500;
    }

    .orders-table {
        background: var(--white);
        border-radius: 16px;
        border: 1px solid var(--border-light);
        overflow: hidden;
    }

    .table {
        margin: 0;
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

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        white-space: nowrap;
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

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }

    .action-btn:hover {
        transform: translateY(-1px);
    }

    .btn-view {
        background: rgba(66, 153, 225, 0.1);
        color: var(--info);
    }

    .btn-view:hover {
        background: rgba(66, 153, 225, 0.2);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-light);
    }

    .empty-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .dropdown-toggle::after {
        border: none;
        content: "\f107";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        vertical-align: 0;
    }

    /* Mobile Responsive Design */
    @media (max-width: 991px) {
        .page-header {
            padding: 1.5rem;
        }
        
        .page-title {
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
        }
        
        .page-subtitle {
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .quick-action {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
        }
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .page-header {
            padding: 1.25rem;
            text-align: center;
        }
        
        .page-title {
            font-size: 1.4rem;
        }
        
        .quick-action {
            width: 100%;
            justify-content: center;
            margin-bottom: 0.5rem;
            padding: 0.75rem 1rem;
        }
        
        .revenue-stats {
            grid-template-columns: 1fr;
            gap: 0.75rem;
            padding: 1rem;
        }
        
        .stat-card {
            padding: 1.25rem;
            text-align: center;
        }
        
        .stat-number {
            font-size: 1.5rem;
        }
        
        .stat-icon {
            margin: 0 auto 1rem;
        }
        
        .chart-header {
            padding: 1rem;
            flex-direction: column;
            gap: 1rem;
        }
        
        .chart-header .btn {
            width: 100%;
        }
        
        .revenue-stat-value {
            font-size: 1.1rem;
        }
        
        .revenue-stat-label {
            font-size: 0.75rem;
        }
        
        .revenue-stat-change {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 576px) {
        .py-4 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }
        
        .page-header {
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .page-title {
            font-size: 1.25rem;
        }
        
        .page-subtitle {
            font-size: 0.85rem;
        }
        
        .stat-card {
            padding: 1rem;
        }
        
        .stat-number {
            font-size: 1.3rem;
        }
        
        .stat-label {
            font-size: 0.8rem;
        }
        
        .stat-trend {
            font-size: 0.75rem;
            justify-content: center;
        }
        
        .chart-container {
            height: 250px;
            padding: 1rem;
        }
        
        .chart-header {
            padding: 0.75rem;
        }
        
        .chart-title {
            font-size: 1rem;
        }
        
        .revenue-stats {
            padding: 0.75rem;
        }
        
        .revenue-stat-value {
            font-size: 1rem;
        }
        
        .table-responsive {
            border-radius: 0;
        }
        
        .table thead th,
        .table tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8rem;
        }
        
        .table thead th {
            font-size: 0.7rem;
        }
        
        .status-badge {
            padding: 0.25rem 0.5rem;
            font-size: 0.65rem;
        }
        
        .action-btn {
            width: 28px;
            height: 28px;
            font-size: 0.75rem;
        }
        
        /* Hide less important columns on mobile */
        .table .d-none-mobile {
            display: none;
        }
        
        /* Stack customer info vertically */
        .customer-info {
            display: block;
        }
        
        .customer-info .fw-medium {
            font-size: 0.8rem;
        }
        
        .customer-info .text-muted {
            font-size: 0.7rem;
        }
        
        /* Adjust order date display */
        .order-date {
            display: block;
        }
        
        .order-date .text-dark {
            font-size: 0.8rem;
        }
        
        .order-date .text-muted {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 480px) {
        .stat-card {
            padding: 0.75rem;
        }
        
        .stat-number {
            font-size: 1.2rem;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }
        
        .chart-container {
            height: 200px;
            padding: 0.75rem;
        }
        
        .revenue-stats {
            grid-template-columns: 1fr;
            gap: 0.5rem;
            padding: 0.5rem;
        }
        
        .revenue-stat-value {
            font-size: 0.9rem;
        }
        
        .revenue-stat-label {
            font-size: 0.7rem;
        }
        
        .table thead th,
        .table tbody td {
            padding: 0.5rem 0.25rem;
            font-size: 0.75rem;
        }
        
        .empty-state {
            padding: 2rem 0.5rem;
        }
        
        .empty-icon {
            font-size: 2rem;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="page-title text-white">Dashboard</h1>
                <p class="page-subtitle mb-0">Welcome back! Here's your store overview.</p>
            </div>
            <div class="col-lg-4 mt-3 mt-lg-0 text-lg-end">
                <a href="{{ route('admin.products.index') }}" class="quick-action me-2">
                    <i class="fas fa-box"></i> Products
                </a>
                <a href="{{ route('admin.orders.index') }}" class="quick-action">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="dashboard-card stat-card">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-number">{{ $totalOrders ?? 0 }}</div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>12% increase</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="dashboard-card stat-card">
                <div class="stat-icon">
                    <i class="fas fa-rupee-sign"></i>
                </div>
                <div class="stat-number">PKR {{ number_format($totalRevenue ?? 0, 0) }}</div>
                <div class="stat-label">Total Revenue</div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>8% increase</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="dashboard-card stat-card">
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-number">{{ $totalProducts ?? 0 }}</div>
                <div class="stat-label">Products</div>
                <div class="stat-trend trend-neutral">
                    <i class="fas fa-plus"></i>
                    <span>5 new added</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="dashboard-card stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">{{ $pendingOrders ?? 0 }}</div>
                <div class="stat-label">Pending Orders</div>
                <div class="stat-trend trend-down">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Needs attention</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Revenue Chart -->
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header d-flex justify-content-between align-items-center">
                    <h5 class="chart-title">Revenue Overview</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            Last 30 Days
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                            <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                            <li><a class="dropdown-item" href="#">Last 90 Days</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="revenue-stats">
                    <div class="revenue-stat">
                        <div class="revenue-stat-label">This Month</div>
                        <div class="revenue-stat-value">PKR {{ number_format($monthlyRevenue ?? 0, 0) }}</div>
                        <div class="revenue-stat-change trend-up">
                            <i class="fas fa-arrow-up"></i> +15%
                        </div>
                    </div>
                    <div class="revenue-stat">
                        <div class="revenue-stat-label">Last Month</div>
                        <div class="revenue-stat-value">PKR {{ number_format($lastMonthRevenue ?? 0, 0) }}</div>
                        <div class="revenue-stat-change trend-neutral">Previous period</div>
                    </div>
                    <div class="revenue-stat">
                        <div class="revenue-stat-label">Average Order</div>
                        <div class="revenue-stat-value">PKR {{ number_format($averageOrderValue ?? 0, 0) }}</div>
                        <div class="revenue-stat-change trend-up">
                            <i class="fas fa-arrow-up"></i> +3%
                        </div>
                    </div>
                </div>
                
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Order Status Chart -->
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Order Status</h5>
                </div>
                <div class="chart-container">
                    <canvas id="orderStatusChart"></canvas>
                </div>
                <div class="px-3 pb-3">
                    @if(isset($orderStatusBreakdown) && count($orderStatusBreakdown) > 0)
                        @foreach($orderStatusBreakdown as $status => $count)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="status-badge status-{{ $status }}">{{ $status }}</span>
                            <strong class="text-dark">{{ $count }}</strong>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-3">
                            <small>No order data available</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row">
        <div class="col-12">
            <div class="orders-table">
                <div class="chart-header d-flex justify-content-between align-items-center">
                    <h5 class="chart-title">Recent Orders</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th class="d-none d-lg-table-cell">Source</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="d-none d-md-table-cell">Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($recentOrders) && $recentOrders->count() > 0)
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>
                                        <strong class="text-dark">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong>
                                    </td>
                                    <td>
                                        <div class="customer-info">
                                            <div class="fw-medium">{{ $order->first_name }} {{ $order->last_name }}</div>
                                            <small class="text-muted d-none d-sm-block">{{ $order->email }}</small>
                                        </div>
                                    </td>                    <td class="d-none d-lg-table-cell">
                        @if($order->order_source === 'deal')
                            <span style="color: #ED8936; font-size: 0.8rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem;">
                                <i class="fas fa-fire"></i>
                                Deal
                            </span>
                        @else
                            <span style="color: #8B7BA8; font-size: 0.8rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem;">
                                <i class="fas fa-shopping-bag"></i>
                                Regular
                            </span>
                        @endif
                    </td>
                                    <td>
                                        <strong class="text-dark">PKR {{ number_format($order->total, 0) }}</strong>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $order->status }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <div class="order-date">
                                            <div class="text-dark">{{ $order->created_at->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                        </div>
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
                            @else
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-shopping-cart"></i>
                                            </div>
                                            <h6 class="mb-2">No orders yet</h6>
                                            <p class="mb-0">Orders will appear here once customers start purchasing.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json(isset($revenueChartData['labels']) ? $revenueChartData['labels'] : []),
                datasets: [{
                    label: 'Revenue (PKR)',
                    data: @json(isset($revenueChartData['data']) ? $revenueChartData['data'] : []),
                    borderColor: '#8B7BA8',
                    backgroundColor: 'rgba(139, 123, 168, 0.08)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#8B7BA8',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(45, 55, 72, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#8B7BA8',
                        borderWidth: 1,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#718096'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(226, 232, 240, 0.5)'
                        },
                        ticks: {
                            color: '#718096',
                            callback: function(value) {
                                return 'PKR ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    // Order Status Chart
    const statusCtx = document.getElementById('orderStatusChart');
    if (statusCtx) {
        const statusData = @json(isset($orderStatusBreakdown) ? array_values($orderStatusBreakdown) : [0]);
        const statusLabels = @json(isset($orderStatusBreakdown) ? array_keys($orderStatusBreakdown) : ['No Data']);
        
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: [
                        '#8B7BA8',
                        '#A893C4', 
                        '#C4B5D8',
                        '#E9E3F0',
                        '#D1C4E1'
                    ],
                    borderWidth: 0,
                    hoverBorderWidth: 2,
                    hoverBorderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(45, 55, 72, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#8B7BA8',
                        borderWidth: 1,
                        cornerRadius: 8
                    }
                }
            }
        });
    }
});
</script>

@endsection