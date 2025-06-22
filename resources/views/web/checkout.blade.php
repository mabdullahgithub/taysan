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
            font-f                    <!-- Free Shipping Message -->
                    <div id="freeShippingMessage" class="free-shipping-message" style="display: none;">
                        <!-- Message will be populated by JavaScript -->
                    </div>y: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
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

        .checkout-title-overlay h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Main Container */
        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 40px;
            align-items: start;
        }

        /* Form Styles */
        .checkout-form {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--text-color);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(141, 104, 173, 0.1);
        }

        /* Order Summary Styles */
        .order-summary {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            position: sticky;
            top: 20px;
        }

        .order-summary h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .cart-items {
            margin-bottom: 20px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .item-price {
            color: var(--primary-color);
            font-weight: 500;
        }

        .item-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 15px;
        }

        .quantity-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: #7a5a96;
            transform: scale(1.1);
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 5px;
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

        /* Submit Button */
        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-color) 0%, #b794c4 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
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

        /* Deal Badge */
        .deal-badge {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 10px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }

        /* Empty Cart */
        .empty-cart {
            text-align: center;
            color: #666;
            padding: 40px 20px;
        }

        .empty-cart i {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 15px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .checkout-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .checkout-header {
                padding: 100px 0 20px;
            }

            .checkout-title-overlay h1 {
                font-size: 2rem;
            }

            .checkout-container {
                padding: 10px;
            }

            .checkout-form,
            .order-summary {
                padding: 20px;
            }
        }
    </style>

    <!-- Checkout Header -->
    <div class="checkout-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex align-items-center">
                    <div class="checkout-title-overlay">
                        <h1>Secure Checkout</h1>
                        <p style="margin-top: 10px; font-size: 1.1rem; color: #666;">Complete your order safely and securely</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="checkout-image-wrapper">
                        <img src="{{ asset('logo.png') }}" alt="Taysan Beauty" class="checkout-banner-image">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Checkout Content -->
    <div class="checkout-container">
        <form action="{{ route('web.orders.store') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="checkout-grid">
                <!-- Checkout Form -->
                <div class="checkout-form">
                    <!-- Customer Information -->
                    <div class="form-section">
                        <h3><i class="fas fa-user"></i> Customer Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name *</label>
                                <input type="text" id="firstName" name="firstName" class="form-control" required value="{{ old('firstName') }}">
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name *</label>
                                <input type="text" id="lastName" name="lastName" class="form-control" required value="{{ old('lastName') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required value="{{ old('phone') }}">
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="form-section">
                        <h3><i class="fas fa-truck"></i> Shipping Information</h3>
                        <div class="form-group">
                            <label for="address">Address (Optional)</label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="Street address, apartment, suite, etc." value="{{ old('address') }}">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">City *</label>
                                <input type="text" id="city" name="city" class="form-control" required value="{{ old('city') }}">
                            </div>
                            <div class="form-group">
                                <label for="postalCode">Postal Code *</label>
                                <input type="text" id="postalCode" name="postalCode" class="form-control" required value="{{ old('postalCode') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="country">Country *</label>
                            <select id="country" name="country" class="form-control" required>
                                <option value="">Select Country</option>
                                <option value="Pakistan" {{ old('country') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                                <option value="Bangladesh" {{ old('country') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                                <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="order-summary">
                    <h3><i class="fas fa-shopping-cart"></i> Order Summary</h3>
                    
                    <div class="cart-items" id="cartItems">
                        <!-- Cart items will be loaded here -->
                    </div>

                    <!-- Free Shipping Message -->
                    <div id="freeShippingMessage" class="free-shipping-message" style="display: none; margin: 1rem 0; padding: 0.75rem 1rem; background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border: 1px solid #2196f3; border-radius: 8px; color: #1565c0; font-weight: 500;">
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
                            <span id="total">PKR 0</span>
                        </div>
                    </div>

                    <input type="hidden" name="order_items" id="orderItems">
                    <input type="hidden" name="total" id="totalInput">

                    <button type="submit" class="submit-btn" id="submitBtn">
                        <i class="fas fa-lock"></i> Place Order Securely
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cart = [];
            
            // Check if there's a prefilled product (from deal)
            @if(isset($prefilledProduct))
                const prefilledProduct = {
                    id: {{ $prefilledProduct->id }},
                    name: "{{ $prefilledProduct->name }}",
                    price: {{ $dealPrice ?? $prefilledProduct->price }},
                    image: "{{ asset('storage/' . $prefilledProduct->image) }}",
                    quantity: 1,
                    isDeal: {{ isset($dealPrice) ? 'true' : 'false' }}
                };
                cart = [prefilledProduct];
                
                // Clear any existing cart since this is a direct product purchase
                localStorage.removeItem('cart');
            @else
                // Load cart from localStorage for regular checkout
                cart = JSON.parse(localStorage.getItem('cart')) || [];
            @endif
            
            function renderCart() {
                const cartItemsContainer = document.getElementById('cartItems');
                
                if (cart.length === 0) {
                    cartItemsContainer.innerHTML = `
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Your cart is empty</p>
                            <a href="/shop" style="color: var(--primary-color); text-decoration: none;">Continue Shopping</a>
                        </div>
                    `;
                    updateTotals();
                    return;
                }
                
                cartItemsContainer.innerHTML = cart.map(item => `
                    <div class="cart-item" data-id="${item.id}">
                        <img src="${item.image}" alt="${item.name}" class="item-image" onerror="this.src='/logo.png'">
                        <div class="item-details">
                            <div class="item-name">
                                ${item.name}
                                ${item.isDeal ? '<span class="deal-badge">DEAL</span>' : ''}
                            </div>
                            <div class="item-price">PKR ${parseFloat(item.price).toLocaleString()}</div>
                        </div>
                        <div class="item-quantity">
                            <button type="button" class="quantity-btn" onclick="updateQuantity(${item.id}, ${item.quantity - 1})">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" value="${item.quantity}" class="quantity-input" min="1" 
                                   onchange="updateQuantity(${item.id}, this.value)">
                            <button type="button" class="quantity-btn" onclick="updateQuantity(${item.id}, ${item.quantity + 1})">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                `).join('');
                
                updateTotals();
            }
            
            window.updateQuantity = function(productId, newQuantity) {
                newQuantity = parseInt(newQuantity);
                if (newQuantity < 1) {
                    // Remove item if quantity is 0
                    cart = cart.filter(item => item.id != productId);
                } else {
                    // Update quantity
                    const item = cart.find(item => item.id == productId);
                    if (item) {
                        item.quantity = newQuantity;
                    }
                }
                renderCart();
            };
            
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
                
                // Round shipping to whole numbers (no decimal points)
                shipping = Math.round(shipping);
                
                // Calculate and round final total to whole numbers
                const total = Math.round(roundedSubtotal + shipping);
                
                // Update display without decimal points
                document.getElementById('subtotal').textContent = `PKR ${roundedSubtotal.toLocaleString()}`;
                document.getElementById('total').textContent = `PKR ${total.toLocaleString()}`;
                document.getElementById('totalInput').value = total.toString();
                document.getElementById('orderItems').value = JSON.stringify(cart);
                
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
                
                // Enable/disable submit button
                const submitBtn = document.getElementById('submitBtn');
                if (cart.length === 0) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-shopping-cart"></i> Cart is Empty';
                } else {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-lock"></i> Place Order Securely';
                }
            }
            
            // Initial render
            renderCart();
            
            // Form submission
            document.getElementById('checkoutForm').addEventListener('submit', function(e) {
                if (cart.length === 0) {
                    e.preventDefault();
                    alert('Your cart is empty. Please add items before placing an order.');
                    return;
                }
                
                // Update order items before submission
                document.getElementById('orderItems').value = JSON.stringify(cart);
                // Total is already set correctly in updateCart() function - don't override it here
            });
        });
    </script>

    @if(session('success'))
        <script>
            // Clear cart on successful order (handle multiple cart systems)
            localStorage.removeItem('cart');
            localStorage.removeItem('ts-cart');
            
            // Update cart count displays
            const cartCountElements = document.querySelectorAll('.cart-count, .ts-cart-count');
            cartCountElements.forEach(element => {
                if (element) {
                    element.textContent = '0';
                    element.style.display = 'none';
                }
            });
            
            // Update global cart objects if they exist
            if (typeof window.cart !== 'undefined') {
                window.cart = {};
            }
            if (typeof window.shopManager !== 'undefined' && window.shopManager.cart) {
                window.shopManager.cart = [];
                if (typeof window.shopManager.updateCartUI === 'function') {
                    window.shopManager.updateCartUI();
                }
            }
            if (typeof window.updateCartDisplay === 'function') {
                window.updateCartDisplay();
            }
        </script>
    @endif
@endsection
