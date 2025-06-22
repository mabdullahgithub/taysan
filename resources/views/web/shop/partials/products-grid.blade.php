    <!-- Your filter sidebar here -->
    
    <div class="ts-product-grid" style="flex: 1 !important; display: grid !important; align-content: start !important; margin-left: 0 !important;">
    
    <style>
        /* Mobile view - 2 products per row */
        .ts-product-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 1rem !important;
        }
        
        /* Tablet view - 3 products per row */
        @media (min-width: 768px) {
            .ts-product-grid {
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 1.25rem !important;
            }
        }
        
        /* Laptop view - 4 products per row */
        @media (min-width: 1024px) {
            .ts-product-grid {
                grid-template-columns: repeat(4, 1fr) !important;
                gap: 1.5rem !important;
            }
        }
    </style>
        @foreach($products as $product)
            <div class="ts-product-card" 
                 data-price="{{ $product->price }}" 
                 data-category="{{ $product->category_id }}"
                 style="background: #fff !important; border-radius: 12px !important; overflow: hidden !important; transition: all 0.3s ease !important; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08) !important; display: flex !important; flex-direction: column !important;">
                
                <div class="ts-product-image-wrapper" style="position: relative !important; padding-top: 100% !important; background: #f8f9fa !important; overflow: hidden !important;">
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         style="position: absolute !important; top: 0 !important; left: 0 !important; width: 100% !important; height: 100% !important; object-fit: cover !important; transition: transform 0.5s ease !important;">
                    
                    <button class="ts-quick-view-btn" 
                            data-bs-toggle="modal" 
                            data-bs-target="#quickViewModal"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->price }}"
                            data-description="{{ $product->description }}"
                            data-category="{{ $product->category->name }}"
                            data-image="{{ asset('storage/' . $product->image) }}"
                            style="position: absolute !important; top: 1rem !important; right: 1rem !important; width: 35px !important; height: 35px !important; border-radius: 50% !important; background: rgba(255, 255, 255, 0.9) !important; border: none !important; display: flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; transition: all 0.3s ease !important; z-index: 1 !important;">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <div class="ts-product-details" style="padding: 1.25rem !important; display: flex !important; flex-direction: column !important; gap: 0.75rem !important;">
                    <h3 class="ts-product-title" style="font-size: 1.1rem !important; font-weight: 600 !important; color: #333 !important; margin: 0 !important; line-height: 1.4 !important;">
                        {{ $product->name }}
                    </h3>
                    
                    <div class="ts-product-meta" style="display: flex !important; justify-content: space-between !important; align-items: center !important;">
                        <span class="ts-product-category" style="color: #666 !important; font-size: 0.9rem !important;">
                            {{ $product->category->name }}
                        </span>
                        <span class="ts-product-price" style="color: #8D68AD !important; font-weight: 700 !important; font-size: 1.15rem !important;">
                            ${{ number_format($product->price, 0) }}
                        </span>
                    </div>

                    <button class="ts-add-to-cart-btn"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->price }}"
                            data-image="{{ asset('storage/' . $product->image) }}"
                            style="width: 100% !important; padding: 0.75rem !important; background: #8D68AD !important; color: #fff !important; border: none !important; border-radius: 6px !important; font-weight: 500 !important; display: flex !important; align-items: center !important; justify-content: center !important; gap: 0.5rem !important; cursor: pointer !important; transition: all 0.3s ease !important; margin-top: auto !important;">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
                </div>
            </div>
        @endforeach
    </div>

<script>
// Add hover effects since we can't do it with inline styles
document.querySelectorAll('.ts-product-card').forEach(card => {
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-5px)';
        card.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.12)';
        card.querySelector('img').style.transform = 'scale(1.05)';
        card.querySelector('.ts-quick-view-btn').style.opacity = '1';
        card.querySelector('.ts-quick-view-btn').style.transform = 'translateY(0)';
    });

    card.addEventListener('mouseleave', () => {
        card.style.transform = 'none';
        card.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.08)';
        card.querySelector('img').style.transform = 'none';
        card.querySelector('.ts-quick-view-btn').style.opacity = '0';
        card.querySelector('.ts-quick-view-btn').style.transform = 'translateY(-10px)';
    });
});

document.querySelectorAll('.ts-add-to-cart-btn').forEach(btn => {
    btn.addEventListener('mouseenter', () => {
        btn.style.background = '#735891';
        btn.style.transform = 'translateY(-2px)';
    });

    btn.addEventListener('mouseleave', () => {
        btn.style.background = '#8D68AD';
        btn.style.transform = 'none';
    });
});
</script>