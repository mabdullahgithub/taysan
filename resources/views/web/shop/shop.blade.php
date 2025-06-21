@extends('web.layout.app')
@section('content')
@include('web.partials.cart_related')

<style>
    :root {
        --primary: #8D68AD;
        --primary-light: #A67BC9;
        --primary-dark: #6B4E84;
        --text-dark: #333;
        --text-light: #666;
        --border: #e0e0e0;
        --shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.15);
        --bg-light: #f8f9fa;
    }

    /* Shop Banner Styles - Matching Contact/About */
    .shop-page-banner {
        position: relative;
        padding: 120px 0 80px;
        background-color: #f5f5f5;
        margin-top: 130px;
        z-index: 1;
        min-height: 300px;
        display: flex;
        align-items: center;
    }

    .shop-banner-content {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        padding: 0 15px;
        position: relative;
        z-index: 2;
    }

    .shop-banner-title {
        font-size: 48px;
        color: #fff;
        margin-bottom: 15px;
        font-weight: 700;
        text-transform: capitalize;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .shop-banner-breadcrumb {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .shop-banner-breadcrumb li {
        color: #fff;
        font-size: 16px;
        position: relative;
    }

    .shop-banner-breadcrumb li a {
        color: #fff;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .shop-banner-breadcrumb li a:hover {
        text-decoration: underline;
    }

    .shop-banner-breadcrumb li:not(:last-child)::after {
        content: "/";
        margin-left: 10px;
        color: #fff;
    }

    /* Shop Wrapper */
    .ts-shop-wrapper {
        display: flex;
        gap: 2rem;
        padding: 3rem 2rem;
        min-height: 100vh;
        background: var(--bg-light);
        position: relative;
    }

    /* Products Container */
    .ts-products-container {
        flex: 1;
        min-width: 0;
    }

    .products-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: white;
        border-radius: 15px;
        box-shadow: var(--shadow);
    }

    .products-count {
        color: var(--text-light);
        font-size: 14px;
        font-weight: 500;
    }

    .products-count strong {
        color: var(--primary);
        font-weight: 600;
    }

    .sort-dropdown {
        padding: 8px 12px;
        border: 2px solid var(--border);
        border-radius: 8px;
        background: white;
        color: var(--text-dark);
        cursor: pointer;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .sort-dropdown:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(141, 104, 173, 0.1);
    }

    /* Desktop and Mobile Filter Containers */
    .mobile-filters-container {
        display: none;
    }

    .desktop-filters-container {
        display: none;
    }

    /* Position filters for desktop */
    @media (min-width: 769px) {
        .ts-shop-wrapper {
            display: flex;
            gap: 2rem;
        }

        .mobile-filters-container {
            display: none !important;
        }

        .desktop-filters-container {
            display: block;
            width: 300px;
            flex-shrink: 0;
            order: -1; /* Move filters to the left */
        }

        .ts-products-container {
            flex: 1;
            margin-left: 0;
            padding-left: 0;
        }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .ts-shop-wrapper {
            gap: 1.5rem;
            padding: 2rem 1rem;
        }

        .desktop-filters-container {
            width: 280px;
        }
    }

    @media (max-width: 768px) {
        .shop-page-banner {
            padding: 80px 0 60px;
            margin-top: 0px; /* Remove margin since navbar already has padding-top */
            min-height: 250px;
        }
        
        .shop-banner-title {
            font-size: 36px;
        }
        
        .shop-banner-breadcrumb li {
            font-size: 14px;
        }

        .ts-shop-wrapper {
            flex-direction: column;
            padding: 1.5rem 1rem;
            gap: 1rem;
        }

        .desktop-filters-container {
            display: none !important;
        }

        .mobile-filters-container {
            display: block !important;
            position: relative !important;
            left: auto !important;
            top: auto !important;
            width: 100% !important;
            margin-bottom: 1rem;
        }

        .ts-products-container {
            width: 100%;
            padding-left: 0 !important;
            margin-left: 0 !important;
        }

        .products-header {
            padding: 1rem;
            margin-bottom: 1rem;
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .sort-dropdown {
            width: 100%;
        }

        /* Filters positioning for mobile */
        .ts-shop-wrapper {
            position: relative;
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .shop-banner-title {
            font-size: 28px;
        }
        
        .shop-banner-breadcrumb li {
            font-size: 12px;
        }

        .ts-shop-wrapper {
            padding: 1rem 0.5rem;
        }

        .products-header {
            padding: 1rem 0.75rem;
        }
    }
</style>

<!-- Shop Banner -->
@if(isset($shopBanner) && $shopBanner->image)
<section class="shop-page-banner" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('storage/'.$shopBanner->image) }}') no-repeat center center/cover;">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="shop-banner-content">
                    <h2 class="shop-banner-title">{{ $shopBanner->title ?? 'Shop' }}</h2>
                    <ol class="shop-banner-breadcrumb">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Shop</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
@else
<section class="shop-page-banner" style="background: linear-gradient(135deg, var(--primary), var(--primary-light));">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="shop-banner-content">
                    <h2 class="shop-banner-title">Shop</h2>
                    <ol class="shop-banner-breadcrumb">
                        <li><a href="/">Home</a></li>
                        <li>Shop</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<div class="ts-shop-wrapper">
    <!-- Products Container -->
    <div class="ts-products-container">
        <!-- Mobile Filters - Positioned here on mobile, hidden on desktop -->
        <div class="mobile-filters-container">
            @include('web.shop.partials.filters')
        </div>

        <!-- Products Header -->
        <div class="products-header">
            <div class="products-count">
                <strong id="productCount">0</strong> products found
            </div>
            <select class="sort-dropdown" id="sortBy">
                <option value="default">Sort by Default</option>
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
                <option value="name">Name: A to Z</option>
                <option value="newest">Newest First</option>
            </select>
        </div>

        <!-- Products Grid -->
        @include('web.shop.partials.products-grid')
    </div>

    <!-- Desktop Filters - Positioned here on desktop, hidden on mobile -->
    <div class="desktop-filters-container">
        @include('web.shop.partials.filters')
    </div>
</div>

<!-- Include other partials -->
@include('web.shop.partials.quick-view-modal')
@include('web.shop.partials.cart-sidebar')
@include('web.shop.partials.toast')

<script>
// Sort functionality
document.addEventListener('DOMContentLoaded', function() {
    const sortDropdown = document.getElementById('sortBy');
    
    if (sortDropdown) {
        sortDropdown.addEventListener('change', function() {
            sortProducts(this.value);
        });
    }

    // Initial product count update
    updateProductCount();
});

function sortProducts(sortBy) {
    const productGrid = document.querySelector('.ts-product-grid');
    const products = Array.from(document.querySelectorAll('.ts-product-card'));
    
    products.sort((a, b) => {
        const priceA = parseFloat(a.dataset.price || 0);
        const priceB = parseFloat(b.dataset.price || 0);
        const titleA = (a.querySelector('.ts-product-title')?.textContent || '').toLowerCase();
        const titleB = (b.querySelector('.ts-product-title')?.textContent || '').toLowerCase();
        
        switch(sortBy) {
            case 'price-low':
                return priceA - priceB;
            case 'price-high':
                return priceB - priceA;
            case 'name':
                return titleA.localeCompare(titleB);
            case 'newest':
                // Assuming you have a data-created attribute
                const dateA = new Date(a.dataset.created || 0);
                const dateB = new Date(b.dataset.created || 0);
                return dateB - dateA;
            default:
                return 0;
        }
    });
    
    // Re-append sorted products
    products.forEach(product => {
        productGrid.appendChild(product);
    });
}

function updateProductCount() {
    const visibleProducts = document.querySelectorAll('.ts-product-card[style*="display: flex"], .ts-product-card:not([style*="display: none"])');
    const productCountElement = document.getElementById('productCount');
    
    if (productCountElement) {
        // Count products that are not hidden
        const totalProducts = document.querySelectorAll('.ts-product-card');
        let visibleCount = 0;
        
        totalProducts.forEach(product => {
            const style = product.style.display;
            if (style !== 'none') {
                visibleCount++;
            }
        });
        
        productCountElement.textContent = visibleCount;
    }
}

// Enhanced responsive handling
function handleResponsiveLayout() {
    const wrapper = document.querySelector('.ts-shop-wrapper');
    const filtersContainer = document.querySelector('.ts-filters-container');
    const isMobile = window.innerWidth <= 768;

    if (wrapper && filtersContainer) {
        if (isMobile) {
            // Mobile layout adjustments
            wrapper.style.flexDirection = 'column';
        } else {
            // Desktop layout
            wrapper.style.flexDirection = 'row';
        }
    }
}

// Improved touch support for mobile
function addTouchSupport() {
    if ('ontouchstart' in window) {
        const productCards = document.querySelectorAll('.ts-product-card');
        
        productCards.forEach(card => {
            const quickViewBtn = card.querySelector('.ts-quick-view-btn');
            
            if (quickViewBtn) {
                card.addEventListener('touchstart', () => {
                    quickViewBtn.style.opacity = '1';
                    quickViewBtn.style.transform = 'translate(-50%, -50%) scale(1)';
                });
                
                card.addEventListener('touchend', () => {
                    setTimeout(() => {
                        quickViewBtn.style.opacity = '0';
                        quickViewBtn.style.transform = 'translate(-50%, -50%) scale(0.8)';
                    }, 2000);
                });
            }
        });
    }
}

// Listen for window resize
window.addEventListener('resize', handleResponsiveLayout);

// Initialize on page load
window.addEventListener('load', function() {
    handleResponsiveLayout();
    addTouchSupport();
    updateProductCount();
});

// Intersection Observer for lazy loading (if needed)
function initLazyLoading() {
    const productImages = document.querySelectorAll('.ts-product-image[data-src]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        productImages.forEach(img => imageObserver.observe(img));
    }
}

// Initialize lazy loading if applicable
</script>

@push('scripts')
<script src="{{ asset('js/cart-manager.js') }}"></script>
<script src="{{ asset('assets/js/shop.js') }}"></script>
@endpush

@endsection