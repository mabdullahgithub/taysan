<!-- Search Filter -->
<div style="margin-bottom: 25px !important;">
    <h3 style="font-size: 18px !important; color: #333 !important; margin-bottom: 15px !important;">Search Products</h3>
    <div style="position: relative !important;">
        <i class="fas fa-search" style="position: absolute !important; left: 12px !important; top: 50% !important; transform: translateY(-50%) !important; color: #8D68AD !important;"></i>
        <input type="text" id="modalSearchInput" placeholder="Search products..." 
               style="width: 100% !important; padding: 10px 10px 10px 35px !important; border: 1px solid #e0e0e0 !important; border-radius: 8px !important; font-size: 14px !important;">
    </div>
</div>

<!-- Price Range Filter -->
<div style="margin-bottom: 25px !important;">
    <h3 style="font-size: 18px !important; color: #333 !important; margin-bottom: 15px !important;">Price Range</h3>
    <label style="display: block !important; margin-bottom: 10px !important; color: #666 !important;">
        <span id="modalPriceRangeValue">$0 - $1000</span>
    </label>
    <input type="range" id="modalPriceRange" min="0" max="1000" value="1000" step="50"
           style="width: 100% !important; height: 6px !important; -webkit-appearance: none !important; background: #e0e0e0 !important; border-radius: 3px !important; outline: none !important;">
</div>

<!-- Category Filter -->
<div style="margin-bottom: 25px !important;">
    <h3 style="font-size: 18px !important; color: #333 !important; margin-bottom: 15px !important;">Categories</h3>
    <div style="display: flex !important; flex-direction: column !important; gap: 10px !important;">
        <label style="display: flex !important; align-items: center !important; gap: 10px !important; cursor: pointer !important;">
            <input type="radio" name="modalCategory" value="all" checked 
                   style="accent-color: #8D68AD !important;">
            <span style="color: #666 !important;">All Categories</span>
        </label>
        @if(isset($categories))
            @foreach($categories as $category)
                <label style="display: flex !important; align-items: center !important; gap: 10px !important; cursor: pointer !important;">
                    <input type="radio" name="modalCategory" value="{{ $category->id }}"
                           style="accent-color: #8D68AD !important;">
                    <span style="color: #666 !important;">{{ $category->name }}</span>
                </label>
            @endforeach
        @endif
    </div>
</div>

<script>
// Price range slider for modal
document.getElementById('modalPriceRange').addEventListener('input', function() {
    document.getElementById('modalPriceRangeValue').textContent = `$0 - $${this.value}`;
});
</script>
