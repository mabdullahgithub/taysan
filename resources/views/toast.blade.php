<!-- Toast Notification Component -->
<!-- Font Awesome Icons (if not already included) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Toast Container */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 12px;
        max-width: 400px;
        width: 100%;
        pointer-events: none;
    }

    /* Toast Base Styles */
    .toast {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        border: 1px solid rgba(0, 0, 0, 0.08);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        overflow: hidden;
        pointer-events: auto;
        transform: translateX(100%);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        min-height: 60px;
    }

    .toast.show {
        transform: translateX(0);
        opacity: 1;
    }

    .toast.hide {
        transform: translateX(100%);
        opacity: 0;
    }

    /* Toast Icons */
    .toast-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 16px;
        color: #ffffff;
    }

    /* Toast Content */
    .toast-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .toast-title {
        font-weight: 600;
        font-size: 14px;
        color: #1a202c;
        margin: 0;
        line-height: 1.4;
    }

    .toast-message {
        font-size: 13px;
        color: #4a5568;
        margin: 0;
        line-height: 1.4;
    }

    /* Close Button */
    .toast-close {
        background: none;
        border: none;
        color: #a0aec0;
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        font-size: 14px;
        flex-shrink: 0;
        transition: all 0.2s ease;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .toast-close:hover {
        color: #718096;
        background: rgba(0, 0, 0, 0.05);
    }

    /* Progress Bar */
    .toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 0 0 12px 12px;
        transform-origin: left;
        animation: progress 4s linear forwards;
    }

    @keyframes progress {
        from { transform: scaleX(1); }
        to { transform: scaleX(0); }
    }

    /* Toast Types */
    .toast-success {
        border-left: 4px solid #48bb78;
    }

    .toast-success .toast-icon {
        background: #48bb78;
    }

    .toast-success .toast-progress {
        background: #48bb78;
    }

    .toast-error {
        border-left: 4px solid #f56565;
    }

    .toast-error .toast-icon {
        background: #f56565;
    }

    .toast-error .toast-progress {
        background: #f56565;
    }

    .toast-warning {
        border-left: 4px solid #ed8936;
    }

    .toast-warning .toast-icon {
        background: #ed8936;
    }

    .toast-warning .toast-progress {
        background: #ed8936;
    }

    .toast-info {
        border-left: 4px solid #4299e1;
    }

    .toast-info .toast-icon {
        background: #4299e1;
    }

    .toast-info .toast-progress {
        background: #4299e1;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .toast-container {
            top: 10px;
            right: 10px;
            left: 10px;
            max-width: none;
        }

        .toast {
            padding: 14px 16px;
            border-radius: 10px;
            min-height: 56px;
        }

        .toast-icon {
            width: 36px;
            height: 36px;
            font-size: 14px;
        }

        .toast-title {
            font-size: 13px;
        }

        .toast-message {
            font-size: 12px;
        }
    }

    @media (max-width: 480px) {
        .toast-container {
            top: 5px;
            right: 5px;
            left: 5px;
        }

        .toast {
            padding: 12px 14px;
            border-radius: 8px;
            min-height: 52px;
        }

        .toast-content {
            gap: 1px;
        }
    }

    /* Animation for multiple toasts */
    .toast:not(:first-child) {
        margin-top: -4px;
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .toast {
            background: #2d3748;
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .toast-title {
            color: #f7fafc;
        }

        .toast-message {
            color: #e2e8f0;
        }

        .toast-close {
            color: #a0aec0;
        }

        .toast-close:hover {
            color: #cbd5e0;
            background: rgba(255, 255, 255, 0.1);
        }
    }
</style>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toast notification system
    const toastContainer = document.getElementById('toastContainer');
    
    // Function to create and show toast
    function showToast(type, title, message, duration = 4000) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        
        // Get appropriate icon based on type
        const icons = {
            success: 'fas fa-check',
            error: 'fas fa-times',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };
        
        // Get appropriate title if not provided
        const titles = {
            success: 'Success!',
            error: 'Error!',
            warning: 'Warning!',
            info: 'Info'
        };
        
        const toastTitle = title || titles[type];
        const icon = icons[type] || 'fas fa-info-circle';
        
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="${icon}"></i>
            </div>
            <div class="toast-content">
                <p class="toast-title">${toastTitle}</p>
                <p class="toast-message">${message}</p>
            </div>
            <button class="toast-close" onclick="removeToast(this)">
                <i class="fas fa-times"></i>
            </button>
            <div class="toast-progress"></div>
        `;
        
        // Add to container
        toastContainer.appendChild(toast);
        
        // Trigger animation
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);
        
        // Auto remove after duration
        setTimeout(() => {
            removeToast(toast.querySelector('.toast-close'));
        }, duration);
        
        return toast;
    }
    
    // Function to remove toast
    window.removeToast = function(button) {
        const toast = button.closest('.toast');
        toast.classList.add('hide');
        
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 400);
    }
    
    // Show Laravel session messages
    @if(session('success'))
        showToast('success', 'Success!', '{{ session('success') }}');
        @if(session('clear_cart'))
        // Wait a moment for DOM to be ready, then clear cart
        setTimeout(function() {
            // Clear cart using the global function if available
            if (typeof window.clearCart === 'function') {
                window.clearCart();
            } else {
                // Fallback: clear localStorage directly
                localStorage.removeItem('ts-cart');
            }
            
            // Clear both cart systems manually as backup
            if (typeof window.shopManager !== 'undefined') {
                window.shopManager.cart = [];
                if (typeof window.shopManager.updateCartDisplay === 'function') {
                    window.shopManager.updateCartDisplay();
                }
                if (typeof window.shopManager.saveCartToStorage === 'function') {
                    window.shopManager.saveCartToStorage();
                }
            }
            
            if (typeof window.updateCartDisplay === 'function') {
                // Clear the old cart system too
                for (let key in window.cart || {}) {
                    delete window.cart[key];
                }
                window.updateCartDisplay();
            }
            
            // Clear any cart count displays
            const cartCountElements = document.querySelectorAll('.cart-count, .floating-cart-count, .cart-item-count');
            cartCountElements.forEach(element => {
                element.textContent = '0';
                element.style.display = 'none';
            });
            
            // Clear any cart amount displays
            const cartAmountElements = document.querySelectorAll('.cart-total-amount, .mini-checkout-price span');
            cartAmountElements.forEach(element => {
                element.textContent = '$0.00';
            });
            
            // Clear cart items containers
            const cartItemsContainers = document.querySelectorAll('.mini-cart-items, .cart-items-container, .floating-cart-items');
            cartItemsContainers.forEach(container => {
                container.innerHTML = '';
            });
        }, 100);
        @endif
    @endif
    
    @if(session('error'))
        showToast('error', 'Error!', '{{ session('error') }}');
    @endif
    
    @if(session('warning'))
        showToast('warning', 'Warning!', '{{ session('warning') }}');
    @endif
    
    @if(session('info'))
        showToast('info', 'Info', '{{ session('info') }}');
    @endif
    
    @if($errors->any())
        @foreach($errors->all() as $error)
            showToast('error', 'Validation Error', '{{ $error }}');
        @endforeach
    @endif
    
    // Global function to show custom toasts
    window.showToast = showToast;
});
</script>