<!-- Product Quick View Modal -->
<div class="custom-quickview modal" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="custom-quickview__content">
            <button type="button" class="custom-quickview__close" data-bs-dismiss="modal">
                <i class="fas fa-times"></i>
            </button>
            
            <div class="custom-quickview__body">
                <div class="custom-quickview__grid">
                    <!-- Product Image -->
                    <div class="custom-quickview__image-wrapper">
                        <img src="" alt="Product" id="quickViewImage" class="custom-quickview__image">
                    </div>
                    
                    <!-- Product Details -->
                    <div class="custom-quickview__details">
                        <h2 class="custom-quickview__title" id="quickViewTitle"></h2>
                        <div class="custom-quickview__price" id="quickViewPrice"></div>
                        <p class="custom-quickview__description" id="quickViewDescription"></p>
                        
                        <!-- Quantity Selector -->
                        <div class="custom-quickview__quantity">
                            <label>Quantity:</label>
                            <div class="custom-quickview__quantity-controls">
                                <button class="custom-quickview__qty-btn" id="decreaseQuantity">-</button>
                                <input type="number" value="1" min="1" class="custom-quickview__qty-input" id="quantityInput">
                                <button class="custom-quickview__qty-btn" id="increaseQuantity">+</button>
                            </div>
                        </div>
                        
                        <button class="custom-quickview__add-btn" id="quickViewAddToCart">
                            <i class="fas fa-shopping-cart"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Reset styles for modal */
.custom-quickview {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    z-index: 2000;
}

.custom-quickview.show {
    display: flex !important;
    align-items: center;
    justify-content: center;
}

.custom-quickview .modal-dialog {
    max-width: 1000px;
    margin: 1.75rem auto;
    position: relative;
    width: auto;
    pointer-events: none;
}

.custom-quickview__content {
    position: relative;
    display: flex;
    flex-direction: column;
    width: 100%;
    background-color: #fff;
    border-radius: 15px;
    pointer-events: auto;
    outline: 0;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
}

.custom-quickview__close {
    position: absolute;
    right: 20px;
    top: 20px;
    width: 35px;
    height: 35px;
    background: #fff;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.custom-quickview__body {
    padding: 30px;
}

.custom-quickview__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.custom-quickview__image-wrapper {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.custom-quickview__image {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
}

.custom-quickview__title {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
}

.custom-quickview__price {
    font-size: 28px;
    font-weight: 700;
    color: #8D68AD;
    margin-bottom: 20px;
}

.custom-quickview__description {
    color: #666;
    line-height: 1.6;
    margin-bottom: 25px;
}

.custom-quickview__quantity {
    margin-bottom: 25px;
}

.custom-quickview__quantity-controls {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
}

.custom-quickview__qty-btn {
    width: 35px;
    height: 35px;
    border: 1px solid #ddd;
    background: #fff;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.custom-quickview__qty-btn:hover {
    background: #8D68AD;
    color: #fff;
    border-color: #8D68AD;
}

.custom-quickview__qty-input {
    width: 60px;
    height: 35px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.custom-quickview__add-btn {
    width: 100%;
    padding: 15px;
    background: #8D68AD;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.custom-quickview__add-btn:hover {
    background: #735891;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .custom-quickview__grid {
        grid-template-columns: 1fr;
    }
    
    .custom-quickview__body {
        padding: 20px;
    }
    
    .custom-quickview__image {
        max-height: 300px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap modal
    const quickViewModal = new bootstrap.Modal(document.getElementById('quickViewModal'), {
        backdrop: 'static' // Prevents closing when clicking outside
    });
    
    // Quick View Button Click Handlers
    document.querySelectorAll('.ts-quick-view-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Update modal content
            document.getElementById('quickViewImage').src = this.dataset.image;
            document.getElementById('quickViewTitle').textContent = this.dataset.name;
            document.getElementById('quickViewPrice').textContent = `$${parseFloat(this.dataset.price).toFixed(2)}`;
            document.getElementById('quickViewDescription').textContent = this.dataset.description;
            
            // Reset quantity
            document.getElementById('quantityInput').value = 1;
            
            // Show modal
            quickViewModal.show();
        });
    });
    
    // Quantity Controls
    const quantityInput = document.getElementById('quantityInput');
    
    document.getElementById('decreaseQuantity').addEventListener('click', () => {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });
    
    document.getElementById('increaseQuantity').addEventListener('click', () => {
        const currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
    });
    
    // Validate quantity input
    quantityInput.addEventListener('change', () => {
        if (quantityInput.value < 1) {
            quantityInput.value = 1;
        }
    });
});
</script>