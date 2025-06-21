@extends('web.layout.app')
@section('content')

<!-- Required CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Shop Section -->
<div class="shop-section">
    <div class="container">
        <!-- Filters Section -->
        <div class="filter-section glass-card mb-4">
            <div class="row g-4">
                <!-- Search Filter -->
                <div class="col-md-4">
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search products...">
                    </div>
                </div>

                <!-- Price Range Filter -->
                <div class="col-md-4">
                    <div class="price-range-wrapper">
                        <label>Price Range: <span id="priceRangeValue">$0 - $1000</span></label>
                        <input type="range" class="form-range custom-range" id="priceRange" min="0" max="1000" step="50">
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="col-md-4">
                    <select id="categorySelect" class="form-select">
                        <option value="all">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="row g-4" id="productsContainer">
            @foreach($products as $product)
                <div class="col-md-6 col-lg-4 product-item" 
                     data-price="{{ $product->price }}" 
                     data-category="{{ $product->category_id }}">
                    <div class="product-card glass-card">
                        <div class="product-image">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            <div class="product-actions">
                                <button class="action-btn quick-view-btn" data-bs-toggle="modal" 
                                        data-bs-target="#quickViewModal"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-price="{{ $product->price }}"
                                        data-description="{{ $product->description }}"
                                        data-category="{{ $product->category->name }}"
                                        data-image="{{ asset('storage/' . $product->image) }}">
                                    <i class="fas fa-eye"></i>
                                    <span>Quick View</span>
                                </button>
                            </div>
                        </div>
                        <div class="product-details">
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <div class="product-meta">
                                <span class="product-category">{{ $product->category->name }}</span>
                                <span class="product-price">${{ number_format($product->price, 0) }}</span>
                            </div>
                            <button class="add-to-cart-btn" 
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->price }}"
                                    data-image="{{ asset('storage/' . $product->image) }}">
                                <i class="fas fa-shopping-cart"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content glass-modal">
            <div class="modal-header">
                <h5 class="modal-title">Quick View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="modal-product-image glass-card">
                            <img src="" alt="Product" class="product-modal-img">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="modal-product-info">
                            <h2 class="product-modal-title"></h2>
                            <div class="modal-product-meta">
                                <span class="modal-category"></span>
                                <span class="modal-price"></span>
                            </div>
                            <p class="modal-product-description"></p>
                            <!-- Update the quantity control in the modal -->
<div class="quantity-control modal-quantity-control glass-card">
    <button class="qty-btn modal-qty-btn" data-action="decrease">
        <i class="fas fa-minus"></i>
    </button>
    <span class="quantity-display">1</span>
    <button class="qty-btn modal-qty-btn" data-action="increase">
        <i class="fas fa-plus"></i>
    </button>
</div>
<style>
/* Modal Quantity Control Styles */
.modal-quantity-control {
    display: inline-flex;
    align-items: center;
    background: var(--white);
    border-radius: 8px;
    padding: 0.5rem;
    margin-bottom: 1.5rem;
}

.modal-qty-btn {
    width: 36px;
    height: 36px;
    background: none;
    border: 1px solid var(--primary-transparent);
    border-radius: 6px;
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-qty-btn:hover {
    background: var(--primary);
    color: var(--white);
}

.quantity-display {
    min-width: 40px;
    text-align: center;
    font-weight: 600;
    color: var(--primary);
}
</style>
                            <button class="modal-add-to-cart-btn">
                                <i class="fas fa-shopping-cart"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cart Sidebar -->
<div class="cart-sidebar glass-modal" id="cartSidebar">
    <div class="cart-header">
        <h3>Shopping Cart</h3>
        <button class="close-cart">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="cart-items">
        <!-- Cart items will be dynamically added here -->
    </div>
    <div class="cart-footer">
        <div class="cart-total">
            <span>Total:</span>
            <span class="total-amount">$0.00</span>
        </div>
        <button class="checkout-btn">
            Proceed to Checkout
        </button>
    </div>
</div>

<!-- Floating Cart Button -->
<button class="floating-cart-btn" id="floatingCartBtn">
    <i class="fas fa-shopping-cart"></i>
    <span class="cart-count">0</span>
</button>

<!-- Toast Notification -->
<div class="toast-notification" id="toastNotification">
    <span class="toast-message"></span>
</div>

<style>
:root {
    --primary: #8D68AD;
    --primary-light: #A587C1;
    --primary-dark: #735891;
    --primary-transparent: rgba(141, 104, 173, 0.1);
    --white: #ffffff;
    --black: #333333;
    --gray: #666666;
}

/* Glassmorphism Effects */
.glass-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(141, 104, 173, 0.1);
    box-shadow: 0 8px 32px rgba(141, 104, 173, 0.1);
    border-radius: 15px;
    transition: all 0.3s ease;
}

.glass-modal {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(141, 104, 173, 0.2);
}

/* Filter Section Styles */
.filter-section {
    padding: 2rem;
    margin-bottom: 2rem;
}

.search-wrapper {
    position: relative;
}

.search-wrapper i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--primary);
}

.search-wrapper input {
    padding-left: 40px;
    border: 1px solid var(--primary-transparent);
    border-radius: 10px;
}

.price-range-wrapper {
    padding: 0 15px;
}

.custom-range {
    height: 6px;
    background: var(--primary-light);
    border-radius: 3px;
}

.custom-range::-webkit-slider-thumb {
    background: var(--primary);
    width: 20px;
    height: 20px;
    border-radius: 50%;
    cursor: pointer;
}

/* Product Card Styles */
.product-card {
    height: 100%;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-10px);
}

.product-image {
    position: relative;
    height: 300px;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.1);
}

.product-actions {
    position: absolute;
    right: -100px;
    top: 20px;
    transition: right 0.3s ease;
}

.product-card:hover .product-actions {
    right: 20px;
}

.action-btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: var(--white);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    box-shadow: 0 4px 15px rgba(141, 104, 173, 0.2);
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: var(--primary);
    color: var(--white);
}

.product-details {
    padding: 1.5rem;
}

.product-title {
    font-size: 1.2rem;
    margin-bottom: 1rem;
}

.product-meta {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.product-price {
    color: var(--primary);
    font-size: 1.2rem;
    font-weight: bold;
}

.add-to-cart-btn {
    width: 100%;
    padding: 0.8rem;
    background: var(--primary);
    color: var(--white);
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
}

.add-to-cart-btn:hover {
    background: var(--primary-dark);
}

/* Cart Sidebar Styles */
.cart-sidebar {
    position: fixed;
    top: 0;
    right: -400px;
    width: 400px;
    height: 100vh;
    padding: 2rem;
    transition: right 0.3s ease;
    z-index: 1050;
}

.cart-sidebar.active {
    right: 0;
}

.cart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.cart-items {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}

.cart-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    margin-bottom: 1rem;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
}

.cart-item img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 1rem;
}

.cart-item-details {
    flex: 1;
}

.cart-footer {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.9);
    border-top: 1px solid var(--primary-transparent);
}

.cart-total {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    font-size: 1.2rem;
    font-weight: bold;
}

.checkout-btn {
    width: 100%;
    padding: 1rem;
    background: var(--primary);
    color: var(--white);
    border: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.checkout-btn:hover {
    background: var(--primary-dark);
}

/* Floating Cart Button */
.floating-cart-btn {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--primary);
    color: var(--white);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    box-shadow: 0 4px 15px rgba(141, 104, 173, 0.3);
    transition: all 0.3s ease;
    z-index: 1040;
}

.floating-cart-btn:hover {
    background: var(--primary-dark);
    transform: scale(1.1);
}

.cart-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ff4444;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Toast Notification */
.toast-notification {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    background: #4CAF50;
    color: white;
    padding: 1rem 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transform: translateY(150%);
    transition: transform 0.3s ease;
    z-index: 1060;
}

.toast-notification.show {
    transform: translateY(0);
}

.cart-item {
    display: flex;
    gap: 1rem;
    padding: 1.25rem;
    margin-bottom: 1rem;
    align-items: flex-start;
    position: relative;
}

.cart-item-img {
    width: 100px;
    height: 100px;
    flex-shrink: 0;
    border-radius: 8px;
    overflow: hidden;
}

.cart-item-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cart-item-content {
    flex: 1;
    min-width: 0;
}

.cart-item-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.5rem;
}

.cart-item-title {
    font-size: 1rem;
    font-weight: 500;
    margin: 0;
    padding-right: 1.5rem;
}

.cart-item-remove {
    background: none;
    border: none;
    color: #999;
    padding: 0.25rem;
    cursor: pointer;
    transition: color 0.3s ease;
}

.cart-item-remove:hover {
    color: #ff4444;
}

.cart-item-price {
    color: var(--primary);
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.cart-quantity-control {
    display: inline-flex;
    background: var(--white);
    border-radius: 8px;
    padding: 0.25rem;
}

.cart-qty-btn {
    width: 30px;
    height: 30px;
    font-size: 0.875rem;
}

/* Enhanced Cart Sidebar Styles */
.cart-sidebar {
    box-shadow: -5px 0 30px rgba(0, 0, 0, 0.1);
    padding: 0;
}

.cart-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(141, 104, 173, 0.1);
}

.cart-header h3 {
    font-size: 1.25rem;
    margin: 0;
}

.cart-items {
    padding: 1.5rem;
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}

.cart-footer {
    padding: 1.5rem;
    border-top: 1px solid rgba(141, 104, 173, 0.1);
}

/* Enhanced Modal Styles */
.modal-header {
    border-bottom: 1px solid rgba(141, 104, 173, 0.1);
    padding: 1.5rem;
}

.modal-product-image {
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.modal-product-image img {
    max-height: 100%;
    width: auto;
    object-fit: contain;
}

.modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray);
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.modal-close:hover {
    background: var(--primary);
    color: white;
}


</style>
<!-- Previous HTML and CSS code remains the same -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables
    const searchInput = document.getElementById('searchInput');
    const priceRange = document.getElementById('priceRange');
    const priceRangeValue = document.getElementById('priceRangeValue');
    const categorySelect = document.getElementById('categorySelect');
    const productsContainer = document.getElementById('productsContainer');
    const cartSidebar = document.getElementById('cartSidebar');
    const floatingCartBtn = document.getElementById('floatingCartBtn');
    const cartItems = document.querySelector('.cart-items');
    const cartCount = document.querySelector('.cart-count');
    const totalAmount = document.querySelector('.total-amount');
    const toastNotification = document.getElementById('toastNotification');
    
    let cart = [];

    // Filter Products Function
    function filterProducts() {
        const searchTerm = searchInput.value.toLowerCase();
        const maxPrice = parseInt(priceRange.value);
        const selectedCategory = categorySelect.value;
        
        document.querySelectorAll('.product-item').forEach(product => {
            const productName = product.querySelector('.product-title').textContent.toLowerCase();
            const productPrice = parseFloat(product.dataset.price);
            const productCategory = product.dataset.category;
            
            const matchesSearch = productName.includes(searchTerm);
            const matchesPrice = productPrice <= maxPrice;
            const matchesCategory = selectedCategory === 'all' || productCategory === selectedCategory;
            
            product.style.display = (matchesSearch && matchesPrice && matchesCategory) ? '' : 'none';
        });
    }

    // Update Price Range Display
    priceRange.addEventListener('input', function() {
        priceRangeValue.textContent = `$0 - $${this.value}`;
        filterProducts();
    });

    // Event Listeners for Filters
    searchInput.addEventListener('input', filterProducts);
    categorySelect.addEventListener('change', filterProducts);

    // Cart Functions
    function addToCart(product) {
        const existingItem = cart.find(item => item.id === product.id);
        
        if (existingItem) {
            existingItem.quantity += product.quantity || 1;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                quantity: product.quantity || 1
            });
        }
        
        updateCartUI();
        showToast(`Added ${product.quantity || 1} ${product.name}(s) to cart`);
    }

    function removeFromCart(productId) {
        cart = cart.filter(item => item.id !== productId);
        updateCartUI();
    }

    function updateCartUI() {
        // Update cart count
        cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0);
        
        // Update cart items
        cartItems.innerHTML = cart.map(item => `
    <div class="cart-item glass-card">
        <div class="cart-item-img">
            <img src="${item.image}" alt="${item.name}">
        </div>
        <div class="cart-item-content">
            <div class="cart-item-header">
                <h4 class="cart-item-title">${item.name}</h4>
                <button class="cart-item-remove" onclick="removeFromCart(${item.id})">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="cart-item-price">$${Math.round(item.price)}</div>
            <div class="cart-item-controls">
                <div class="quantity-control cart-quantity-control">
                    <button class="qty-btn cart-qty-btn" onclick="updateCartQuantity(${item.id}, 'decrease')">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span class="quantity-display">${item.quantity}</span>
                    <button class="qty-btn cart-qty-btn" onclick="updateCartQuantity(${item.id}, 'increase')">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
`).join('');
        
// Add cart quantity update function
function updateCartQuantity(productId, action) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        if (action === 'increase' && item.quantity < 99) {
            item.quantity++;
        } else if (action === 'decrease' && item.quantity > 1) {
            item.quantity--;
        }
        updateCartUI();
    }
}
        // Update total
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        totalAmount.textContent = `$${Math.round(total)}`;

        // Save cart to localStorage
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    // Quick View Modal Functions
    const quickViewModal = document.getElementById('quickViewModal');
    quickViewModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const data = button.dataset;
        
        // Update modal content
        quickViewModal.querySelector('.product-modal-img').src = data.image;
        quickViewModal.querySelector('.product-modal-title').textContent = data.name;
        quickViewModal.querySelector('.modal-category').textContent = data.category;
        quickViewModal.querySelector('.modal-price').textContent = `$${Math.round(parseFloat(data.price))}`;
        quickViewModal.querySelector('.modal-product-description').textContent = data.description;
        
        // Reset quantity
        quickViewModal.querySelector('.quantity-display').textContent = '1';
        
        // Set up add to cart button
        const modalAddToCartBtn = quickViewModal.querySelector('.modal-add-to-cart-btn');
        modalAddToCartBtn.onclick = () => {
            const quantity = parseInt(quickViewModal.querySelector('.quantity-display').textContent);
            addToCart({
                id: parseInt(data.id),
                name: data.name,
                price: parseFloat(data.price),
                image: data.image,
                quantity: quantity
            });
            
            // Close modal
            bootstrap.Modal.getInstance(quickViewModal).hide();
        };
    });

    // Quantity Control in Modal
    quickViewModal.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const display = quickViewModal.querySelector('.quantity-display');
            let quantity = parseInt(display.textContent);
            
            if (this.dataset.action === 'increase' && quantity < 99) {
                display.textContent = quantity + 1;
            } else if (this.dataset.action === 'decrease' && quantity > 1) {
                display.textContent = quantity - 1;
            }
        });
    });

    // Cart Sidebar Toggle
    floatingCartBtn.addEventListener('click', () => {
        cartSidebar.classList.toggle('active');
    });

    document.querySelector('.close-cart').addEventListener('click', () => {
        cartSidebar.classList.remove('active');
    });

    // Add to Cart Button Event Listeners
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            const data = this.dataset;
            addToCart({
                id: parseInt(data.id),
                name: data.name,
                price: parseFloat(data.price),
                image: data.image,
                quantity: 1
            });
        });
    });

    // Toast Notification Function
    function showToast(message) {
        const toast = document.getElementById('toastNotification');
        toast.querySelector('.toast-message').textContent = message;
        toast.classList.add('show');
        
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    // Load cart from localStorage on page load
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCartUI();
    }

    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

@endsection