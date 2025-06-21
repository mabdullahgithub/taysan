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
            max-width: 350px;
            transition: transform 0.3s ease;
            margin-top: 0 !important;
        }

        .checkout-banner-image:hover {
            transform: scale(1.02);
        }

        .checkout-title-overlay {
            margin-top: 15px !important;
        }

        .checkout-title-overlay h2 {
            color: #8D68AD;
            font-size: 2.2rem;
            font-weight: 600;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .checkout-title-overlay p {
            color: #666;
            font-size: 1rem;
            margin: 8px 0 0;
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
        }

        .item-controls button {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background: var(--secondary-color);
            color: var(--primary-color);
            transition: background 0.3s;
        }

        .item-controls button:hover {
            background: var(--primary-color);
            color: white;
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
                padding: 110px 0 20px;
                margin-bottom: 20px;
            }

            .checkout-image-wrapper {
                padding: 15px 0 !important;
            }

            .checkout-banner-image {
                max-width: 280px;
            }

            .checkout-title-overlay h2 {
                font-size: 1.8rem;
            }

            .checkout-title-overlay p {
                font-size: 0.95rem;
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
            
            .order-form, .order-cart {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .checkout-header {
                padding: 105px 0 15px;
                margin-bottom: 15px;
            }

            .checkout-image-wrapper {
                padding: 10px 0 !important;
            }

            .checkout-banner-image {
                max-width: 240px;
            }

            .checkout-title-overlay h2 {
                font-size: 1.5rem;
            }

            .checkout-title-overlay p {
                font-size: 0.9rem;
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
            <div class="col-12">
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
                    <div class="checkout-title-overlay">
                        <h2>{{ $checkoutBanner->title ?? 'Complete Your Order Below' }}</h2>
                        <p>{{ $checkoutBanner->subtitle ?? 'You\'re one step away from beautiful, natural skincare!' }}</p>
                    </div>
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
                        <option value="USA">United States</option>
                        <option value="Canada">Canada</option>
                        <option value="UK">United Kingdom</option>
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
            <div class="order-total">
                Total: <span id="orderTotal">$0.00</span>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function loadCart() {
                const cart = localStorage.getItem('ts-cart');
                return cart ? JSON.parse(cart) : [];
            }

            function saveCart(cart) {
                localStorage.setItem('ts-cart', JSON.stringify(cart));
            }

            function renderCart() {
                const cart = loadCart();
                const orderItems = document.getElementById('orderItems');
                const orderTotalEl = document.getElementById('orderTotal');
                const orderForm = document.getElementById('orderForm');
                
                if (cart.length === 0) {
                    orderItems.innerHTML = '<div class="error-msg">Your cart is empty. Please add items to your cart first.</div>';
                    orderTotalEl.textContent = '$0.00';
                    orderForm.style.display = 'none';
                    return;
                }
                
                orderItems.innerHTML = '';
                let total = 0;
                
                cart.forEach(item => {
                    total += item.price * item.quantity;
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'order-cart-item';
                    itemDiv.innerHTML = `
                        <img src="${item.image || '/api/placeholder/80/80'}" alt="${item.name}">
                        <div class="item-details">
                            <h4>${item.name}</h4>
                            <p>$${item.price.toFixed(2)} x ${item.quantity}</p>
                        </div>
                        <div class="item-controls">
                            <button data-action="decrease" data-id="${item.id}">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button data-action="increase" data-id="${item.id}">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button data-action="remove" data-id="${item.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                    orderItems.appendChild(itemDiv);
                });
                
                orderTotalEl.textContent = '$' + total.toFixed(2);

                // Assign hidden inputs for backend submission
                document.getElementById('orderItemsInput').value = JSON.stringify(cart);
                document.getElementById('orderTotalInput').value = total.toFixed(2);
            }

            function updateCartItem(productId, action) {
                let cart = loadCart();
                cart = cart.map(item => {
                    if (item.id == productId) {
                        if (action === 'increase' && item.quantity < 99) {
                            item.quantity++;
                        } else if (action === 'decrease' && item.quantity > 1) {
                            item.quantity--;
                        }
                    }
                    return item;
                }).filter(item => item.quantity > 0);
                saveCart(cart);
                renderCart();
            }

            function removeCartItem(productId) {
                let cart = loadCart();
                cart = cart.filter(item => item.id != productId);
                saveCart(cart);
                renderCart();
            }

            document.getElementById('orderItems').addEventListener('click', function(e) {
                if (e.target.closest('button')) {
                    const button = e.target.closest('button');
                    const action = button.getAttribute('data-action');
                    const productId = button.getAttribute('data-id');
                    
                    if (action === 'increase' || action === 'decrease') {
                        updateCartItem(productId, action);
                    } else if (action === 'remove') {
                        removeCartItem(productId);
                    }
                }
            });

            document.getElementById('orderForm').addEventListener('submit', function() {
                // Just let the form submit normally
            });

            renderCart();
        });
    </script>

@endsection