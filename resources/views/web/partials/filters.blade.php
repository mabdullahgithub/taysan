
<div class="shop-section">
    <div class="container">
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
    </div>
</div>
