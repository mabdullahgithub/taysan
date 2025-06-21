<style>
    
:root {
    --ts-primary: #8D68AD;
    --ts-primary-light: #A587C1;
    --ts-primary-dark: #735891;
    --ts-white: #ffffff;
    --ts-black: #333333;
    --ts-gray: #666666;
    --ts-light-gray: #f5f5f5;
}

/* Filter Section */
.ts-filter-section {
    background: var(--ts-white);
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
}

.ts-search-wrapper {
    position: relative;
    margin-bottom: 1rem;
}

.ts-search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--ts-primary);
}

.ts-search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.ts-search-input:focus {
    border-color: var(--ts-primary);
    box-shadow: 0 0 0 3px rgba(141, 104, 173, 0.15);
    outline: none;
}

/* Product Grid */
.ts-product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
    padding: 1rem 0;
}

.ts-product-card {
    background: var(--ts-white);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.ts-product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
}

.ts-product-image-wrapper {
    position: relative;
    padding-top: 100%;
    overflow: hidden;
    background: var(--ts-light-gray);
}

.ts-product-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.ts-product-card:hover .ts-product-image {
    transform: scale(1.1);
}

.ts-product-details {
    padding: 1.25rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.ts-product-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: var(--ts-black);
}

.ts-product-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.ts-product-category {
    color: var(--ts-gray);
    font-size: 0.9rem;
}

.ts-product-price {
    font-size: 1.2rem;
    font-weight: bold;
    color: var(--ts-primary);
}

.ts-add-to-cart-btn {
    width: 100%;
    padding: 0.75rem;
    background: var(--ts-primary);
    color: var(--ts-white);
    border: none;
    border-radius: 6px;
    font-size: 0.95rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    margin-top: auto;
}

.ts-add-to-cart-btn:hover {
    background: var(--ts-primary-dark);
    transform: translateY(-2px);
}

/* Quick View Modal */
.ts-modal-content {
    border-radius: 12px;
    overflow: hidden;
    border: none;
}

.ts-modal-header {
    background: var(--ts-primary);
    color: var(--ts-white);
    padding: 1rem 1.5rem;
    border: none;
}

.ts-modal-product-image {
    width: 100%;
    height: 400px;
    object-fit: contain;
    background: var(--ts-light-gray);
    border-radius: 8px;
}

/* Cart Sidebar */
/* Cart Sidebar Core Styles */
.ts-cart-sidebar {
    position: fixed;
    top: 0;
    right: -400px;
    width: 400px;
    height: 100vh;
    background: var(--ts-white);
    box-shadow: -5px 0 30px rgba(0, 0, 0, 0.15);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1050;
    display: flex;
    flex-direction: column;
}

/* Backdrop */
.ts-cart-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1040;
}

/* Active States */
.ts-cart-sidebar.active {
    right: 0;
}

.ts-cart-backdrop.active {
    opacity: 1;
    visibility: visible;
}

/* Header Styles */
.ts-cart-header {
    padding: 1.25rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--ts-primary);
    color: var(--ts-white);
}

.ts-cart-header h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
}

/* Close Button */
.ts-cart-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: transparent;
    border: none;
    color: #444;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    opacity: 0.7;
    padding: 0;
}

.ts-cart-close:hover {
    opacity: 1;
}

.ts-cart-close::before,
.ts-cart-close::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 2px;
    background-color: currentColor;
    transform-origin: center;
}

.ts-cart-close::before {
    transform: rotate(45deg);
}

.ts-cart-close::after {
    transform: rotate(-45deg);
}

.ts-cart-close:hover::before,
.ts-cart-close:hover::after {
    background-color: #000;
}

/* Items Container */
.ts-cart-items {
    padding: 1.25rem;
    overflow-y: auto;
    flex: 1;
    scrollbar-width: thin;
    scrollbar-color: var(--ts-primary) #f0f0f0;
}

.ts-cart-items::-webkit-scrollbar {
    width: 6px;
}

.ts-cart-items::-webkit-scrollbar-track {
    background: #f0f0f0;
}

.ts-cart-items::-webkit-scrollbar-thumb {
    background-color: var(--ts-primary);
    border-radius: 3px;
}

/* Cart Item Styles */
.ts-cart-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid #e0e0e0;
    position: relative;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.ts-cart-item:hover {
    transform: translateX(-5px);
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.05);
}

.ts-cart-item-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.ts-cart-item-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.ts-cart-item-title {
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: var(--ts-dark);
}

.ts-cart-item-price {
    color: var(--ts-primary);
    font-weight: 600;
    font-size: 1.1rem;
}

/* Quantity Controls */
.ts-cart-item-quantity {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.ts-quantity-btn {
    background: #f5f5f5;
    border: none;
    width: 24px;
    height: 24px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.ts-quantity-btn:hover {
    background: var(--ts-primary);
    color: white;
}

/* Footer Styles */
.ts-cart-footer {
    padding: 1.25rem;
    border-top: 1px solid #e0e0e0;
    background: #f9f9f9;
}

.ts-cart-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 1.1rem;
    font-weight: 600;
}

.ts-cart-total-amount {
    color: var(--ts-primary);
}

/* Checkout Button */
.ts-checkout-btn {
    width: 100%;
    padding: 1rem;
    background: var(--ts-primary);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.ts-checkout-btn:hover {
    background: var(--ts-primary-dark, darkened-primary-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Empty Cart State */
.ts-cart-empty {
    text-align: center;
    padding: 2rem;
    color: #666;
}

.ts-cart-empty i {
    font-size: 3rem;
    color: #ddd;
    margin-bottom: 1rem;
}

/* Responsive Adjustments */
@media (max-width: 480px) {
    .ts-cart-sidebar {
        width: 100%;
        right: -100%;
    }
    
    .ts-cart-item {
        padding: 0.75rem;
    }
    
    .ts-cart-item-image {
        width: 60px;
        height: 60px;
    }
}

.ts-cart-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid #e0e0e0;
    position: relative;
}

.ts-cart-item-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}

.ts-cart-item-details {
    flex: 1;
}

.ts-cart-item-title {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.ts-cart-item-price {
    color: var(--ts-primary);
    font-weight: 600;
    font-size: 1.1rem;
}

/* Floating Cart Button */
.ts-floating-cart-btn {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--ts-primary);
    color: var(--ts-white);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 1040;
}

.ts-floating-cart-btn:hover {
    background: var(--ts-primary-dark);
    transform: translateY(-3px);
}

.ts-cart-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ff4757;
    color: var(--ts-white);
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: bold;
}

/* Toast Notification */
.ts-toast {
    position: fixed;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%) translateY(100%);
    background: var(--ts-primary);
    color: var(--ts-white);
    padding: 1rem 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    opacity: 0;
    transition: all 0.3s ease;
    z-index: 1060;
}

.ts-toast.show {
    transform: translateX(-50%) translateY(0);
    opacity: 1;
}

/* Responsive Styles */
@media (max-width: 991px) {
    .ts-cart-sidebar {
        width: 100%;
        right: -100%;
    }
    
    .ts-modal-product-image {
        height: 300px;
    }
}

@media (max-width: 767px) {
    .ts-product-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    }
    
    .ts-filter-section {
        padding: 1rem;
    }
}

/* Category Select */
.form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #eee;
    border-radius: 8px;
    background-color: #f9f9f9;
}

.form-select:focus {
    border-color: var(--ts-primary);
    box-shadow: none;
}

/* Product Grid Layout */
.ts-product-grid {
    flex: 1;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
    padding: 0 2rem;
}

.ts-product-card {
    background: var(--ts-white);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.ts-product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
}

.ts-product-image-wrapper {
    position: relative;
    padding-top: 100%;
    overflow: hidden;
    background: var(--ts-light-gray);
}

.ts-product-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

/* Section Headers */
.filter-section h3 {
    font-size: 1.25rem;
    margin-bottom: 1.5rem;
    color: #333;
    font-weight: 600;
    position: relative;
    padding-bottom: 0.5rem;
}

.filter-section h3::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 2px;
    background-color: #ff6b6b;
}

/* Responsive Adjustments */
@media (max-width: 1200px) {
    .ts-product-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    }
}

@media (max-width: 768px) {
    .shop-section {
        flex-direction: column;
    }
    
    .container {
        width: 100% !important;
        min-width: 100% !important;
        padding: 0 1rem !important;
    }
    
    .ts-product-grid {
        padding: 0 1rem;
    }
}

/* Grid/List View Controls */
.view-controls {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.view-control-btn {
    padding: 0.5rem 1rem;
    background: #f5f5f5;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.view-control-btn.active {
    background: var(--ts-primary);
    color: white;
}

/* Products Header */
.products-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.sort-select {
    padding: 0.5rem 1rem;
    border: 1px solid #eee;
    border-radius: 4px;
    background: #f9f9f9;
}

.ts-filters-container {
    width: 300px;
    position: sticky;
    top: 20px;
    height: calc(100vh - 40px);
    overflow-y: auto;
    margin-left: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    padding: 20px;
    background: white;
}

@media (max-width: 768px) {
    .ts-filters-container {
        position: relative;
        width: 100%;
        height: auto;
        margin: 0 0 20px 0;
    }
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const shopManager = {
        init() {
            this.cart = [];
            this.bindEvents();
            this.loadCartFromStorage();
            this.updateCartUI();
            this.initializeQuickView();
        },

       bindEvents() {
            // Cart Toggle
            const cartBtn = document.getElementById('floatingCartBtn');
            const cartSidebar = document.getElementById('cartSidebar');
            const closeCartBtn = document.querySelector('.ts-cart-close');

            cartBtn?.addEventListener('click', () => {
                cartSidebar.classList.add('active');
            });

            closeCartBtn?.addEventListener('click', () => {
                cartSidebar.classList.remove('active');
            });

            // Prevent cart closure when clicking inside
            cartSidebar?.addEventListener('click', (e) => {
                e.stopPropagation();
            });

            // Quick View
            document.querySelectorAll('.ts-product-card').forEach(card => {
                card.addEventListener('click', (e) => {
                    if (!e.target.closest('.ts-add-to-cart-btn')) {
                        const data = card.dataset;
                        this.openQuickView(data);
                    }
                });
            });
            // Add to Cart Buttons
            document.querySelectorAll('.ts-add-to-cart-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    const data = e.target.closest('.ts-add-to-cart-btn').dataset;
                    this.addToCart({
                        id: parseInt(data.id),
                        name: data.name,
                        price: parseFloat(data.price),
                        image: data.image,
                        quantity: 1
                    });
                });
            });

            // Filter Events
            const searchInput = document.getElementById('searchInput');
            const priceRange = document.getElementById('priceRange');
            const categorySelect = document.querySelectorAll('input[name="category"]');

            searchInput?.addEventListener('input', () => this.filterProducts());
            priceRange?.addEventListener('input', (e) => {
                document.getElementById('priceRangeValue').textContent = `$0 - $${e.target.value}`;
                this.filterProducts();
            });
            categorySelect?.forEach(radio => {
                radio.addEventListener('change', () => this.filterProducts());
            });

            // Close cart when clicking outside
            document.addEventListener('click', (e) => {
                if (!cartSidebar.contains(e.target) && !cartBtn.contains(e.target)) {
                    cartSidebar.classList.remove('active');
                }
            });

            // Clear Cart Button
            const clearCartBtn = document.querySelector('.ts-clear-cart-btn');
            clearCartBtn?.addEventListener('click', () => {
                this.clearCart();
            });
        },

        initializeQuickView() {
            const quickViewModal = document.getElementById('quickViewModal');
            if (!quickViewModal) return;

            quickViewModal.addEventListener('show.bs.modal', (event) => {
                const button = event.relatedTarget;
                const data = button.dataset;

                // Update modal content
                quickViewModal.querySelector('.ts-modal-product-img').src = data.image;
                quickViewModal.querySelector('.ts-modal-product-title').textContent = data.name;
                quickViewModal.querySelector('.ts-modal-category').textContent = data.category;
                quickViewModal.querySelector('.ts-modal-price').textContent = `$${parseFloat(data.price).toFixed(2)}`;
                quickViewModal.querySelector('.ts-modal-description').textContent = data.description;

                // Reset quantity
                quickViewModal.querySelector('.ts-quantity-display').textContent = '1';

                // Update add to cart button
                const addToCartBtn = quickViewModal.querySelector('.ts-modal-add-to-cart-btn');
                addToCartBtn.dataset.id = data.id;
                addToCartBtn.dataset.name = data.name;
                addToCartBtn.dataset.price = data.price;
                addToCartBtn.dataset.image = data.image;

                addToCartBtn.onclick = () => {
                    const quantity = parseInt(quickViewModal.querySelector('.ts-quantity-display').textContent);
                    this.addToCart({
                        id: parseInt(data.id),
                        name: data.name,
                        price: parseFloat(data.price),
                        image: data.image,
                        quantity: quantity
                    });
                    bootstrap.Modal.getInstance(quickViewModal).hide();
                };
            });

            // Quick view quantity controls
            quickViewModal.querySelectorAll('.ts-quantity-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const display = quickViewModal.querySelector('.ts-quantity-display');
                    let quantity = parseInt(display.textContent);
                    
                    if (this.dataset.action === 'increase' && quantity < 99) {
                        display.textContent = quantity + 1;
                    } else if (this.dataset.action === 'decrease' && quantity > 1) {
                        display.textContent = quantity - 1;
                    }
                });
            });
        },

        addToCart(product) {
            const existingItem = this.cart.find(item => item.id === product.id);
            if (existingItem) {
                existingItem.quantity += product.quantity;
            } else {
                this.cart.push({ ...product });
            }
            this.updateCartUI();
            this.saveCartToStorage();
            this.showToast(`Added ${product.quantity} ${product.name} to cart`);
        },

        removeFromCart(productId) {
            this.cart = this.cart.filter(item => item.id !== productId);
            this.updateCartUI();
            this.saveCartToStorage();
        },

        updateCartQuantity(productId, action) {
            const item = this.cart.find(item => item.id === productId);
            if (item) {
                if (action === 'increase' && item.quantity < 99) {
                    item.quantity++;
                } else if (action === 'decrease' && item.quantity > 1) {
                    item.quantity--;
                }
                this.updateCartUI();
                this.saveCartToStorage();
            }
        },

        clearCart() {
            this.cart = [];
            this.updateCartUI();
            this.saveCartToStorage();
            this.showToast("Cart cleared");
        },

        updateCartUI() {
            const cartCount = document.querySelector('.ts-cart-count');
            const cartItems = document.querySelector('.ts-cart-items');
            const totalAmount = document.querySelector('.ts-cart-total-amount');

            // Update cart count
            const totalQuantity = this.cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCount.textContent = totalQuantity;

            // Update cart items
            cartItems.innerHTML = this.cart.map(item => `
                <div class="ts-cart-item">
                    <img class="ts-cart-item-image" src="${item.image}" alt="${item.name}">
                    <div class="ts-cart-item-details">
                        <h4 class="ts-cart-item-title">${item.name}</h4>
                        <div class="ts-cart-item-price">$${(item.price * item.quantity).toFixed(2)}</div>
                        <div class="ts-quantity-control">
                            <button class="ts-quantity-btn" onclick="shopManager.updateCartQuantity(${item.id}, 'decrease')">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="ts-quantity-display">${item.quantity}</span>
                            <button class="ts-quantity-btn" onclick="shopManager.updateCartQuantity(${item.id}, 'increase')">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                 <button class="ts-cart-item-remove btn btn-danger" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); width: 24px; height: 24px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 4px;" onclick="shopManager.removeFromCart(${item.id})">
    <i class="fas fa-times" style="font-size: 12px;"></i>
</button>
                </div>
            `).join('');

            // Update total
            const total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            totalAmount.textContent = `$${total.toFixed(2)}`;
        },

        filterProducts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const maxPrice = parseFloat(document.getElementById('priceRange').value);
            const selectedCategory = document.querySelector('input[name="category"]:checked').value;

            document.querySelectorAll('.ts-product-card').forEach(product => {
                const name = product.querySelector('.ts-product-title').textContent.toLowerCase();
                const price = parseFloat(product.dataset.price);
                const category = product.dataset.category;

                const matchesSearch = name.includes(searchTerm);
                const matchesPrice = price <= maxPrice;
                const matchesCategory = selectedCategory === 'all' || category === selectedCategory;

                product.style.display = (matchesSearch && matchesPrice && matchesCategory) ? 'flex' : 'none';
            });
        },

        showToast(message) {
            const toast = document.querySelector('.ts-toast');
            if (!toast) return;

            toast.textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        },

        loadCartFromStorage() {
            const savedCart = localStorage.getItem('ts-cart');
            if (savedCart) {
                this.cart = JSON.parse(savedCart);
            }
        },

        saveCartToStorage() {
            localStorage.setItem('ts-cart', JSON.stringify(this.cart));
        }
    };

    // Initialize shop
    window.shopManager = shopManager;
    shopManager.init();
});
</script>


<script>
    $(document).ready(function () {
    // A simple in-memory store for cart items.
    // Key = product ID, Value = { name, price, image, quantity }
    const cart = {};

    // Update the mini-cart UI in the navbar
    function updateCartDisplay() {
        // Grab the relevant elements in your navbar’s mini-cart
        const $cartCount          = $(".cart-count");
        const $miniCartItems      = $(".mini-cart-items");
        const $miniCheckoutPrice  = $(".mini-checkout-price span");

        // Clear out existing content in .mini-cart-items
        $miniCartItems.empty();

        let totalQuantity = 0;
        let totalPrice = 0;

        // Build mini-cart items from our `cart` object
        for (const productId in cart) {
            const item = cart[productId];
            const itemTotal = item.price * item.quantity;

            totalQuantity += item.quantity;
            totalPrice += itemTotal;

            // Create a mini-cart entry with increment/decrement/remove
            // Feel free to style or structure this HTML differently
            $miniCartItems.append(`
                <div class="mini-cart-item clearfix">
                    <div class="mini-cart-item-image">
                        <a href="#"><img src="${item.image}" alt="${item.name}" width="50"></a>
                    </div>
                    <div class="mini-cart-item-des">
                        <a href="#">${item.name}</a>
                        <span class="mini-cart-item-price">
                            $${itemTotal.toFixed(2)} 
                            <small>(${item.quantity}x)</small>
                        </span>
                        <div class="cart-qty-controls">
                            <button class="decrement-btn" data-id="${productId}">-</button>
                            <button class="increment-btn" data-id="${productId}">+</button>
                            <button class="remove-item" data-id="${productId}">
                                <i class="ti-close"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `);
        }

        // Update cart count and subtotal
        $cartCount.text(totalQuantity);
        $miniCheckoutPrice.text(`$${totalPrice.toFixed(2)}`);
    }

    // Add a product to the cart (or increment if it already exists)
    function addToCart(productId, productDetails) {
        if (cart[productId]) {
            cart[productId].quantity++;
        } else {
            cart[productId] = {
                name: productDetails.name,
                price: productDetails.price,
                image: productDetails.image,
                quantity: 1,
            };
        }
        updateCartDisplay();
    }

    // Increment an item’s quantity
    function incrementItem(productId) {
        if (cart[productId]) {
            cart[productId].quantity++;
            updateCartDisplay();
        }
    }

    // Decrement an item’s quantity; remove if it hits zero
    function decrementItem(productId) {
        if (cart[productId]) {
            cart[productId].quantity--;
            if (cart[productId].quantity <= 0) {
                delete cart[productId];
            }
            updateCartDisplay();
        }
    }

    // Remove an item from the cart entirely
    function removeItem(productId) {
        if (cart[productId]) {
            delete cart[productId];
            updateCartDisplay();
        }
    }

    // Listen for clicks on “Add to Cart” buttons
    $("body").on("click", ".add-to-cart-btn", function (e) {
        e.preventDefault();

        // Find the closest .product-single-item to gather data
        const $product = $(this).closest(".product-single-item");
        const productId = $product.data("product-id");

        const productName = $product.find("h2 a").text().trim();
        const productPrice = parseFloat(
            $product.find(".present-price").text().replace("$", "")
        );
        const productImage = $product.find("img").attr("src");

        addToCart(productId, {
            name: productName,
            price: productPrice,
            image: productImage,
        });
    });

    // Listen for increment, decrement, and remove actions in the mini-cart
    $("body").on("click", ".increment-btn", function (e) {
        e.preventDefault();
        const productId = $(this).data("id");
        incrementItem(productId);
    });

    $("body").on("click", ".decrement-btn", function (e) {
        e.preventDefault();
        const productId = $(this).data("id");
        decrementItem(productId);
    });

    $("body").on("click", ".remove-item", function (e) {
        e.preventDefault();
        const productId = $(this).data("id");
        removeItem(productId);
    });
});

    </script>
