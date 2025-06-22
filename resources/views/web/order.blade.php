@extends('web.layout.checkout')
@section('content')
    <style>
        :root {
            --primary-color: #8D68AD;
            --secondary-color: #f8f0ff;
            --text-color: #333;
            --border-color: #ddd;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            background: #f9f9f9;
            color: var(--text-color);
        }

        /* Checkout Header Styles */
        .checkout-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 120px 0 30px;
            margin-bottom: 30px;
        }

        .checkout-image-wrapper {
            text-align: center;
            padding: 20px 0 !important;
        }

        .checkout-banner-image {
            max-width: 110px;
            transition: transform 0.3s ease;
            margin-top: 0 !important;
        }

        .checkout-banner-image:hover {
            transform: scale(1.02);
        }

        .checkout-title-overlay {
            margin-top: 15px !important;
        }

        .checkout-title-overlay h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Main Container */
        .order-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 40px;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 25px;
            align-items: start;
        }

        /* Form Styles */
        .order-form {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            height: fit-content;
        }

        .form-title {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 1.4rem;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }





        /* Cart Styles */
        .order-cart {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .cart-title {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 1.4rem;
        }

        .order-cart-item {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 20px;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .order-cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .item-details h4 {
            margin-bottom: 8px;
            color: var(--text-color);
        }

        .item-controls {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .item-controls button {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background: var(--secondary-color);
            color: var(--primary-color);
            transition: background 0.3s;
            font-size: 0.9rem;
        }

        .item-controls button:hover {
            background: var(--primary-color);
            color: white;
        }

        .item-controls span {
            min-width: 30px;
            text-align: center;
            font-weight: bold;
            color: var(--primary-color);
        }



        /* Responsive Design */
        @media (max-width: 992px) {
            .order-container {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 0 15px 30px;
            }
            
            .order-cart {
                position: relative;
                top: auto;
                order: -1;
                margin-bottom: 10px;
            }
            
            .order-form {
                order: 1;
            }
        }

        @media (max-width: 768px) {
            .checkout-header {
                padding: 100px 0 20px;
            }

            .checkout-title-overlay h1 {
                font-size: 2rem;
            }

            .order-container {
                padding: 10px;
            }

            .order-form,
            .order-cart {
                padding: 20px;
            }
            
            .order-cart-item {
                grid-template-columns: 80px 1fr auto;
                gap: 15px;
                text-align: left;
            }
            
            .item-controls {
                flex-direction: column;
                gap: 5px;
            }
            
            .item-controls button {
                padding: 4px 8px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .checkout-title-overlay h1 {
                font-size: 1.8rem;
            }
            
            .order-container {
                padding: 0 10px 20px;
                gap: 15px;
            }
            
            .order-cart-item {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 10px;
            }
            
            .item-controls {
                justify-content: center;
                flex-direction: row;
                gap: 8px;
            }
            
            .order-cart-item img {
                margin: 0 auto;
                width: 60px;
                height: 60px;
            }
            
            .order-form, .order-cart {
                padding: 15px;
            }
            
            .form-group {
                margin-bottom: 15px;
            }
        }

        .error-msg {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }

        /* Additional optimizations for better spacing */
        .order-cart-item:last-child {
            border-bottom: none;
        }

        .order-total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid var(--primary-color);
            text-align: right;
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        /* Order Totals */
        .order-totals {
            border-top: 2px solid #eee;
            padding-top: 20px;
            margin-top: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .total-row.final {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-color);
            border-top: 1px solid #eee;
            padding-top: 10px;
            margin-top: 10px;
        }

        /* Free Shipping Message */
        .free-shipping-message {
            background: linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%);
            border: 1px solid #28a745;
            border-radius: 8px;
            padding: 12px 16px;
            margin: 15px 0;
            color: #155724;
            font-weight: 500;
            text-align: center;
            animation: pulse 2s infinite;
        }

        .free-shipping-message i {
            margin-right: 8px;
            color: #28a745;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        /* Improved button styling */
        .btn-primary {
            background: var(--primary-color);
            color: white;
            padding: 14px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background: #7a5a96;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(141, 104, 173, 0.3);
        }

        /* Improved form controls */
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(141, 104, 173, 0.1);
        }
    </style>
</head>
<body>
<!-- start checkout-header-image -->
<section class="checkout-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex align-items-center">
                <div class="checkout-title-overlay">
                    <h1>{{ $checkoutBanner->title ?? 'Complete Your Order' }}</h1>
                    <p style="margin-top: 10px; font-size: 1.1rem; color: #666;">{{ $checkoutBanner->subtitle ?? 'You\'re one step away from beautiful, natural skincare!' }}</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="checkout-image-wrapper">
                    @if(isset($checkoutBanner) && $checkoutBanner->image)
                        <img src="{{ asset('storage/'.$checkoutBanner->image) }}" 
                             alt="Checkout Banner" 
                             class="checkout-banner-image">
                    @else
                        <img src="{{ asset('assets/images/checkout/joyful-woman-with-shopping-bags.png') }}" 
                             alt="Joyful Woman with Shopping Bags" 
                             class="checkout-banner-image">
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Main Order Container -->
    <div class="order-container">
        <!-- Customer Information Form (Left side on desktop, first on mobile) -->
        <section class="order-form">
            <h2 class="form-title">Customer Information</h2>
            <form id="orderForm" method="POST" action="{{ route('web.orders.store') }}">
                @csrf
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="address">Street Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="postalCode">Postal Code</label>
                    <input type="text" class="form-control" id="postalCode" name="postalCode" required>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" required>
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <select class="form-control" id="country" name="country" required>
                        <option value="">Select Country</option>
                        <option value="Pakistan" selected>Pakistan</option>
                        <option value="India">India</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="USA">United States</option>
                        <option value="Canada">Canada</option>
                        <option value="UK">United Kingdom</option>
                        <option value="UAE">United Arab Emirates</option>
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="Australia">Australia</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <!-- Hidden inputs to send order details -->
                <input type="hidden" name="order_items" id="orderItemsInput">
                <input type="hidden" name="total" id="orderTotalInput">

                <button type="submit" class="btn-primary">
                    <i class="fas fa-shopping-cart"></i> Place Order
                </button>
            </form>
        </section>

        <!-- Order Summary (Right side on desktop, second on mobile) -->
        <section class="order-cart">
            <h2 class="cart-title">Order Summary</h2>
            <div id="orderItems">
                <!-- Cart items will be rendered here -->
            </div>
            
            <!-- Free Shipping Message -->
            <div id="freeShippingMessage" class="free-shipping-message" style="display: none;">
                <!-- Message will be populated by JavaScript -->
            </div>
            
            <div class="order-totals">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span id="subtotal">PKR 0</span>
                </div>
                <div class="total-row" id="shippingRow">
                    <span>Shipping:</span>
                    <span id="shipping">PKR {{ number_format($shippingCharges ?? 150, 0) }}</span>
                </div>
                <div class="total-row" id="freeShippingRow" style="display: none;">
                    <span>Shipping:</span>
                    <span style="color: #28a745; font-weight: bold;">FREE</span>
                </div>
                <div class="total-row final">
                    <span>Total:</span>
                    <span id="orderTotal">PKR 0</span>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cart = [];
            
            // Load cart from localStorage
            function loadCart() {
                const savedCart = localStorage.getItem('ts-cart');
                if (savedCart) {
                    try {
                        cart = JSON.parse(savedCart);
                        if (!Array.isArray(cart)) cart = [];
                    } catch (e) {
                        cart = [];
                    }
                }
            }

            function saveCart() {
                localStorage.setItem('ts-cart', JSON.stringify(cart));
            }

            function renderCart() {
                const cartContainer = document.getElementById('orderItems');
                const orderForm = document.getElementById('orderForm');
                
                if (cart.length === 0) {
                    cartContainer.innerHTML = '<div class="error-msg">Your cart is empty. Please add items to your cart first.</div>';
                    orderForm.style.display = 'none';
                    updateTotals();
                    return;
                }
                
                orderForm.style.display = 'block';
                cartContainer.innerHTML = '';
                
                cart.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'order-cart-item';
                    itemDiv.innerHTML = `
                        <img src="${item.image || '/logo.png'}" alt="${item.name}" onerror="this.src='/logo.png'">
                        <div class="item-details">
                            <h4>${item.name}</h4>
                            <p>PKR ${parseFloat(item.price).toLocaleString()} x ${item.quantity}</p>
                            <p style="color: var(--primary-color); font-weight: 600;">PKR ${(parseFloat(item.price) * item.quantity).toLocaleString()}</p>
                        </div>
                        <div class="item-controls">
                            <button type="button" onclick="updateQuantity(${item.id}, ${item.quantity - 1})">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span style="padding: 0 10px; font-weight: bold;">${item.quantity}</span>
                            <button type="button" onclick="updateQuantity(${item.id}, ${item.quantity + 1})">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button type="button" onclick="removeItem(${item.id})" style="background: #dc3545; color: white;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                    cartContainer.appendChild(itemDiv);
                });
                
                updateTotals();
            }

            function updateTotals() {
                const subtotal = cart.reduce((total, item) => {
                    const itemPrice = parseFloat(item.price);
                    const itemQuantity = parseInt(item.quantity);
                    return total + (itemPrice * itemQuantity);
                }, 0);
                
                // Round subtotal to whole numbers (no decimal points)
                const roundedSubtotal = Math.round(subtotal);
                
                const shippingCharges = {{ $shippingCharges ?? 150 }};
                const freeShippingThreshold = {{ $freeShippingThreshold ?? 2000 }};
                
                // Calculate shipping
                let shipping = 0;
                let isFreeShipping = false;
                
                if (roundedSubtotal >= freeShippingThreshold) {
                    shipping = 0;
                    isFreeShipping = true;
                } else if (roundedSubtotal > 0) {
                    shipping = shippingCharges;
                }
                
                // Round shipping to whole numbers
                shipping = Math.round(shipping);
                
                // Calculate and round final total
                const total = Math.round(roundedSubtotal + shipping);
                
                // Update display without decimal points
                document.getElementById('subtotal').textContent = `PKR ${roundedSubtotal.toLocaleString()}`;
                document.getElementById('orderTotal').textContent = `PKR ${total.toLocaleString()}`;
                
                // Show/hide shipping rows
                const shippingRow = document.getElementById('shippingRow');
                const freeShippingRow = document.getElementById('freeShippingRow');
                
                if (isFreeShipping) {
                    shippingRow.style.display = 'none';
                    freeShippingRow.style.display = 'flex';
                } else {
                    shippingRow.style.display = 'flex';
                    freeShippingRow.style.display = 'none';
                    document.getElementById('shipping').textContent = `PKR ${shipping.toLocaleString()}`;
                }
                
                // Show free shipping message if close to threshold
                const freeShippingMessage = document.getElementById('freeShippingMessage');
                if (freeShippingMessage) {
                    if (roundedSubtotal > 0 && roundedSubtotal < freeShippingThreshold) {
                        const remaining = freeShippingThreshold - roundedSubtotal;
                        freeShippingMessage.innerHTML = `<i class="fas fa-gift"></i> Add PKR ${remaining.toLocaleString()} more to get FREE shipping!`;
                        freeShippingMessage.style.display = 'block';
                    } else {
                        freeShippingMessage.style.display = 'none';
                    }
                }
                
                // Update hidden inputs with rounded values (no decimals)
                if (document.getElementById('orderItemsInput')) {
                    document.getElementById('orderItemsInput').value = JSON.stringify(cart);
                }
                if (document.getElementById('orderTotalInput')) {
                    document.getElementById('orderTotalInput').value = total.toString();
                }
            }

            window.updateQuantity = function(productId, newQuantity) {
                if (newQuantity < 1) {
                    removeItem(productId);
                    return;
                }
                
                const item = cart.find(item => item.id == productId);
                if (item) {
                    item.quantity = parseInt(newQuantity);
                    saveCart();
                    renderCart();
                }
            };

            window.removeItem = function(productId) {
                cart = cart.filter(item => item.id != productId);
                saveCart();
                renderCart();
            };

            document.getElementById('orderForm').addEventListener('submit', function(e) {
                if (cart.length === 0) {
                    e.preventDefault();
                    alert('Your cart is empty. Please add items before placing an order.');
                    return;
                }
                
                // Calculate totals with proper rounding before submission
                let subtotal = 0;
                cart.forEach(item => {
                    const itemPrice = parseFloat(item.price);
                    const itemQuantity = parseInt(item.quantity);
                    subtotal += itemPrice * itemQuantity;
                });
                
                // Round subtotal to whole numbers (no decimal points)
                subtotal = Math.round(subtotal);
                
                const shippingCharges = {{ $shippingCharges ?? 150 }};
                const freeShippingThreshold = {{ $freeShippingThreshold ?? 5000 }};
                
                let shipping = 0;
                if (subtotal >= freeShippingThreshold) {
                    shipping = 0;
                } else {
                    shipping = shippingCharges;
                }
                
                // Round shipping to whole numbers (no decimal points)
                shipping = Math.round(shipping);
                
                // Calculate and round final total to whole numbers
                const total = Math.round(subtotal + shipping);
                
                console.log('Order submission debug:', {
                    subtotal: subtotal,
                    shipping: shipping,
                    total: total,
                    cart: cart
                });
                
                // Update hidden inputs with rounded values (no decimals)
                document.getElementById('orderItemsInput').value = JSON.stringify(cart);
                document.getElementById('orderTotalInput').value = total.toString();
            });

            // Initialize
            loadCart();
            renderCart();
        });
    </script>

@endsection