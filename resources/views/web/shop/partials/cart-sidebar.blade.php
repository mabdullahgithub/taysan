<div class="ts-cart-sidebar" id="cartSidebar">
    <div class="ts-cart-header">
        <h3 class="text-white">Shopping Cart</h3>
        <button class="ts-cart-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="ts-cart-items">
        <!-- Cart items will be dynamically added here -->
    </div>
    <div class="ts-cart-footer">
        <div class="ts-cart-total">
            <span>Total:</span>
            <span class="ts-cart-total-amount">$0.00</span>
        </div>
        <button class="ts-checkout-btn" id="checkoutBtn">
            Proceed to Checkout
        </button>
        <button class="ts-clear-cart-btn" style="
    padding: 8px 16px !important;
    background: #f8f0ff !important;  /* Light purple background */
    color: #8D68AD !important;       /* Same purple as your theme */
    border: 2px solid #8D68AD !important;
    border-radius: 8px !important;
    font-weight: 500 !important;
    font-size: 14px !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    margin: 10px 0 !important;
">
    <i class="fas fa-trash-alt"></i>
    Clear Cart
</button>
    </div>
</div>

<script>
document.getElementById('checkoutBtn').addEventListener('click', () => {
    const cart = localStorage.getItem('ts-cart');
    const cartItems = cart ? JSON.parse(cart) : [];
    if (cartItems.length > 0) {
        // Redirect to order screen when cart has items
        window.location.href = '/orders-web';
    } else {
        // Show error message when cart is empty
        alert('Your cart is empty. Please add something to proceed.');
    }
});
</script>