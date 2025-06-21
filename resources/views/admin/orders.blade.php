@extends('admin.layout.app')
@section('content')

<div class="container-fluid mt-xl-50 mt-sm-30 mt-15">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orders</li>
        </ol>
    </nav>
    <!-- Page Header -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title">
            <span class="pg-title-icon"><i class="fa fa-shopping-cart"></i></span>
            Orders
        </h4>
    </div>

    <!-- Content Section -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <!-- Add Button -->
                <div class="row mb-3">
                    <div class="col-sm">
                        <button id="openOrderModal" class="btn custom-btn-primary" data-bs-toggle="modal" data-bs-target="#viewOrderModal">
                            <i class="fa fa-plus me-2"></i>Create New Order
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <table id="ordersTable" class="table table-hover w-100 display pb-30">
                                <thead>
                                    <tr>
                                        <th style="padding:inherit;">Order ID</th>
                                        <th style="padding:inherit;">Customer</th>
                                        <th style="padding:inherit;">Contact</th>
                                        <th style="padding:inherit;">Location</th>
                                        <th style="padding:inherit;">Items</th>
                                        <th style="padding:inherit;">Total Amount</th>
                                        <th style="padding:inherit;">Order Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                        <td>
                                            <div>{{ $order->email }}</div>
                                            <small class="text-muted">{{ $order->phone }}</small>
                                        </td>
                                        <td>
                                            <div>{{ $order->city }}</div>
                                            <small class="text-muted">{{ $order->country }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $items = json_decode($order->order_items, true) ?: [];
                                                $itemCount = collect($items)->sum('quantity');
                                            @endphp
                                            <span class="badge badge-soft-info">{{ $itemCount }} items</span>
                                        </td>
                                        <td>
                                            <span class="text-success font-weight-bold">${{ number_format($order->total, 0) }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</td>
                                        <td>
                                            <button type="button" 
                                                    class="action-btn view-order" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewOrderModal"
                                                    data-order="{{ json_encode($order) }}">
                                                <i class="fa fa-eye text-primary"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- View Order Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Customer Information</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="35%"><strong>Name:</strong></td>
                                <td id="customer-name"></td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td id="customer-email"></td>
                            </tr>
                            <tr>
                                <td><strong>Phone:</strong></td>
                                <td id="customer-phone"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Shipping Information</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="35%"><strong>City:</strong></td>
                                <td id="shipping-city"></td>
                            </tr>
                            <tr>
                                <td><strong>Country:</strong></td>
                                <td id="shipping-country"></td>
                            </tr>
                            <tr>
                                <td><strong>Postal Code:</strong></td>
                                <td id="shipping-postal"></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <h6 class="text-muted mb-3">Order Items</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody id="order-items">
                            <!-- Items will be inserted here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right"><strong>Total Amount:</strong></td>
                                <td class="text-right" id="order-total"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
@media (max-width: 576px) {
    .pagination {
        margin-left: 70px;
    }
}

.action-btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    background: transparent;
    border: 1px solid #dee2e6;
    margin: 0 3px;
    color: inherit;
    cursor: pointer;
}

.action-btn:hover {
    background-color: #f8f9fa;
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 1rem;
}

.modal-body {
    padding: 1rem;
}

.modal-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
    padding: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.table-wrap {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    margin: 0 -1px;
    padding: 0 1px;
}

.table-wrap::-webkit-scrollbar {
    height: 6px;
}

.table-wrap::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.table-wrap::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.gap-2 {
    gap: 0.5rem;
}

.d-flex {
    display: flex;
}

.custom-btn-primary {
    background-color: #F53B31 !important;
    border-color: #F53B31 !important;
    color: white !important;
    transition: all 0.3s ease;
}

.custom-btn-primary:hover {
    background-color: #d62f26 !important;
    border-color: #d62f26 !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(245, 59, 49, 0.2);
}

@media (max-width: 768px) {
    .col-sm {
        display: flex;
        justify-content: center;
    }

    .custom-btn-primary {
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 140px;
    }

    .container-fluid {
        padding: 10px;
    }

    .dataTables_length,
    .dataTables_filter {
        width: 100%;
        text-align: left;
    }

    .dataTables_filter input {
        width: 100%;
        margin-left: 0 !important;
    }
}

@media (max-width: 576px) {
    .breadcrumb {
        padding: 0.5rem 0;
        font-size: 0.875rem;
    }

    .hk-sec-wrapper {
        padding: 1rem;
    }

    .table td,
    .table th {
        padding: 0.4rem;
        font-size: 0.875rem;
    }

    .dataTables_filter {
        /* text-align: center !important; */
    }
    
    .dataTables_filter label,
    .dataTables_filter input {
        margin: 0 auto !important;
    }
}
</style>

<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#ordersTable').DataTable({
        ordering: true, // Enable ordering
        responsive: false,  // Disable responsive behavior
        scrollX: true,     // Enable horizontal scrolling
        autoWidth: true,
        stripe: false,
        stateSave: false,
        bDestroy: true,
        pageLength: 10,
        language: {
            search: "",
            searchPlaceholder: "Search Orders...",
            lengthMenu: "_MENU_ per page"
        },
        columnDefs: [
            {
                targets: '_all',
                className: 'no-hover'
            }
        ],
        dom: "<'row'<'col-sm-12'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        initComplete: function() {
            $(window).on('resize', function() {
                table.columns.adjust();
            });
        }
    });

    // Touch scroll handling for mobile
    if ('ontouchstart' in window) {
        initializeTouchScroll();
    }

    // Handle View Order Details
    $(document).on('click', '.view-order', function() {
        const orderData = $(this).data('order');
        
        // Update Customer Information
        $('#customer-name').text(`${orderData.first_name} ${orderData.last_name}`);
        $('#customer-email').text(orderData.email);
        $('#customer-phone').text(orderData.phone);
        
        // Update Shipping Information
        $('#shipping-city').text(orderData.city);
        $('#shipping-country').text(orderData.country);
        $('#shipping-postal').text(orderData.postal_code);
        
        // Parse and display order items
        const items = JSON.parse(orderData.order_items || '[]');
        let itemsHtml = '';
        
        items.forEach(item => {
            const itemTotal = Math.round(item.price * item.quantity);
            itemsHtml += `
                <tr>
                    <td>${item.name}</td>
                    <td>
                        <img src="${item.image}" alt="${item.name}" class="img-thumbnail" style="height: 50px;">
                    </td>
                    <td>$${Math.round(item.price)}</td>
                    <td>${item.quantity}</td>
                    <td class="text-right">$${itemTotal}</td>
                </tr>
            `;
        });
        
        $('#order-items').html(itemsHtml);
        $('#order-total').text(`$${Math.round(parseFloat(orderData.total))}`);
        
        $('#viewOrderModal').modal('show');
    });

    // Modal reset handler
    $('#viewOrderModal').on('hidden.bs.modal', function() {
        $('#customer-name').text('');
        $('#customer-email').text('');
        $('#customer-phone').text('');
        $('#shipping-city').text('');
        $('#shipping-country').text('');
        $('#shipping-postal').text('');
        $('#order-items').html('');
        $('#order-total').text('');
    });

    // Open modal if 'openModal' parameter is present
    @if(request()->has('openModal'))
        $('#openOrderModal').trigger('click');
        const url = new URL(window.location.href);
        url.searchParams.delete('openModal');
        window.history.replaceState({}, '', url.toString());
    @endif
});

// Initialize touch scroll functionality
function initializeTouchScroll() {
    $('.table-wrap').css('cursor', 'grab');

    let isDown = false;
    let startX;
    let scrollLeft;

    $('.table-wrap')
        .on('touchstart mousedown', function(e) {
            isDown = true;
            $(this).css('cursor', 'grabbing');
            startX = (e.type === 'mousedown' ? e.pageX : e.touches[0].pageX) - $(this).offset().left;
            scrollLeft = $(this).scrollLeft();
        })
        .on('touchend mouseup', function() {
            isDown = false;
            $(this).css('cursor', 'grab');
        })
        .on('touchmove mousemove', function(e) {
            if (!isDown) return;
            e.preventDefault();
            const x = (e.type === 'mousemove' ? e.pageX : e.touches[0].pageX) - $(this).offset().left;
            const walk = (x - startX);
            $(this).scrollLeft(scrollLeft - walk);
        });
}
</script>
@endsection