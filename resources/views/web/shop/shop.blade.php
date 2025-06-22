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

    .mobile-controls {
        display: none;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        width: 100%;
    }

    .desktop-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .mobile-filter-btn, .mobile-sort-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: linear-gradient(135deg, #8D68AD 0%, #A67BC9 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(141, 104, 173, 0.25);
        position: relative;
        overflow: hidden;
        min-width: 100px;
    }

    .mobile-filter-btn::before, .mobile-sort-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .mobile-filter-btn:hover::before, .mobile-sort-btn:hover::before {
        left: 100%;
    }

    .mobile-filter-btn:hover, .mobile-sort-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(141, 104, 173, 0.35);
    }

    .mobile-filter-btn:active, .mobile-sort-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(141, 104, 173, 0.25);
    }

    .mobile-filter-btn i, .mobile-sort-btn i {
        font-size: 0.9rem;
    }

    .sort-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .mobile-sort-icon {
        display: none;
        color: var(--primary);
        font-size: 16px;
        cursor: pointer;
        padding: 8px;
        border-radius: 50%;
        background: rgba(141, 104, 173, 0.1);
        transition: all 0.3s ease;
    }

    .mobile-sort-icon:hover {
        background: rgba(141, 104, 173, 0.2);
        transform: scale(1.1);
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
            width: auto !important;
            margin-bottom: 0;
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

        .mobile-controls {
            display: flex !important;
            width: 100%;
            justify-content: space-between;
            padding: 0 1rem;
        }

        .desktop-controls {
            display: none !important;
        }

        .sort-dropdown {
            display: none;
        }

        .mobile-sort-icon {
            display: flex !important;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            box-shadow: 0 2px 8px rgba(141, 104, 173, 0.3);
        }

        .products-count {
            order: -1;
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

    /* Filter Modal Styles */
.filter-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
}

.filter-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.filter-modal-content {
    background: white;
    border-radius: 16px;
    max-width: 400px;
    width: 100%;
    max-height: 80vh;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    display: flex;
    flex-direction: column;
}

.filter-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #e0e0e0;
    background: linear-gradient(135deg, #8D68AD 0%, #A67BC9 100%);
    color: white;
}

.filter-modal-header h3 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.filter-modal-close {
    background: none;
    border: none;
    color: white;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    transition: background 0.3s ease;
}

.filter-modal-close:hover {
    background: rgba(255, 255, 255, 0.2);
}

.filter-modal-body {
    padding: 1.5rem;
    overflow-y: auto;
    flex: 1;
}

.filter-modal-footer {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    border-top: 1px solid #e0e0e0;
    background: #f8f9fa;
}

.btn-reset-filter, .btn-apply-filter {
    flex: 1;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-reset-filter {
    background: #f1f3f4;
    color: #5f6368;
    border: 1px solid #dadce0;
}

.btn-reset-filter:hover {
    background: #e8eaed;
    border-color: #c1c7cd;
}

.btn-apply-filter {
    background: linear-gradient(135deg, #8D68AD 0%, #A67BC9 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(141, 104, 173, 0.25);
}

.btn-apply-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(141, 104, 173, 0.35);
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
        <!-- Products Header -->
        <div class="products-header">
            <div class="mobile-controls">
                <button class="mobile-filter-btn" onclick="openFilterModal()">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                </button>
                <button class="mobile-sort-btn" onclick="showMobileSortOptions()">
                    <i class="fas fa-sort"></i>
                    <span>Sort</span>
                </button>
            </div>
            <div class="desktop-controls">
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
        </div>

        <!-- Products Grid -->
        @include('web.shop.partials.products-grid')
    </div>

    <!-- Desktop Filters - Positioned here on desktop, hidden on mobile -->
    <div class="desktop-filters-container">
        @include('web.shop.partials.filters')
    </div>
</div>

<!-- Filter Modal -->
<div id="filterModal" class="filter-modal" style="display: none;">
    <div class="filter-modal-overlay">
        <div class="filter-modal-content">
            <div class="filter-modal-header">
                <h3>Filter Products</h3>
                <button onclick="closeFilterModal()" class="filter-modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="filter-modal-body">
                @include('web.shop.partials.filters-content')
            </div>
            <div class="filter-modal-footer">
                <button onclick="resetFilters()" class="btn-reset-filter">
                    <i class="fas fa-refresh"></i>
                    Reset
                </button>
                <button onclick="applyFilters()" class="btn-apply-filter">
                    <i class="fas fa-check"></i>
                    Apply Filters
                </button>
            </div>
        </div>
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
    const mobileSortIcon = document.querySelector('.mobile-sort-icon');
    
    if (sortDropdown) {
        sortDropdown.addEventListener('change', function() {
            sortProducts(this.value);
        });
    }

    // Mobile sort icon functionality
    if (mobileSortIcon) {
        mobileSortIcon.addEventListener('click', function() {
            showMobileSortOptions();
        });
    }

    // Initial product count update
    updateProductCount();
});

// Mobile sort options popup
function showMobileSortOptions() {
    const sortOptions = [
        { value: 'default', text: 'Sort by Default' },
        { value: 'price-low', text: 'Price: Low to High' },
        { value: 'price-high', text: 'Price: High to Low' },
        { value: 'name', text: 'Name: A to Z' },
        { value: 'newest', text: 'Newest First' }
    ];

    // Create modal overlay
    const overlay = document.createElement('div');
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
    `;

    // Create modal
    const modal = document.createElement('div');
    modal.style.cssText = `
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        max-width: 300px;
        width: 80%;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    `;

    // Create header
    const header = document.createElement('div');
    header.style.cssText = `
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e0e0e0;
    `;
    header.innerHTML = `
        <h3 style="margin: 0; color: #333; font-size: 1.1rem;">Sort Products</h3>
        <button onclick="this.closest('.sort-modal-overlay').remove()" style="
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #666;
            cursor: pointer;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        ">×</button>
    `;

    // Create options
    const optionsContainer = document.createElement('div');
    sortOptions.forEach(option => {
        const optionElement = document.createElement('div');
        optionElement.style.cssText = `
            padding: 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s ease;
            margin-bottom: 0.5rem;
            border: 1px solid #e0e0e0;
        `;
        optionElement.textContent = option.text;
        
        optionElement.addEventListener('click', function() {
            document.getElementById('sortBy').value = option.value;
            sortProducts(option.value);
            overlay.remove();
        });

        optionElement.addEventListener('mouseenter', function() {
            this.style.background = '#f8f9fa';
        });

        optionElement.addEventListener('mouseleave', function() {
            this.style.background = 'white';
        });

        optionsContainer.appendChild(optionElement);
    });

    modal.appendChild(header);
    modal.appendChild(optionsContainer);
    overlay.appendChild(modal);
    overlay.className = 'sort-modal-overlay';

    // Close on overlay click
    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) {
            overlay.remove();
        }
    });

    document.body.appendChild(overlay);
}

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

// Filter Modal Functions
function openFilterModal() {
    document.getElementById('filterModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Sync current filter values to modal
    syncFiltersToModal();
}

function closeFilterModal() {
    document.getElementById('filterModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function syncFiltersToModal() {
    // Sync search input
    const mainSearch = document.getElementById('searchInput');
    const modalSearch = document.getElementById('modalSearchInput');
    if (mainSearch && modalSearch) {
        modalSearch.value = mainSearch.value;
    }
    
    // Sync price range
    const mainPrice = document.getElementById('priceRange');
    const modalPrice = document.getElementById('modalPriceRange');
    if (mainPrice && modalPrice) {
        modalPrice.value = mainPrice.value;
        document.getElementById('modalPriceRangeValue').textContent = `$0 - $${modalPrice.value}`;
    }
    
    // Sync category selection
    const mainCategory = document.querySelector('input[name="category"]:checked');
    const modalCategory = document.querySelector(`input[name="modalCategory"][value="${mainCategory ? mainCategory.value : 'all'}"]`);
    if (modalCategory) {
        modalCategory.checked = true;
    }
}

function applyFilters() {
    // Sync modal values back to main filters
    const modalSearch = document.getElementById('modalSearchInput');
    const mainSearch = document.getElementById('searchInput');
    if (modalSearch && mainSearch) {
        mainSearch.value = modalSearch.value;
    }
    
    const modalPrice = document.getElementById('modalPriceRange');
    const mainPrice = document.getElementById('priceRange');
    if (modalPrice && mainPrice) {
        mainPrice.value = modalPrice.value;
        document.getElementById('priceRangeValue').textContent = `$0 - $${modalPrice.value}`;
    }
    
    const modalCategory = document.querySelector('input[name="modalCategory"]:checked');
    const mainCategory = document.querySelector(`input[name="category"][value="${modalCategory ? modalCategory.value : 'all'}"]`);
    if (mainCategory) {
        mainCategory.checked = true;
    }
    
    // Apply the filters
    updateFilters();
    
    // Close modal
    closeFilterModal();
}

function resetFilters() {
    // Reset main filters
    const searchInput = document.getElementById('searchInput');
    const modalSearchInput = document.getElementById('modalSearchInput');
    if (searchInput) searchInput.value = '';
    if (modalSearchInput) modalSearchInput.value = '';
    
    // Reset price range
    const priceRange = document.getElementById('priceRange');
    const modalPriceRange = document.getElementById('modalPriceRange');
    if (priceRange) {
        priceRange.value = priceRange.max;
        document.getElementById('priceRangeValue').textContent = `$0 - $${priceRange.max}`;
    }
    if (modalPriceRange) {
        modalPriceRange.value = modalPriceRange.max;
        document.getElementById('modalPriceRangeValue').textContent = `$0 - $${modalPriceRange.max}`;
    }
    
    // Reset category selection
    const allCategoryMain = document.querySelector('input[name="category"][value="all"]');
    const allCategoryModal = document.querySelector('input[name="modalCategory"][value="all"]');
    if (allCategoryMain) allCategoryMain.checked = true;
    if (allCategoryModal) allCategoryModal.checked = true;
    
    // Apply the reset
    updateFilters();
    
    // Close modal if open
    closeFilterModal();
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('filterModal');
    if (e.target === modal) {
        closeFilterModal();
    }
});

// ...existing code...
</script>

@push('scripts')
<script src="{{ asset('js/cart-manager.js') }}"></script>
<script src="{{ asset('assets/js/shop.js') }}"></script>
@endpush

@endsection