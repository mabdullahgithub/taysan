<div class="filters-outer-wrapper">
    <!-- Mobile Filter Toggle Button -->
    <button class="mobile-filter-toggle" onclick="toggleMobileFilters()" style="
        display: none;
        width: 40px;
        height: 40px;
        padding: 8px;
        background: #8D68AD;
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        margin-bottom: 1rem;
        align-items: center;
        justify-content: center;
        gap: 0;
        position: relative;
        box-shadow: 0 2px 8px rgba(141, 104, 173, 0.3);
    ">
        <i class="fas fa-filter"></i>
    </button>

    <div class="ts-filters-container" id="filtersContainer" style="
        width: 300px;
        position: sticky;
        top: 130px; /* Adjust to match the top banner height */
        overflow-y: auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 20px;
        background: white;
        z-index: 100;
    ">
<!-- Search Filter -->
    <div style="margin-bottom: 25px !important;">
        <h3 style="font-size: 18px !important; color: #333 !important; margin-bottom: 15px !important;">Search Products</h3>
        <div style="position: relative !important;">
            <i class="fas fa-search" style="position: absolute !important; left: 12px !important; top: 50% !important; transform: translateY(-50%) !important; color: #8D68AD !important;"></i>
            <input type="text" id="searchInput" placeholder="Search products..." 
                   style="width: 100% !important; padding: 10px 10px 10px 35px !important; border: 1px solid #e0e0e0 !important; border-radius: 8px !important; font-size: 14px !important;">
        </div>
    </div>

    <!-- Price Range Filter -->
    <div style="margin-bottom: 25px !important;">
        <h3 style="font-size: 18px !important; color: #333 !important; margin-bottom: 15px !important;">Price Range</h3>
        <label style="display: block !important; margin-bottom: 10px !important; color: #666 !important;">
            <span id="priceRangeValue">$0 - $1000</span>
        </label>
        <input type="range" id="priceRange" min="0" max="1000" value="1000" step="50"
               style="width: 100% !important; height: 6px !important; -webkit-appearance: none !important; background: #e0e0e0 !important; border-radius: 3px !important; outline: none !important;">
    </div>

    <!-- Category Filter -->
    <div style="margin-bottom: 25px !important;">
        <h3 style="font-size: 18px !important; color: #333 !important; margin-bottom: 15px !important;">Categories</h3>
        <div style="display: flex !important; flex-direction: column !important; gap: 10px !important;">
            <label style="display: flex !important; align-items: center !important; gap: 10px !important; cursor: pointer !important;">
                <input type="radio" name="category" value="all" checked 
                       style="accent-color: #8D68AD !important;">
                <span style="color: #666 !important;">All Categories</span>
            </label>
            @foreach($categories as $category)
                <label style="display: flex !important; align-items: center !important; gap: 10px !important; cursor: pointer !important;">
                    <input type="radio" name="category" value="{{ $category->id }}"
                           style="accent-color: #8D68AD !important;">
                    <span style="color: #666 !important;">{{ $category->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <!-- Reset Button -->
    <button onclick="resetFilters()" 
            style="width: 100% !important; padding: 12px !important; background: #8D68AD !important; color: white !important; border: none !important; border-radius: 8px !important; cursor: pointer !important; transition: all 0.3s ease !important; font-weight: 500 !important;">
        Reset Filters
    </button>
    </div>
</div>

<script>
function resetFilters() {
    // Reset search
    document.getElementById('searchInput').value = '';
    
    // Reset price range
    const priceRange = document.getElementById('priceRange');
    priceRange.value = priceRange.max;
    document.getElementById('priceRangeValue').textContent = `$0 - $${priceRange.max}`;
    
    // Reset category selection
    document.querySelector('input[name="category"][value="all"]').checked = true;
    
    // Trigger filter update to show all products
    updateFilters();
}

function updateFilters() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const priceLimit = document.getElementById('priceRange').value;
    const selectedCategory = document.querySelector('input[name="category"]:checked').value;
    
    const products = document.querySelectorAll('.ts-product-card');
    
    products.forEach(product => {
        const price = parseFloat(product.dataset.price);
        const category = product.dataset.category;
        const title = product.querySelector('.ts-product-title').textContent.toLowerCase();
        
        const matchesSearch = title.includes(searchTerm);
        const matchesPrice = price <= priceLimit;
        const matchesCategory = selectedCategory === 'all' || category === selectedCategory;
        
        if (matchesSearch && matchesPrice && matchesCategory) {
            product.style.display = 'flex';
        } else {
            product.style.display = 'none';
        }
    });
}

// Event listeners
document.getElementById('searchInput').addEventListener('input', updateFilters);
document.getElementById('priceRange').addEventListener('input', (e) => {
    document.getElementById('priceRangeValue').textContent = `$0 - $${e.target.value}`;
    updateFilters();
});
document.querySelectorAll('input[name="category"]').forEach(radio => {
    radio.addEventListener('change', updateFilters);
});

// Initial call to set up filters
updateFilters();

// Mobile filters toggle functionality
function toggleMobileFilters() {
    const filtersContainer = document.getElementById('filtersContainer');
    const chevron = document.querySelector('.filter-chevron');
    
    if (filtersContainer.style.display === 'none' || filtersContainer.style.display === '') {
        filtersContainer.style.display = 'block';
        chevron.style.transform = 'rotate(180deg)';
    } else {
        filtersContainer.style.display = 'none';
        chevron.style.transform = 'rotate(0deg)';
    }
}
</script>

<style>
/* Mobile Responsive Filters */
@media (max-width: 768px) {
    .mobile-filter-toggle {
        display: flex !important;
    }
    
    .ts-filters-container {
        display: none;
        width: 100% !important;
        position: relative !important;
        top: auto !important;
        margin-bottom: 1rem !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    }
    
    .filter-chevron {
        transition: transform 0.3s ease;
    }
}

@media (min-width: 769px) {
    .mobile-filter-toggle {
        display: none !important;
    }
    
    .ts-filters-container {
        display: block !important;
    }
}
</style>


