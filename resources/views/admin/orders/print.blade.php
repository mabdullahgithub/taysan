<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #{{ $order->id }} - Print Details</title>
    <style>
        :root {
            --primary-color: #8B7BA8;
            --primary-light: #A893C4;
            --primary-dark: #6B5B7D;
            --text-dark: #2D3748;
            --text-medium: #4A5568;
            --text-light: #718096;
            --border-light: #E2E8F0;
            --background: #FFFFFF;
            --success: #48BB78;
            --warning: #ED8936;
            --danger: #F56565;
            --info: #4299E1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            line-height: 1.4;
            color: var(--text-dark);
            background: var(--background);
            padding: 1rem;
            font-size: 12px;
        }

        .print-container {
            max-width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            border: 1px solid var(--border-light);
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 0;
        }

        .print-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            padding: 1rem;
            text-align: center;
        }

        .company-name {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .company-tagline {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .order-header {
            padding: 1rem;
            border-bottom: 2px solid var(--border-light);
        }

        .order-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.75rem;
        }

        .order-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .meta-section h4 {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-medium);
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .meta-info {
            background: #F7F9FC;
            padding: 0.75rem;
            border-radius: 6px;
            border-left: 3px solid var(--primary-color);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.25rem;
            font-size: 0.75rem;
        }

        .info-row:last-child {
            margin-bottom: 0;
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
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 15px;
            font-size: 0.65rem;
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

        .customer-section {
            padding: 1rem;
            background: #FAFBFC;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .customer-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .customer-card {
            background: white;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid var(--border-light);
        }

        .card-title {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .address-text {
            line-height: 1.3;
            color: var(--text-medium);
            font-size: 0.75rem;
        }

        .items-section {
            padding: 1rem;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            font-size: 0.7rem;
        }

        .items-table th {
            background: var(--primary-color);
            color: white;
            padding: 0.5rem 0.25rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.65rem;
        }

        .items-table td {
            padding: 0.5rem 0.25rem;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
        }

        .items-table tr:nth-child(even) {
            background: #FAFBFC;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .product-image {
            width: 30px;
            height: 30px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid var(--border-light);
        }

        .product-image-placeholder {
            width: 30px;
            height: 30px;
            background: #F0F0F0;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
            font-size: 0.8rem;
        }

        .product-details h5 {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.1rem;
            line-height: 1.2;
        }

        .product-id {
            font-size: 0.6rem;
            color: var(--text-light);
        }

        .price-cell {
            font-weight: 600;
            color: var(--success);
            font-size: 0.7rem;
        }

        .total-section {
            background: #F7F9FC;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid var(--primary-color);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.25rem;
            padding: 0.1rem 0;
            font-size: 0.75rem;
        }

        .total-row:last-child {
            margin-bottom: 0;
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
            border-top: 1px solid var(--primary-color);
            padding-top: 0.5rem;
            margin-top: 0.5rem;
        }

        .grand-total .total-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .grand-total .total-value {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .print-footer {
            text-align: center;
            padding: 0.75rem;
            border-top: 1px solid var(--border-light);
            color: var(--text-light);
            font-size: 0.65rem;
        }

        .print-buttons {
            text-align: center;
            margin-bottom: 2rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            margin: 0 0.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: #6C757D;
            color: white;
        }

        .btn-secondary:hover {
            background: #5A6268;
        }

        /* Print Styles - Optimized for A4 */
        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }

            body {
                padding: 0;
                background: white;
                font-size: 10px;
                line-height: 1.3;
            }

            .print-container {
                max-width: none;
                width: 100%;
                border: none;
                box-shadow: none;
                padding: 0;
                margin: 0;
            }

            .print-buttons {
                display: none;
            }

            .print-header {
                padding: 8mm 0;
                margin-bottom: 2mm;
            }

            .company-name {
                font-size: 18px;
                margin-bottom: 2px;
            }

            .company-tagline {
                font-size: 10px;
            }

            .order-header {
                padding: 3mm 0;
                margin-bottom: 2mm;
            }

            .order-title {
                font-size: 14px;
                margin-bottom: 2mm;
            }

            .order-meta {
                gap: 3mm;
            }

            .meta-section h4 {
                font-size: 9px;
                margin-bottom: 1mm;
            }

            .meta-info {
                padding: 2mm;
            }

            .customer-section {
                padding: 3mm 0;
                margin-bottom: 2mm;
            }

            .section-title {
                font-size: 12px;
                margin-bottom: 2mm;
            }

            .customer-grid {
                gap: 3mm;
            }

            .customer-card {
                padding: 2mm;
            }

            .card-title {
                font-size: 9px;
                margin-bottom: 1mm;
            }

            .items-section {
                padding: 3mm 0;
            }

            .items-table {
                font-size: 8px;
                margin-bottom: 2mm;
            }

            .items-table th,
            .items-table td {
                padding: 1mm 1mm;
            }

            .items-table th {
                font-size: 8px;
            }

            .product-image,
            .product-image-placeholder {
                width: 20px;
                height: 20px;
            }

            .product-details h5 {
                font-size: 8px;
                margin-bottom: 0;
                line-height: 1.1;
            }

            .product-id {
                font-size: 7px;
            }

            .price-cell {
                font-size: 8px;
            }

            .total-section {
                padding: 2mm;
                margin-top: 2mm;
            }

            .total-row {
                font-size: 9px;
                margin-bottom: 1mm;
            }

            .grand-total .total-label {
                font-size: 10px;
            }

            .grand-total .total-value {
                font-size: 11px;
            }

            .print-footer {
                padding: 2mm 0;
                font-size: 7px;
                margin-top: 2mm;
            }

            .info-row {
                font-size: 8px;
                margin-bottom: 1mm;
            }

            .status-badge {
                font-size: 7px;
                padding: 1mm 2mm;
            }

            .address-text {
                font-size: 8px;
                line-height: 1.2;
            }

            /* Ensure no page breaks in critical sections */
            .order-header,
            .customer-section,
            .total-section {
                page-break-inside: avoid;
            }

            /* Allow breaks between order items if needed */
            .items-table tbody tr {
                page-break-inside: avoid;
            }

            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <div class="print-buttons">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Print Order
        </button>
        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Order
        </a>
    </div>

    <div class="print-container">
        <!-- Company Header -->
        <div class="print-header">
            <div class="company-name">TAYSAN</div>
            <div class="company-tagline">Premium Fashion & Lifestyle</div>
        </div>

        <!-- Order Header -->
        <div class="order-header">
            <h1 class="order-title">Order Details #{{ $order->id }}</h1>
            
            <div class="order-meta">
                <div class="meta-section">
                    <h4>Order Information</h4>
                    <div class="meta-info">
                        <div class="info-row">
                            <span class="info-label">Order Date:</span>
                            <span class="info-value">{{ $order->created_at->format('F j, Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Order Time:</span>
                            <span class="info-value">{{ $order->created_at->format('g:i A') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Status:</span>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="meta-section">
                    <h4>Payment Summary</h4>
                    <div class="meta-info">
                        <div class="info-row">
                            <span class="info-label">Subtotal:</span>
                            <span class="info-value">PKR {{ number_format($order->subtotal ?? 0, 0) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Shipping:</span>
                            <span class="info-value">
                                @if($order->shipping_cost == 0)
                                    <span style="color: var(--success);">FREE</span>
                                @else
                                    PKR {{ number_format($order->shipping_cost, 0) }}
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Total:</span>
                            <span class="info-value" style="color: var(--primary-color); font-weight: 700;">
                                PKR {{ number_format($order->total, 0) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="customer-section">
            <h2 class="section-title">
                <i class="fas fa-user"></i>
                Customer Information
            </h2>
            
            <div class="customer-grid">
                <div class="customer-card">
                    <h3 class="card-title">
                        <i class="fas fa-id-card"></i>
                        Personal Details
                    </h3>
                    <div class="info-row">
                        <span class="info-label">Full Name:</span>
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
                </div>

                <div class="customer-card">
                    <h3 class="card-title">
                        <i class="fas fa-map-marker-alt"></i>
                        Shipping Address
                    </h3>
                    <div class="address-text">
                        @if($order->address)
                            <strong>{{ $order->address }}</strong><br>
                        @endif
                        {{ $order->city }}
                        @if($order->postal_code)
                            - {{ $order->postal_code }}
                        @endif
                        <br>
                        {{ $order->country }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="items-section">
            <h2 class="section-title">
                <i class="fas fa-shopping-bag"></i>
                Order Items ({{ $order->orderItems->count() }} items)
            </h2>
            
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>
                            <div class="product-info">
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

                                <div class="product-details">
                                    <h5>{{ $item->product_name }}</h5>
                                    <div class="product-id">ID: #{{ $item->product_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="price-cell">PKR {{ number_format($item->product_price, 0) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="price-cell">PKR {{ number_format($item->subtotal, 0) }}</td>
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
                    <span class="total-label">Shipping Cost:</span>
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

        <!-- Footer -->
        <div class="print-footer">
            <p>Thank you for your business! For any questions regarding this order, please contact us.</p>
            <p>Generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>
        </div>
    </div>

    <script>
        // Auto-focus print dialog when page loads
        window.addEventListener('load', function() {
            // Add a small delay to ensure page is fully rendered
            setTimeout(() => {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('auto_print') === 'true') {
                    window.print();
                }
            }, 500);
        });
    </script>
</body>
</html>
