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