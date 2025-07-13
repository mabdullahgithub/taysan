@extends('web.layout.app')
@section('content')
    @include('web.partials.cart_related')
    <!-- Quick View Modal -->
    @include('web.shop.partials.quick-view-modal')

    <!-- Cart Sidebar -->
    @include('web.shop.partials.cart-sidebar')
    @include('web.shop.partials.toast')

<!-- Banner Carousel -->
<div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <!-- First Slide -->
        <div class="carousel-item active">
            <div class="banner-bg"></div>
            <div class="banner-overlay"></div>
            <div class="banner-content">
                <div class="banner-text">
                    <div class="banner-subtitle">Premium Natural Beauty</div>
                    <h1 class="banner-title">Taysan Beauty</h1>
                    <p class="cursive-text">handcrafted with love</p>
                    <p class="banner-description">Discover our luxurious collection of handmade soaps and natural skincare products, crafted with pure ingredients to nourish and pamper your skin.</p>
                    <div class="banner-actions">
                        <div class="live-tag">NEW ARRIVALS</div>
                        <a href="/shop" class="shop-btn">Explore Collection</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Banner Styles */
.carousel {
    position: relative;
    height: 700px;
    overflow: hidden;
    margin-top: 0; /* Ensure no gap from navbar */
}

.carousel-item {
    height: 700px;
    position: relative;
}

.banner-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('assets/ban1.png');
    background-size: cover;
    background-position: center;
    filter: blur(0px);
}

/* Gradient overlay for better text readability */
.banner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        135deg,
        rgba(0, 0, 0, 0.6) 0%,
        rgba(0, 0, 0, 0.3) 50%,
        rgba(153, 119, 181, 0.4) 100%
    );
    z-index: 1;
}

.banner-content {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
    padding: 0 5%;
    z-index: 2;
}

.banner-text {
    text-align: left;
    color: white;
    max-width: 650px;
    animation: slideInLeft 1s ease-out;
}

/* Enhanced text styling */
.banner-subtitle {
    color: #A67BC9;
    font-size: 1rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 1rem;
    opacity: 0.9;
    animation: fadeInUp 1s ease-out 0.2s both;
}

.banner-title {
    font-size: 4rem;
    margin-bottom: 1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 3px;
    background: linear-gradient(135deg, #ffffff 0%, #A67BC9 50%, #ffffff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    animation: slideInRight 1s ease-out 0.4s both;
    line-height: 1.1;
}

.cursive-text {
    font-family: 'Dancing Script', cursive;
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
    color: #ffffff;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    font-weight: 600;
    animation: fadeInUp 1s ease-out 0.6s both;
}

.banner-description {
    font-size: 1.1rem;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
    max-width: 500px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    animation: fadeInUp 1s ease-out 0.8s both;
}

.banner-actions {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    flex-wrap: wrap;
    animation: fadeInUp 1s ease-out 1s both;
}

.live-tag {
    display: inline-block;
    padding: 12px 28px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    color: #9977B5;
    font-size: 0.9rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-weight: 700;
    border-radius: 30px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.live-tag::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.5s;
}

.live-tag:hover::before {
    left: 100%;
}

.live-tag:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.shop-btn {
    display: inline-block;
    padding: 14px 32px;
    background: transparent;
    color: #ffffff;
    border: 2px solid #ffffff;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.shop-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #9977B5, #A67BC9);
    transition: left 0.3s ease;
    z-index: -1;
}

.shop-btn:hover::before {
    left: 0;
}

.shop-btn:hover {
    color: #ffffff;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(153, 119, 181, 0.4);
}

/* Animations */
@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Carousel Controls */
.carousel-control-prev,
.carousel-control-next {
    width: 5%;
    z-index: 3;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(153, 119, 181, 0.7);
    border-radius: 50%;
    padding: 25px;
    transition: all 0.3s ease;
}

.carousel-control-prev-icon:hover,
.carousel-control-next-icon:hover {
    background-color: rgba(153, 119, 181, 0.9);
    transform: scale(1.1);
}

/* Responsive Styles */
@media (max-width: 1200px) {
    .carousel,
    .carousel-item {
        height: 600px;
    }
    
    .banner-title {
        font-size: 3.5rem;
    }
    
    .banner-description {
        font-size: 1rem;
    }
}

@media (max-width: 992px) {
    .carousel,
    .carousel-item {
        height: 500px;
    }
    
    .banner-title {
        font-size: 3rem;
    }
    
    .cursive-text {
        font-size: 2.2rem;
    }
    
    .banner-description {
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }
}

@media (max-width: 768px) {
    .carousel,
    .carousel-item {
        height: 450px;
        margin-top: 0; /* Ensure no gap between navbar and banner */
    }
    
    .banner-text {
        text-align: center;
        max-width: 100%;
    }
    
    .banner-title {
        font-size: 2.5rem;
        letter-spacing: 2px;
    }
    
    .cursive-text {
        font-size: 2rem;
    }
    
    .banner-subtitle {
        font-size: 0.9rem;
        letter-spacing: 2px;
    }
    
    .banner-description {
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }
    
    .live-tag {
        padding: 10px 24px;
        font-size: 0.8rem;
    }
    
    .shop-btn {
        padding: 12px 28px;
        font-size: 0.9rem;
    }
    
    .banner-actions {
        justify-content: center;
        gap: 1rem;
    }
}

@media (max-width: 576px) {
    .carousel,
    .carousel-item {
        height: 400px;
        margin-top: 0; /* Ensure no gap between navbar and banner */
    }
    
    .banner-title {
        font-size: 2rem;
        letter-spacing: 1px;
    }
    
    .cursive-text {
        font-size: 1.6rem;
        margin-bottom: 1rem;
    }
    
    .banner-subtitle {
        font-size: 0.8rem;
        letter-spacing: 1px;
        margin-bottom: 0.8rem;
    }
    
    .banner-description {
        font-size: 0.85rem;
        margin-bottom: 1.2rem;
    }
    
    .live-tag {
        padding: 8px 20px;
        font-size: 0.75rem;
    }
    
    .shop-btn {
        padding: 10px 24px;
        font-size: 0.85rem;
    }
    
    .banner-actions {
        flex-direction: column;
        gap: 0.8rem;
        width: 100%;
    }
    
    .banner-actions .live-tag,
    .banner-actions .shop-btn {
        width: 100%;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .carousel,
    .carousel-item {
        height: 350px;
        margin-top: 0; /* Ensure no gap between navbar and banner */
    }
    
    .banner-content {
        padding: 0 3%;
    }
    
    .banner-title {
        font-size: 1.8rem;
    }
    
    .cursive-text {
        font-size: 1.4rem;
    }
}    </style>

    <!-- Deal of the Day Section -->
    @if($deals->count() > 0)
    <section class="deal-of-the-day py-5" style="background: #ffffff;">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-subtitle" style="color: #8D68AD; text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem; display: block; margin-bottom: 0.5rem;">Limited Time Offer</span>
                <h2 class="section-title" style="font-size: 2.5rem; font-weight: 300; margin-bottom: 2rem; color: #333;">
                    <i class="fas fa-fire" style="color: #ff6b6b; margin-right: 0.5rem;"></i>
                    Deal of the Day
                </h2>
            </div>

            <div class="row justify-content-center">
                @foreach($deals as $deal)
                <div class="col-xl-4 col-lg-4 col-md-6 col-6 mb-4" id="deal-{{ $deal->id }}">
                    <div class="premium-deal-card">
                        <div class="deal-badge-premium">
                            @if($deal->discount_percentage > 0)
                                <span class="discount-percentage">{{ round($deal->discount_percentage) }}%</span>
                                <span class="discount-text">OFF</span>
                            @else
                                <span class="discount-text">SPECIAL</span>
                            @endif
                        </div>
                        
                        <div class="deal-image-premium">
                            @if($deal->product->image)
                                <img src="{{ asset('storage/' . $deal->product->image) }}" 
                                     alt="{{ $deal->product->name }}" 
                                     class="img-fluid">
                            @else
                                <div class="image-placeholder-premium">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="deal-content-premium">
                            <h3 class="deal-title-premium">{{ $deal->deal_title ?: $deal->product->name }}</h3>
                            <div class="deal-description-premium">
                                {{ Str::limit($deal->deal_description ?: $deal->product->description, 80) }}
                            </div>
                            
                            <div class="deal-pricing-premium">
                                @if($deal->savings > 0)
                                    <span class="original-price-premium">PKR {{ number_format($deal->product->price, 0) }}</span>
                                @endif
                                <span class="deal-price-premium">PKR {{ number_format($deal->final_price, 0) }}</span>
                                @if($deal->savings > 0)
                                    <span class="savings-premium">Save PKR {{ number_format($deal->savings, 0) }}</span>
                                @endif
                            </div>
                            
                            <div class="deal-timer-premium">
                                <i class="fas fa-clock"></i>
                                Ends {{ $deal->end_date->format('M j, Y') }}
                            </div>
                            
                            <div class="deal-buttons-premium">
                                <a href="{{ route('web.product.show', $deal->product) }}?from=deal" class="deal-view-btn-premium">
                                    View
                                </a>
                                
                                <button class="deal-shop-btn-premium" 
                                        data-id="{{ $deal->product->id }}" 
                                        data-name="{{ $deal->product->name }}" 
                                        data-price="{{ $deal->final_price }}" 
                                        data-image="{{ $deal->product->image ? asset('storage/' . $deal->product->image) : '' }}">
                                    Shop Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Best Selling Products Carousel Section -->
    <section class="best-selling-products py-5" style="background: #f8f9fa;">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-subtitle" style="color: #8D68AD; text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem; display: block; margin-bottom: 0.5rem;">Top Picks</span>
                <h2 class="section-title" style="font-size: 2.5rem; color: #333; font-weight: 300;">Best Selling Products</h2>
            </div>

            <!-- Best Selling Products Carousel -->
            <div class="best-selling-carousel-container">
                <!-- Carousel Wrapper -->
                <div class="products-carousel-wrapper">
                    <div class="products-carousel" id="bestSellingCarousel">
                        @foreach ($topPicks as $product)
                            <div class="carousel-product-card">
                                <div class="ts-product-image-wrapper">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    
                                    <!-- Dynamic Badge based on sold count or flag -->
                                    @if($product->sold_count > 5 || $product->flag == 'Best Seller')
                                        <div class="product-badge">
                                            <span>Best Seller</span>
                                        </div>
                                    @elseif($product->flag == 'Featured')
                                        <div class="product-badge">
                                            <span>Featured</span>
                                        </div>
                                    @elseif($product->flag == 'New Arrivals')
                                        <div class="product-badge" style="background: #17a2b8;">
                                            <span>New</span>
                                        </div>
                                    @endif

                                    <button class="ts-quick-view-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"
                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                        data-price="{{ $product->price }}" data-description="{{ $product->description }}"
                                        data-category="{{ $product->category->name }}"
                                        data-image="{{ asset('storage/' . $product->image) }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                <div class="ts-product-details">
                                    <h3 class="ts-product-title">{{ $product->name }}</h3>

                                    <div class="ts-product-meta">
                                        <span class="ts-product-category">{{ $product->category->name }}</span>
                                        <span class="ts-product-price">PKR {{ number_format($product->price, 0) }}</span>
                                    </div>

                                    <div class="product-card-actions">
                                        <a href="{{ route('web.product.show', $product) }}" class="ts-view-product-btn">
                                            <i class="fas fa-eye"></i>
                                            View
                                        </a>
                                        <button class="ts-add-to-cart-btn" data-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                            data-image="{{ asset('storage/' . $product->image) }}">
                                            <i class="fas fa-shopping-cart"></i>
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Carousel Indicators -->
                <div class="carousel-indicators" id="bestSellingIndicators">
                    <!-- Will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </section>

    <!-- Random Products Section -->
    @if(\App\Models\Setting::get('discover_more_section_enabled', '1') == '1' && isset($randomProducts) && $randomProducts->count() > 0)
    <section class="random-products py-5" style="background: #f8f9fa;">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-subtitle" style="color: #8D68AD; text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem; display: block; margin-bottom: 0.5rem;">Discover More</span>
                <h2 class="section-title" style="font-size: 2.5rem; color: #333; font-weight: 300;">Handpicked for You</h2>
            </div>

            <!-- Products Grid -->
            <div class="row">
                @foreach($randomProducts as $product)
                    <div class="col-6 col-lg-2dot4 mb-4 discover-product-col">
                        <div class="carousel-product-card h-100">
                            <div class="ts-product-image-wrapper">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                
                                <!-- Dynamic Badge based on sold count or flag -->
                                @if($product->sold_count > 5 || $product->flag == 'Best Seller')
                                    <div class="product-badge">
                                        <span>Best Seller</span>
                                    </div>
                                @elseif($product->flag == 'Featured')
                                    <div class="product-badge">
                                        <span>Featured</span>
                                    </div>
                                @elseif($product->flag == 'New Arrivals')
                                    <div class="product-badge" style="background: #17a2b8;">
                                        <span>New</span>
                                    </div>
                                @endif

                                <button class="ts-quick-view-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"
                                    data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                    data-price="{{ $product->price }}" data-description="{{ $product->description }}"
                                    data-category="{{ $product->category->name }}"
                                    data-image="{{ asset('storage/' . $product->image) }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>

                            <div class="ts-product-details">
                                <h3 class="ts-product-title">{{ $product->name }}</h3>

                                <div class="ts-product-meta">
                                    <span class="ts-product-category">{{ $product->category->name }}</span>
                                    <span class="ts-product-price">PKR {{ number_format($product->price, 0) }}</span>
                                </div>

                                <div class="product-card-actions">
                                    <a href="{{ route('web.product.show', $product) }}" class="ts-view-product-btn">
                                        <i class="fas fa-eye"></i>
                                        View
                                    </a>
                                    <button class="ts-add-to-cart-btn" data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                        data-image="{{ asset('storage/' . $product->image) }}">
                                        <i class="fas fa-shopping-cart"></i>
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- View All Button -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="/shop" class="btn btn-outline-primary btn-lg" 
                       style="border: 2px solid #667eea; color: #667eea; border-radius: 30px; padding: 12px 40px; font-weight: 500; transition: all 0.3s ease;">
                        View All Products
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Sale Banner Section -->
    <section class="home-sale py-5">
        <div class="container">
            <div class="home-sale__wrap">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="home-sale__content">
                            <h2 class="home-sale__title" style="color: #fff !important;">Beauty Weekend Sale</h2>
                            <p class="home-sale__text" style="color: #fff !important;">Up to 40% off on natural skincare & handmade soaps</p>
                            <div class="home-sale__timer">
                                <div class="timer-item">
                                    <div class="timer-card">
                                        <div class="timer-front">
                                            <span class="count days">02</span>
                                        </div>
                                        <div class="timer-back">
                                            <span class="count days">02</span>
                                        </div>
                                    </div>
                                    <span class="label">Days</span>
                                </div>
                                <div class="timer-item">
                                    <div class="timer-card">
                                        <div class="timer-front">
                                            <span class="count hours">00</span>
                                        </div>
                                        <div class="timer-back">
                                            <span class="count hours">00</span>
                                        </div>
                                    </div>
                                    <span class="label">Hours</span>
                                </div>
                                <div class="timer-item">
                                    <div class="timer-card">
                                        <div class="timer-front">
                                            <span class="count minutes">00</span>
                                        </div>
                                        <div class="timer-back">
                                            <span class="count minutes">00</span>
                                        </div>
                                    </div>
                                    <span class="label">Minutes</span>
                                </div>
                                <div class="timer-item">
                                    <div class="timer-card">
                                        <div class="timer-front">
                                            <span class="count seconds">00</span>
                                        </div>
                                        <div class="timer-back">
                                            <span class="count seconds">00</span>
                                        </div>
                                    </div>
                                    <span class="label">Seconds</span>
                                </div>
                            </div>
                            <a href="/shop" class="home-sale__btn">Shop Now</a>
                        </div>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block">
                        <div class="home-sale__gif-box">
                            @php
                                $weekendSaleGif = \App\Models\Banner::where('type', 'weekend_sale_gif')->first();
                            @endphp
                            @if($weekendSaleGif && $weekendSaleGif->image)
                                <img src="{{ asset('storage/'.$weekendSaleGif->image) }}" alt="Weekend Sale" class="home-sale__gif">
                            @else
                                <div class="home-sale__gif-placeholder">
                                    <i class="fas fa-percentage"></i>
                                    <p>Weekend Sale GIF</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section - Carousel Layout -->
    <section class="home-products py-5">
        <div class="container">
            <div class="home-products__header text-center mb-5">
                <span class="home-products__subtitle">Natural Beauty</span>
                <h2 class="home-products__title">Featured Products</h2>
            </div>

            <!-- Products Carousel -->
            <div class="products-carousel-container">
                <!-- Carousel Wrapper -->
                <div class="products-carousel-wrapper">
                    <div class="products-carousel" id="productsCarousel">
                        @foreach ($products as $product)
                            <div class="carousel-product-card" data-price="{{ $product->price }}"
                                data-category="{{ $product->category_id }}" data-flag="{{ $product->flag }}">

                                <div class="ts-product-image-wrapper">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">

                                    <button class="ts-quick-view-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"
                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                        data-price="{{ $product->price }}" data-description="{{ $product->description }}"
                                        data-category="{{ $product->category->name }}"
                                        data-image="{{ asset('storage/' . $product->image) }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                <div class="ts-product-details">
                                    <h3 class="ts-product-title">{{ $product->name }}</h3>

                                    <div class="ts-product-meta">
                                        <span class="ts-product-category">{{ $product->category->name }}</span>
                                        <span class="ts-product-price">PKR {{ number_format($product->price, 0) }}</span>
                                    </div>

                                    <div class="product-card-actions">
                                        <a href="{{ route('web.product.show', $product) }}" class="ts-view-product-btn">
                                            <i class="fas fa-eye"></i>
                                            View
                                        </a>
                                        <button class="ts-add-to-cart-btn" data-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                            data-image="{{ asset('storage/' . $product->image) }}">
                                            <i class="fas fa-shopping-cart"></i>
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Carousel Indicators -->
                <div class="carousel-indicators" id="carouselIndicators">
                    <!-- Will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </section>

    <!-- Announcements Section -->
    @if($announcements->count() > 0)
    <section class="announcements-section py-5" style="background: linear-gradient(135deg, #A67BC9 0%, #8B7BA8 100%); position: relative; overflow: hidden;">
        <!-- Background Pattern -->
        <div class="announcement-bg-pattern"></div>
        
        <div class="container">
            <div class="text-center mb-5">
                <span class="home-products__subtitle text-white" style="opacity: 0.9;">Special Offers</span>
                <h2 class="home-products__title text-white mb-3">Latest Announcements</h2>
                <div class="section-divider mx-auto" style="background: rgba(255,255,255,0.3);"></div>
            </div>

            <div class="announcements-carousel">
                @foreach($announcements as $index => $announcement)
                <div class="announcement-slide {{ $index === 0 ? 'active' : '' }}" 
                     style="background-color: {{ $announcement->background_color }}; color: {{ $announcement->text_color }};"
                     data-announcement-id="{{ $announcement->id }}">
                    <div class="row align-items-center">
                        @if($announcement->image)
                        <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
                            <div class="announcement-image-wrapper">
                                <img src="{{ $announcement->image }}" alt="{{ $announcement->title }}" class="announcement-image">
                                <div class="image-overlay"></div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="col-lg-{{ $announcement->image ? '7' : '12' }} col-md-{{ $announcement->image ? '6' : '12' }}">
                            <div class="announcement-content">
                                @if($announcement->type)
                                    <span class="announcement-badge">{{ ucfirst(str_replace('_', ' ', $announcement->type)) }}</span>
                                @endif
                                
                                <h2 class="announcement-title">{{ $announcement->title }}</h2>
                                
                                @if($announcement->subtitle)
                                    <h4 class="announcement-subtitle">{{ $announcement->subtitle }}</h4>
                                @endif
                                
                                @if($announcement->description)
                                    <div class="announcement-text">
                                        {{ $announcement->description }}
                                    </div>
                                @endif
                                
                                @if($announcement->countdown_date && $announcement->countdown_date->gt(now()))
                                <div class="announcement-countdown" data-countdown="{{ $announcement->countdown_date->toISOString() }}">
                                    <div class="countdown-timer">
                                        <div class="countdown-item">
                                            <span class="countdown-number days">00</span>
                                            <span class="countdown-label">Days</span>
                                        </div>
                                        <div class="countdown-item">
                                            <span class="countdown-number hours">00</span>
                                            <span class="countdown-label">Hours</span>
                                        </div>
                                        <div class="countdown-item">
                                            <span class="countdown-number minutes">00</span>
                                            <span class="countdown-label">Minutes</span>
                                        </div>
                                        <div class="countdown-item">
                                            <span class="countdown-number seconds">00</span>
                                            <span class="countdown-label">Seconds</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if($announcement->button_text && $announcement->button_link)
                                <div class="announcement-actions">
                                    <a href="{{ $announcement->button_link }}" class="announcement-btn">
                                        {{ $announcement->button_text }}
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($announcements->count() > 1)
            <!-- Navigation Dots -->
            <div class="announcement-dots">
                @foreach($announcements as $index => $announcement)
                <button class="dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></button>
                @endforeach
            </div>
            @endif
        </div>
    </section>
    @endif

    <style>
        /* Core styles with specific namespacing to avoid conflicts */
        .home-feat__card {
            background: #fff;
            border-radius: 15px;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        }

        .home-feat__card:hover {
            transform: translateY(-5px);
        }

        .home-feat__icon {
            font-size: 2rem;
            color: #9977B5;
            margin-bottom: 1rem;
            display: block;
        }

        .home-feat__title {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .home-feat__text {
            color: #666;
            margin-bottom: 1rem;
        }

        .home-feat__link {
            color: #9977B5;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .home-feat__link:hover {
            color: #735891;
            padding-left: 5px;
        }

        /* Products Section */
        .home-products__header {
            margin-bottom: 3rem;
        }

        .home-products__subtitle {
            color: #9977B5;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        .home-products__title {
            font-size: 2.5rem;
            color: #333;
            font-weight: 300;
        }

        .home-filter__wrap {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .home-filter__btn {
            padding: 0.8rem 1.5rem;
            border: none;
            background: #f8f9fa;
            color: #666;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .home-filter__btn:hover,
        .home-filter__btn.active {
            background: #9977B5;
            color: #fff;
        }

        /* Sale Banner */
        .home-sale__wrap {
            background: linear-gradient(135deg, #9977B5 0%, #735891 100%);
            border-radius: 20px;
            padding: 4rem;
            color: #fff;
        }

        .home-sale__title {
            font-size: 3rem;
            font-weight: 300;
            margin-bottom: 1rem;
        }

        .home-sale__text {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            color: white;
        }

        /* 3D Countdown Timer */
        .home-sale__timer {
            display: flex;
            /* justify-content: center; */
            gap: 1.5rem;
            margin: 2rem 0;
            perspective: 1000px;
            flex-wrap: wrap;
        }

        .timer-item {
            text-align: center;
            position: relative;
        }

        .timer-card {
            position: relative;
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
            transform-style: preserve-3d;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .timer-front,
        .timer-back {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Orbitron', monospace;
            font-weight: 700;
            font-size: 1.8rem;
            color: #fff;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2),
                inset 0 -1px 0 rgba(0, 0, 0, 0.1);
            backface-visibility: hidden;
        }

        .timer-front {
            z-index: 2;
        }

        .timer-back {
            transform: rotateX(180deg);
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.25), rgba(255, 255, 255, 0.1));
        }

        .timer-item:hover .timer-card {
            transform: rotateX(180deg) scale(1.05);
        }

        .timer-item .label {
            font-size: 0.9rem;
            opacity: 0.9;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Glow animation for timer cards */
        @keyframes glow {

            0%,
            100% {
                box-shadow:
                    0 8px 32px rgba(0, 0, 0, 0.1),
                    inset 0 1px 0 rgba(255, 255, 255, 0.2),
                    inset 0 -1px 0 rgba(0, 0, 0, 0.1),
                    0 0 0 rgba(255, 255, 255, 0.5);
            }

            50% {
                box-shadow:
                    0 8px 32px rgba(0, 0, 0, 0.1),
                    inset 0 1px 0 rgba(255, 255, 255, 0.2),
                    inset 0 -1px 0 rgba(0, 0, 0, 0.1),
                    0 0 20px rgba(255, 255, 255, 0.3);
            }
        }

        .timer-front,
        .timer-back {
            animation: glow 3s ease-in-out infinite;
        }

        .home-sale__btn {
            display: inline-block;
            padding: 1rem 2rem;
            background: #fff;
            color: #9977B5;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .home-sale__btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            color: #9977B5;
        }

        /* GIF Box Styles */
        .home-sale__gif-box {
            /* background: rgba(255, 255, 255, 0.1); */
            /* border-radius: 20px; */
            /* padding: 2rem; */
            text-align: center;
            backdrop-filter: blur(10px);
            /* border: 1px solid rgba(255, 255, 255, 0.2); */
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .home-sale__gif {
            max-width: 100%;
            max-height: 300px;
            border-radius: 15px;
            /* box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); */
        }

        .home-sale__gif-placeholder {
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
        }

        .home-sale__gif-placeholder i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .home-sale__gif-placeholder p {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Products Carousel Styles */
        .products-carousel-container {
            position: relative;
            margin: 2rem 0;
        }

        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: rgba(141, 104, 173, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .carousel-nav:hover {
            background: #8D68AD;
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .carousel-nav-prev {
            left: -25px;
        }

        .carousel-nav-next {
            right: -25px;
        }

        .products-carousel-wrapper {
            overflow: hidden;
            border-radius: 15px;
        }

        .products-carousel {
            display: flex;
            transition: transform 0.5s ease;
            gap: 1.5rem;
        }

        .carousel-product-card {
            min-width: calc(25% - 1.125rem); /* 4 products on desktop */
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            /* box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); */
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .carousel-product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .carousel-product-card .ts-product-image-wrapper {
            position: relative;
            padding-top: 100%;
            background: #f8f9fa;
            overflow: hidden;
        }

        .carousel-product-card .ts-product-image-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .carousel-product-card:hover .ts-product-image-wrapper img {
            transform: scale(1.05);
        }

        .carousel-product-card .ts-quick-view-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 5;
            opacity: 0;
        }

        .carousel-product-card:hover .ts-quick-view-btn {
            opacity: 1;
        }

        .carousel-product-card .ts-quick-view-btn:hover {
            background: #8D68AD;
            color: white;
        }

        .carousel-product-card .ts-product-details {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            flex-grow: 1;
        }

        .carousel-product-card .ts-product-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin: 0;
            line-height: 1.4;
        }

        .carousel-product-card .ts-product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .carousel-product-card .ts-product-category {
            color: #666;
            font-size: 0.9rem;
        }

        .carousel-product-card .ts-product-price {
            color: #8D68AD;
            font-weight: 700;
            font-size: 1.15rem;
        }

        .carousel-product-card .ts-add-to-cart-btn {
            width: 100%;
            padding: 0.75rem;
            background: #8D68AD;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: auto;
        }

        .carousel-product-card .ts-add-to-cart-btn:hover {
            background: #7a5a9a;
            transform: translateY(-1px);
        }

        /* View Product Button Styles */
        .ts-view-product-btn:hover {
            background: #8D68AD !important;
            color: white !important;
            text-decoration: none !important;
        }

        /* Product Card Actions */
        .product-card-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .ts-view-product-btn {
            flex: 1;
            background: transparent;
            border: 2px solid #8D68AD;
            color: #8D68AD;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: all 0.3s ease;
        }

        .ts-add-to-cart-btn {
            flex: 2;
            padding: 8px 12px;
            font-size: 0.85rem;
        }

        /* Carousel Indicators */
        .carousel-indicators {
            display: flex;
            justify-content: center;
            margin-bottom: -3rem;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .carousel-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(141, 104, 173, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-indicator.active {
            background: #8D68AD;
            transform: scale(1.2);
        }

        /* Product Badge Styles */
        .product-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 6;
        }

        .product-badge span {
            background: linear-gradient(135deg, #FF6B6B, #FF8E8E);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);
        }

        /* Best Selling Carousel Container */
        .best-selling-carousel-container {
            position: relative;
            margin: 2rem 0;
        }

        /* Mobile Responsive Styles for Carousel */
        @media (max-width: 768px) {
            .carousel-product-card {
                min-width: calc(50% - 0.75rem); /* 2 products on mobile */
            }

            .carousel-nav {
                width: 40px;
                height: 40px;
                font-size: 0.9rem;
            }

            .carousel-nav-prev {
                left: -20px;
            }

            .carousel-nav-next {
                right: -20px;
            }

            .products-carousel {
                gap: 1rem;
            }

            .carousel-product-card .ts-product-details {
                padding: 1rem;
            }

            .carousel-product-card .ts-product-title {
                font-size: 1rem;
            }

            .carousel-product-card .ts-product-price {
                font-size: 1rem;
            }

            /* Stack buttons vertically on mobile */
            .product-card-actions {
                flex-direction: column;
                gap: 6px;
            }

            .ts-view-product-btn,
            .ts-add-to-cart-btn {
                width: 100%;
                flex: none;
                padding: 10px 12px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .carousel-nav-prev {
                left: -15px;
            }

            .carousel-nav-next {
                right: -15px;
            }

            .carousel-nav {
                width: 35px;
                height: 35px;
                font-size: 0.8rem;
            }

            .products-carousel {
                gap: 0.75rem;
            }

            .carousel-product-card .ts-product-details {
                padding: 0.75rem;
                gap: 0.5rem;
            }

            .carousel-product-card .ts-product-title {
                font-size: 0.95rem;
            }

            .carousel-product-card .ts-add-to-cart-btn {
                padding: 0.6rem;
                font-size: 0.9rem;
            }

            /* Even more emphasis on stacked buttons for small screens */
            .product-card-actions {
                flex-direction: column;
                gap: 8px;
            }

            .ts-view-product-btn,
            .ts-add-to-cart-btn {
                width: 100%;
                padding: 0.5rem;
                font-size: 0.8rem;
                border-radius: 8px;
            }

            /* Deal buttons mobile adjustments */
            .deal-buttons-premium {
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }

            .deal-view-btn-premium,
            .deal-shop-btn-premium {
                width: 100%;
                max-width: none;
                padding: 12px 20px;
                font-size: 0.8rem;
                border-radius: 8px;
            }
        }

        /* Responsive Adjustments */
        @media (max-width: 991px) {
            .home-sale__wrap {
                padding: 3rem;
            }

            .home-sale__title {
                font-size: 2.5rem;
            }

            .timer-card {
                width: 70px;
                height: 70px;
            }

            .timer-front,
            .timer-back {
                font-size: 1.6rem;
            }
        }

        /* Enhanced Mobile Responsiveness */
        @media (max-width: 991px) {
            .home-sale__wrap {
                padding: 3rem 2rem;
            }

            .home-sale__title {
                font-size: 2.5rem;
            }

            .timer-card {
                width: 70px;
                height: 70px;
            }

            .timer-front,
            .timer-back {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 767px) {
            .home-filter__btn {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }

            .home-sale__wrap {
                padding: 2.5rem 1.5rem;
                text-align: center;
            }

            .timer-card {
                width: 65px;
                height: 65px;
            }

            .timer-front,
            .timer-back {
                font-size: 1.5rem;
            }

            .home-sale__title {
                font-size: 2.2rem;
                margin-bottom: 1rem;
            }

            .home-sale__text {
                font-size: 1.1rem;
                margin-bottom: 2rem;
            }

            .home-sale__timer {
                gap: 1.2rem;
                justify-content: center;
                margin: 2rem 0;
            }

            .timer-item .label {
                font-size: 0.9rem;
            }

            .home-sale__btn {
                padding: 1rem 2.5rem;
                font-size: 1rem;
                margin-top: 1rem;
            }
        }

        @media (max-width: 576px) {
            .home-sale__wrap {
                padding: 2rem 1rem;
            }

            .home-sale__title {
                font-size: 1.8rem;
                line-height: 1.2;
            }

            .home-sale__text {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }

            .timer-card {
                width: 55px;
                height: 55px;
            }

            .timer-front,
            .timer-back {
                font-size: 1.3rem;
            }

            .home-sale__timer {
                gap: 0.8rem;
                flex-wrap: wrap;
                justify-content: center;
            }

            .timer-item .label {
                font-size: 0.8rem;
                margin-top: 0.3rem;
            }

            .home-sale__btn {
                padding: 0.9rem 2rem;
                font-size: 0.95rem;
                width: 100%;
                max-width: 250px;
            }
        }

        @media (max-width: 480px) {
            .home-sale__wrap {
                padding: 1.5rem 0.8rem;
            }

            .home-sale__title {
                font-size: 1.6rem;
            }

            .home-sale__text {
                font-size: 0.9rem;
            }

            .timer-card {
                width: 50px;
                height: 50px;
            }

            .timer-front,
            .timer-back {
                font-size: 1.2rem;
            }

            .timer-item .label {
                font-size: 0.75rem;
            }

            .home-sale__timer {
                gap: 0.6rem;
            }
        }

        @media (max-width: 320px) {
            .home-sale__title {
                font-size: 1.4rem;
            }

            .timer-card {
                width: 45px;
                height: 45px;
            }

            .timer-front,
            .timer-back {
                font-size: 1.1rem;
            }

            .home-sale__timer {
                gap: 0.4rem;
            }
        }

        /* Feature Cards Hover Effects */
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }

        /* WhatsApp Button Hover */
        .btn-whatsapp:hover {
            background: #20B954;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Responsive adjustments for new sections */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem !important;
            }
            
            .feature-card {
                padding: 1.5rem 1rem;
                margin-bottom: 1rem;
            }

            .feature-icon {
                width: 60px !important;
                height: 60px !important;
            }

            .feature-icon i {
                font-size: 1.5rem !important;
            }

            .home-products__title {
                font-size: 2rem;
            }

            .home-feat__title {
                font-size: 1.3rem;
            }

            .home-feat__card {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .banner-title {
                font-size: 2rem !important;
            }

            .banner-subtitle {
                font-size: 0.8rem !important;
            }

            .cursive-text {
                font-size: 1.6rem !important;
            }

            .feature-card {
                padding: 1.2rem 0.8rem;
            }

            .home-products__title {
                font-size: 1.8rem;
            }

            .home-filter__wrap {
                gap: 0.5rem;
            }

            .home-filter__btn {
                padding: 0.5rem 0.8rem;
                font-size: 0.8rem;
            }

            .ts-product-card {
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .section-title {
                font-size: 1.6rem !important;
            }

            .home-products__subtitle {
                font-size: 0.8rem;
            }

            .banner-content {
                padding: 0 3% !important;
            }

            .feature-card {
                padding: 1rem;
            }

            .feature-icon {
                width: 50px !important;
                height: 50px !important;
            }

            .feature-icon i {
                font-size: 1.3rem !important;
            }
        }

        @media (max-width: 320px) {
            .banner-title {
                font-size: 1.6rem !important;
            }

            .home-products__title {
                font-size: 1.5rem;
            }

            .feature-card h4 {
                font-size: 1.1rem;
            }

            .feature-card p {
                font-size: 0.85rem;
            }
        }

        /* Premium Deal of the Day Styles */
        .deal-of-the-day {
            background: #ffffff;
            padding: 80px 0;
        }

        /* Add missing CSS animations */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .premium-deal-card {
            position: relative;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            overflow: visible;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-top: 80px; /* Space for elevated image */
        }

        .premium-deal-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 35px 80px rgba(0, 0, 0, 0.15);
        }

        .deal-badge-premium {
            position: absolute;
            top: -15px;
            right: 20px;
            background: linear-gradient(135deg, #ff4757, #ff3742);
            color: white;
            border-radius: 50px;
            padding: 10px 16px;
            z-index: 10;
            box-shadow: 0 8px 25px rgba(255, 71, 87, 0.4);
            transform: rotate(-3deg);
            min-width: 70px;
            text-align: center;
            animation: badgePulse 2s infinite ease-in-out;
        }

        @keyframes badgePulse {
            0%, 100% { 
                transform: rotate(-3deg) scale(1);
                box-shadow: 0 8px 25px rgba(255, 71, 87, 0.4);
            }
            50% { 
                transform: rotate(-3deg) scale(1.05);
                box-shadow: 0 12px 35px rgba(255, 71, 87, 0.6);
            }
        }

        .discount-text {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            animation: textGlow 2s infinite ease-in-out, textBounce 1.5s infinite ease-in-out;
        }

        @keyframes textGlow {
            0%, 100% { 
                text-shadow: 0 0 5px rgba(255, 255, 255, 0.3);
            }
            50% { 
                text-shadow: 0 0 10px rgba(255, 255, 255, 0.7), 0 0 15px rgba(255, 255, 255, 0.5);
            }
        }

        @keyframes textBounce {
            0%, 100% { 
                transform: translateY(0px);
            }
            50% { 
                transform: translateY(-2px);
            }
        }

        .discount-percentage {
            display: block;
            font-size: 1.8rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 2px;
        }

        .deal-image-premium {
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            width: 160px;
            height: 160px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            border: 6px solid #ffffff;
            background: #ffffff;
            z-index: 5;
        }

        .deal-image-premium img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .premium-deal-card:hover .deal-image-premium img {
            transform: scale(1.1);
        }

        .image-placeholder-premium {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #8D68AD, #B794C4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
        }

        .deal-content-premium {
            padding: 90px 30px 30px; /* Increased top padding to avoid text hiding under image */
            text-align: center;
        }

        .deal-title-premium {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 15px;
            line-height: 1.3;
            margin-top: 25px; /* Added 15px more margin */
        }

        .deal-description-premium {
            color: #718096;
            font-size: 0.9rem;
            margin-bottom: 25px;
            line-height: 1.6;
            min-height: 50px;
        }

        .deal-pricing-premium {
            margin-bottom: 20px;
            text-align: center;
        }

        .original-price-premium {
            display: block;
            color: #a0aec0;
            text-decoration: line-through;
            font-size: 0.9rem;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .deal-price-premium {
            display: block;
            color: #2d3748;
            font-size: 1.8rem;
            font-weight: 900;
            margin-bottom: 8px;
            line-height: 1.1;
        }

        .savings-premium {
            display: inline-block;
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(72, 187, 120, 0.3);
        }

        .deal-timer-premium {
            color: #e53e3e;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .deal-timer-premium i {
            font-size: 1rem;
        }

        .deal-buttons-premium {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }

        .deal-view-btn-premium {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(66, 153, 225, 0.3);
            flex: 1;
            max-width: 90px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .deal-view-btn-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .deal-view-btn-premium:hover::before {
            left: 100%;
        }

        .deal-view-btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(66, 153, 225, 0.4);
            background: linear-gradient(135deg, #3182ce, #2c5282);
        }

        .deal-shop-btn-premium {
            background: linear-gradient(135deg, #8D68AD, #B794C4);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(141, 104, 173, 0.3);
            flex: 1;
            max-width: 120px;
            white-space: nowrap;
        }

        .deal-shop-btn-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .deal-shop-btn-premium:hover::before {
            left: 100%;
        }

        .deal-shop-btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(141, 104, 173, 0.4);
            background: linear-gradient(135deg, #6B5B7D, #8D68AD);
        }

        .deal-shop-btn-premium:active {
            transform: translateY(-1px);
        }

        /* Responsive Premium Design */
        @media (max-width: 768px) {
            .premium-deal-card {
                margin-top: 60px;
            }

            .deal-image-premium {
                top: -40px;
                width: 120px;
                height: 120px;
            }

            .deal-content-premium {
                padding: 70px 15px 25px; /* Adjusted for smaller image */
            }

            .deal-badge-premium {
                padding: 8px 12px;
                min-width: 60px;
                top: -12px;
                right: 15px;
            }

            .deal-title-premium {
                font-size: 1rem; /* Smaller text for mobile */
                margin-top: 20px; /* Adjusted margin for mobile */
            }

            .deal-description-premium {
                font-size: 0.8rem; /* Smaller description */
                min-height: 40px;
                margin-bottom: 20px;
            }

            .deal-price-premium {
                font-size: 1.4rem; /* Smaller price for tablet */
            }

            .deal-buttons-premium {
                flex-direction: column;
                gap: 8px;
                width: 100%;
            }

            .deal-view-btn-premium {
                padding: 10px 20px;
                font-size: 0.75rem;
                max-width: none;
                width: 100%;
            }

            .deal-shop-btn-premium {
                padding: 10px 20px;
                font-size: 0.75rem;
                max-width: none;
                width: 100%;
            }

            .discount-percentage {
                font-size: 1.2rem; /* Smaller percentage */
            }

            .discount-text {
                font-size: 0.55rem; /* Smaller OFF text */
            }

            .deal-timer-premium {
                font-size: 0.75rem; /* Smaller timer text */
                margin-bottom: 20px;
            }
        }

        /* Additional responsive breakpoints */
        @media (max-width: 480px) {
            .deal-of-the-day .col-6 {
                padding: 0 3px;
            }
            
            .deal-image-premium {
                width: 75px;
                height: 75px;
                top: -20px;
            }
            
            .deal-content-premium {
                padding: 40px 8px 12px;
            }

            .deal-badge-premium {
                padding: 6px 10px;
                min-width: 50px;
                top: -10px;
                right: 10px;
            }
            
            .deal-title-premium {
                font-size: 0.75rem;
                margin-top: 15px;
            }
            
            .deal-description-premium {
                font-size: 0.65rem;
                min-height: 25px;
                margin-bottom: 8px;
            }

            .deal-price-premium {
                font-size: 1rem;
                margin-bottom: 6px;
            }

            .original-price-premium {
                font-size: 0.65rem;
                margin-bottom: 2px;
            }

            .savings-premium {
                font-size: 0.5rem;
                padding: 2px 6px;
            }

            .deal-buttons-premium {
                gap: 8px;
                flex-direction: column;
                width: 100%;
            }

            .deal-view-btn-premium {
                font-size: 0.7rem;
                padding: 8px 15px;
                max-width: none;
                width: 100%;
            }
            
            .deal-shop-btn-premium {
                font-size: 0.7rem;
                padding: 8px 15px;
                max-width: none;
                width: 100%;
            }

            .discount-percentage {
                font-size: 1rem;
            }

            .discount-text {
                font-size: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .deal-of-the-day {
                padding: 60px 0;
            }

            /* Show 2 products on mobile - adjust grid */
            .deal-of-the-day .row {
                margin: 0 -5px;
            }

            .deal-of-the-day .col-6 {
                flex: 0 0 50%;
                max-width: 50%;
                padding: 0 5px;
            }

            .premium-deal-card {
                margin-top: 30px;
                margin-bottom: 15px;
            }

            .deal-image-premium {
                top: -25px;
                width: 80px;
                height: 80px;
            }

            .deal-content-premium {
                padding: 45px 10px 15px; /* Adjusted padding for 2 columns */
            }

            .deal-badge-premium {
                top: -8px;
                right: 8px;
                padding: 6px 12px;
                min-width: 50px;
            }

            .discount-percentage {
                font-size: 1rem; /* Readable percentage */
            }

            .discount-text {
                font-size: 0.5rem; /* Readable OFF text */
            }

            .deal-title-premium {
                font-size: 0.8rem; /* Readable title */
                margin-bottom: 8px;
                margin-top: 18px; /* Adjusted margin */
                line-height: 1.2;
            }

            .deal-description-premium {
                font-size: 0.7rem; /* Readable description */
                min-height: 30px;
                margin-bottom: 12px;
                line-height: 1.3;
            }

            .deal-price-premium {
                font-size: 1.1rem; /* Readable price for mobile */
            }

            .deal-timer-premium {
                font-size: 0.65rem; /* Readable timer */
                margin-bottom: 12px;
            }

            .deal-buttons-premium {
                flex-direction: row;
                gap: 6px;
            }

            .deal-view-btn-premium {
                padding: 6px 12px; /* Comfortable button size */
                font-size: 0.65rem; /* Readable button text */
                max-width: 80px;
            }

            .deal-shop-btn-premium {
                padding: 6px 12px; /* Comfortable button size */
                font-size: 0.65rem; /* Readable button text */
                max-width: 90px;
            }

            .original-price-premium {
                font-size: 0.7rem;
                margin-bottom: 2px;
            }

            .savings-premium {
                font-size: 0.55rem;
                padding: 2px 6px;
            }
        }

        /* Announcements Section Styles */
        .announcements-section {
            position: relative;
            min-height: 500px;
            display: flex;
            align-items: center;
            color: white;
        }

        .announcement-bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.1;
            background-image: 
                radial-gradient(circle at 20% 50%, white 2px, transparent 2px),
                radial-gradient(circle at 80% 50%, white 2px, transparent 2px);
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px;
        }

        .section-divider {
            width: 80px;
            height: 3px;
            border-radius: 2px;
        }

        .announcements-carousel {
            position: relative;
            min-height: 400px;
        }

        .announcement-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            opacity: 0;
            visibility: hidden;
            transition: all 0.6s ease;
            border-radius: 25px;
            padding: 3rem;
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            z-index: 1;
        }

        .announcement-slide.active {
            position: relative;
            opacity: 1;
            visibility: visible;
            z-index: 2;
        }

        .announcement-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .announcement-image-wrapper {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .announcement-image-wrapper:hover {
            transform: scale(1.02);
        }

        .announcement-image {
            width: 100%;
            height: 350px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(166, 123, 201, 0.1), rgba(139, 123, 168, 0.1));
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .announcement-image-wrapper:hover .image-overlay {
            opacity: 1;
        }

        .announcement-content {
            padding: 1rem 0;
        }

        .announcement-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .announcement-subtitle {
            font-size: 1.4rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            opacity: 0.9;
            font-style: italic;
        }

        .announcement-text {
            font-size: 1.1rem;
            line-height: 1.7;
            margin-bottom: 2rem;
            opacity: 0.95;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .announcement-countdown {
            margin: 2rem 0;
        }

        .countdown-timer {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .countdown-item {
            text-align: center;
            background: rgba(255, 255, 255, 0.15);
            padding: 1.5rem 1rem;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            min-width: 80px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .countdown-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
        }

        .countdown-number {
            display: block;
            font-size: 2rem;
            font-weight: 900;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 0.5rem;
        }

        .countdown-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .announcement-actions {
            margin-top: 2rem;
        }

        .announcement-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            padding: 1rem 2.5rem;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .announcement-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
            color: white;
            text-decoration: none;
        }

        .announcement-btn i {
            transition: transform 0.3s ease;
        }

        .announcement-btn:hover i {
            transform: translateX(5px);
        }

        .announcement-dots {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 3rem;
        }

        .announcement-dots .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0;
        }

        .announcement-dots .dot.active {
            background: white;
            transform: scale(1.2);
        }

        .announcement-dots .dot:hover {
            background: rgba(255, 255, 255, 0.7);
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 991px) {
            .announcement-slide {
                padding: 2rem;
            }

            .announcement-image {
                height: 280px;
            }

            .announcement-title {
                font-size: 2.2rem;
            }

            .announcement-subtitle {
                font-size: 1.2rem;
            }

            .countdown-timer {
                gap: 1rem;
            }

            .countdown-item {
                min-width: 70px;
                padding: 1rem 0.8rem;
            }

            .countdown-number {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .announcements-section {
                min-height: auto;
                padding: 3rem 0;
            }

            .announcement-slide {
                padding: 1.5rem;
            }

            .announcement-image {
                height: 220px;
            }

            .announcement-title {
                font-size: 1.8rem;
            }

            .announcement-subtitle {
                font-size: 1rem;
            }

            .announcement-text {
                font-size: 1rem;
            }

            .countdown-timer {
                justify-content: center;
                gap: 0.8rem;
            }

            .countdown-item {
                min-width: 60px;
                padding: 0.8rem 0.5rem;
            }

            .countdown-number {
                font-size: 1.2rem;
            }

            .countdown-label {
                font-size: 0.7rem;
            }

            .announcement-btn {
                padding: 0.8rem 2rem;
                font-size: 0.9rem;
            }
        }
            }

            .announcement-text {
                font-size: 1.1rem;
            }

            .counter-number {
                font-size: 2.5rem;
                min-width: 80px;
            }

            .counter-label {
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            .announcements-section {
                padding: 60px 0 !important;
            }

            .announcement-content {
                padding: 1rem 0;
                text-align: center;
            }

            .announcement-image {
                height: 250px;
            }

            .announcement-title {
                font-size: 2rem;
                margin-bottom: 1rem;
            }

            .announcement-text {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }

            .counter-wrapper {
                padding: 1rem 2rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .counter-number {
                font-size: 2rem;
                min-width: auto;
            }

            .counter-label {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .announcement-title {
                font-size: 1.8rem;
            }

            .announcement-text {
                font-size: 0.95rem;
            }

            .counter-wrapper {
                padding: 0.8rem 1.5rem;
            }

            .counter-number {
                font-size: 1.8rem;
            }

            .counter-label {
                font-size: 0.8rem;
            }
        }

        /* Random Products Section */
        .random-products .product-card {
            transition: all 0.3s ease;
        }

        .random-products .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        }

        .random-products .product-image-wrapper:hover .product-actions {
            opacity: 1;
        }

        .random-products .product-actions button:hover {
            background: white !important;
            transform: scale(1.1);
        }

        .random-products .btn-outline-primary:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        /* Custom column class for 5 products per row on desktop */
        .col-lg-2dot4 {
            flex: 0 0 auto;
            width: 20%; /* 5 products per row: 100% / 5 = 20% */
        }

        /* Responsive layout for random products */
        @media (max-width: 991.98px) {
            .col-lg-2dot4 {
                width: 50%; /* 2 products per row on tablet and mobile */
            }
        }

        @media (max-width: 575.98px) {
            .discover-product-col {
                margin-bottom: 20px;
            }
            
            .random-products .carousel-product-card {
                margin-bottom: 10px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if we need to scroll to a specific deal
            const hash = window.location.hash;
            if (hash && hash.startsWith('#deal-')) {
                setTimeout(() => {
                    const element = document.querySelector(hash);
                    if (element) {
                        element.scrollIntoView({ 
                            behavior: 'smooth',
                            block: 'center'
                        });
                        // Add a highlight effect
                        element.style.transition = 'all 0.3s ease';
                        element.style.transform = 'scale(1.02)';
                        element.style.boxShadow = '0 0 20px rgba(255, 71, 87, 0.3)';
                        setTimeout(() => {
                            element.style.transform = '';
                            element.style.boxShadow = '';
                        }, 2000);
                    }
                }, 1000);
            }
            
            // 3D Timer functionality - Always starts from 2 days and counts backwards
            let countdownEndTime;

            function initializeCountdown() {
                // Set countdown to always start from 2 days from current time
                countdownEndTime = new Date().getTime() + (2 * 24 * 60 * 60 * 1000); // 2 days in milliseconds
            }

            function updateTimer() {
                const now = new Date().getTime();
                const timeLeft = countdownEndTime - now;

                if (timeLeft > 0) {
                    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                    // Update all timer displays (front and back)
                    const daysElements = document.querySelectorAll('.days');
                    const hoursElements = document.querySelectorAll('.hours');
                    const minutesElements = document.querySelectorAll('.minutes');
                    const secondsElements = document.querySelectorAll('.seconds');

                    daysElements.forEach(el => el.textContent = String(days).padStart(2, '0'));
                    hoursElements.forEach(el => el.textContent = String(hours).padStart(2, '0'));
                    minutesElements.forEach(el => el.textContent = String(minutes).padStart(2, '0'));
                    secondsElements.forEach(el => el.textContent = String(seconds).padStart(2, '0'));
                } else {
                    // Reset countdown when it reaches zero
                    initializeCountdown();
                }
            }

            // Initialize and start countdown
            initializeCountdown();
            setInterval(updateTimer, 1000);
            updateTimer();

            // Category filtering
            const filterBtns = document.querySelectorAll('.home-filter__btn');
            const products = document.querySelectorAll('.carousel-product-card');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const category = this.dataset.category;

                    products.forEach(product => {
                        if (category === 'all') {
                            product.style.display = '';
                        } else if (category === 'new' && product.dataset.flag ===
                            'New Arrivals') {
                            product.style.display = '';
                        } else if (category === 'featured' && product.dataset.flag ===
                            'Featured') {
                            product.style.display = '';
                        } else if (category === 'sale' && product.dataset.flag ===
                            'On Sale') {
                            product.style.display = '';
                        } else {
                            product.style.display = 'none';
                        }
                    });

                    // Reset carousel position after filtering
                    currentIndex = 0;
                    updateCarousel();
                    updateIndicators();
                });
            });

            // Products Carousel Functionality
            const carousel = document.getElementById('productsCarousel');
            const indicatorsContainer = document.getElementById('carouselIndicators');
            
            let currentIndex = 0;
            let itemsPerView = window.innerWidth <= 768 ? 2 : 4; // 2 on mobile, 4 on desktop
            let totalItems = products.length;
            let totalSlides = Math.ceil(totalItems / itemsPerView);
            let autoSlideInterval;

            // Update items per view on window resize
            window.addEventListener('resize', function() {
                const newItemsPerView = window.innerWidth <= 768 ? 2 : 4;
                if (newItemsPerView !== itemsPerView) {
                    itemsPerView = newItemsPerView;
                    totalSlides = Math.ceil(totalItems / itemsPerView);
                    currentIndex = Math.min(currentIndex, totalSlides - 1);
                    updateCarousel();
                    createIndicators();
                    updateIndicators();
                }
            });

            function updateCarousel() {
                const translateX = -(currentIndex * (100 / itemsPerView));
                carousel.style.transform = `translateX(${translateX}%)`;
            }

            function createIndicators() {
                indicatorsContainer.innerHTML = '';
                for (let i = 0; i < totalSlides; i++) {
                    const indicator = document.createElement('div');
                    indicator.className = 'carousel-indicator';
                    indicator.addEventListener('click', () => goToSlide(i));
                    indicatorsContainer.appendChild(indicator);
                }
            }

            function updateIndicators() {
                const indicators = document.querySelectorAll('.carousel-indicator');
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('active', index === currentIndex);
                });
            }

            function goToSlide(index) {
                currentIndex = index;
                updateCarousel();
                updateIndicators();
                resetAutoSlide();
            }

            function nextSlide() {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateCarousel();
                updateIndicators();
            }

            function prevSlide() {
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateCarousel();
                updateIndicators();
            }

            function startAutoSlide() {
                autoSlideInterval = setInterval(nextSlide, 3000); // Auto-slide every 3 seconds
            }

            function resetAutoSlide() {
                clearInterval(autoSlideInterval);
                startAutoSlide();
            }

            // Pause auto-slide on hover
            carousel.addEventListener('mouseenter', () => {
                clearInterval(autoSlideInterval);
            });

            carousel.addEventListener('mouseleave', () => {
                startAutoSlide();
            });

            // Initialize carousel
            createIndicators();
            updateIndicators();
            startAutoSlide();

            // Best Selling Products Carousel Functionality
            const bestSellingCarousel = document.getElementById('bestSellingCarousel');
            const bestSellingIndicatorsContainer = document.getElementById('bestSellingIndicators');
            
            let bestSellingCurrentIndex = 0;
            let bestSellingItemsPerView = window.innerWidth <= 768 ? 2 : 4;
            const bestSellingProducts = document.querySelectorAll('#bestSellingCarousel .carousel-product-card');
            let bestSellingTotalItems = bestSellingProducts.length;
            let bestSellingTotalSlides = Math.ceil(bestSellingTotalItems / bestSellingItemsPerView);
            let bestSellingAutoSlideInterval;

            // Update items per view on window resize for best selling carousel
            window.addEventListener('resize', function() {
                const newBestSellingItemsPerView = window.innerWidth <= 768 ? 2 : 4;
                if (newBestSellingItemsPerView !== bestSellingItemsPerView) {
                    bestSellingItemsPerView = newBestSellingItemsPerView;
                    bestSellingTotalSlides = Math.ceil(bestSellingTotalItems / bestSellingItemsPerView);
                    bestSellingCurrentIndex = Math.min(bestSellingCurrentIndex, bestSellingTotalSlides - 1);
                    updateBestSellingCarousel();
                    createBestSellingIndicators();
                    updateBestSellingIndicators();
                }
            });

            function updateBestSellingCarousel() {
                const translateX = -(bestSellingCurrentIndex * (100 / bestSellingItemsPerView));
                bestSellingCarousel.style.transform = `translateX(${translateX}%)`;
            }

            function createBestSellingIndicators() {
                bestSellingIndicatorsContainer.innerHTML = '';
                for (let i = 0; i < bestSellingTotalSlides; i++) {
                    const indicator = document.createElement('div');
                    indicator.className = 'carousel-indicator';
                    indicator.addEventListener('click', () => goToBestSellingSlide(i));
                    bestSellingIndicatorsContainer.appendChild(indicator);
                }
            }

            function updateBestSellingIndicators() {
                const indicators = document.querySelectorAll('#bestSellingIndicators .carousel-indicator');
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('active', index === bestSellingCurrentIndex);
                });
            }

            function goToBestSellingSlide(index) {
                bestSellingCurrentIndex = index;
                updateBestSellingCarousel();
                updateBestSellingIndicators();
                resetBestSellingAutoSlide();
            }

            function nextBestSellingSlide() {
                bestSellingCurrentIndex = (bestSellingCurrentIndex + 1) % bestSellingTotalSlides;
                updateBestSellingCarousel();
                updateBestSellingIndicators();
            }

            function prevBestSellingSlide() {
                bestSellingCurrentIndex = (bestSellingCurrentIndex - 1 + bestSellingTotalSlides) % bestSellingTotalSlides;
                updateBestSellingCarousel();
                updateBestSellingIndicators();
            }

            function startBestSellingAutoSlide() {
                bestSellingAutoSlideInterval = setInterval(nextBestSellingSlide, 3500); // Auto-slide every 3.5 seconds
            }

            function resetBestSellingAutoSlide() {
                clearInterval(bestSellingAutoSlideInterval);
                startBestSellingAutoSlide();
            }

            // Best Selling Event listeners
            // Pause auto-slide on hover for best selling carousel
            if (bestSellingCarousel) {
                bestSellingCarousel.addEventListener('mouseenter', () => {
                    clearInterval(bestSellingAutoSlideInterval);
                });

                bestSellingCarousel.addEventListener('mouseleave', () => {
                    startBestSellingAutoSlide();
                });

                // Initialize best selling carousel
                createBestSellingIndicators();
                updateBestSellingIndicators();
                startBestSellingAutoSlide();
            }

            // Premium Deal of the Day Shop Now functionality
            document.querySelectorAll('.deal-shop-btn-premium').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    
                    // Redirect directly to checkout page for this product
                    window.location.href = `/checkout/product/${productId}`;
                });
            });

            // Premium Deal of the Day View functionality
            document.querySelectorAll('.deal-view-btn-premium').forEach(button => {
                button.addEventListener('click', function() {
                    // Get product data from button attributes
                    const productId = this.getAttribute('data-id');
                    const productName = this.getAttribute('data-name');
                    const productPrice = this.getAttribute('data-price');
                    const originalPrice = this.getAttribute('data-original-price');
                    const productDescription = this.getAttribute('data-description');
                    const productCategory = this.getAttribute('data-category');
                    const productImage = this.getAttribute('data-image');

                    // Populate the quick view modal with product data
                    const modalImage = document.getElementById('quickViewImage');
                    const modalTitle = document.getElementById('quickViewTitle');
                    const modalPrice = document.getElementById('quickViewPrice');
                    const modalDescription = document.getElementById('quickViewDescription');
                    const addToCartBtn = document.getElementById('quickViewAddToCart');

                    if (modalImage) {
                        modalImage.src = productImage || '/logo.png';
                        modalImage.alt = productName;
                        // Show image after setting src
                        modalImage.onload = function() {
                            this.style.opacity = '1';
                        };
                    }
                    
                    if (modalTitle) modalTitle.textContent = productName;
                    
                    // Show deal pricing if different from original
                    if (modalPrice) {
                        if (originalPrice && parseFloat(originalPrice) !== parseFloat(productPrice)) {
                            modalPrice.innerHTML = `
                                <span style="text-decoration: line-through; color: #999; font-size: 0.8em;">PKR ${parseFloat(originalPrice).toLocaleString()}</span><br>
                                <span style="color: #e53e3e; font-weight: 700;">PKR ${parseFloat(productPrice).toLocaleString()}</span>
                                <span style="background: #48bb78; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.7em; margin-left: 8px;">DEAL</span>
                            `;
                        } else {
                            modalPrice.textContent = `PKR ${parseFloat(productPrice).toLocaleString()}`;
                        }
                    }
                    
                    if (modalDescription) modalDescription.textContent = productDescription;
                    
                    // Update add to cart button with product data
                    if (addToCartBtn) {
                        addToCartBtn.setAttribute('data-id', productId);
                        addToCartBtn.setAttribute('data-name', productName);
                        addToCartBtn.setAttribute('data-price', productPrice);
                        addToCartBtn.setAttribute('data-image', productImage);
                    }
                });
            });

            // Helper function to add to cart (if not already defined)
            function addToCart(product) {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                
                // Check if product already exists in cart
                const existingItem = cart.find(item => item.id === product.id);
                
                if (existingItem) {
                    existingItem.quantity += product.quantity;
                } else {
                    cart.push(product);
                }
                
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
            }

            // Helper function to show toast (if not already defined)
            function showToast(message, type = 'info') {
                // Create toast element
                const toast = document.createElement('div');
                toast.className = `toast-notification toast-${type}`;
                toast.innerHTML = `
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
                    <span>${message}</span>
                `;
                
                // Add styles
                toast.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: ${type === 'success' ? '#48bb78' : '#4299e1'};
                    color: white;
                    padding: 1rem 1.5rem;
                    border-radius: 8px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                    z-index: 10000;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    font-weight: 500;
                    animation: slideInRight 0.3s ease;
                `;
                
                document.body.appendChild(toast);
                
                // Remove after 3 seconds
                setTimeout(() => {
                    toast.style.animation = 'slideOutRight 0.3s ease';
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 300);
                }, 3000);
            }

            // Helper function to update cart UI (if not already defined)
            function updateCartUI() {
                const cart = JSON.parse(localStorage.getItem('cart')) || [];
                const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
                
                // Update cart count in header if element exists
                const cartCountElement = document.querySelector('.cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = cartCount;
                    cartCountElement.style.display = cartCount > 0 ? 'inline' : 'none';
                }
            }

            // Announcement Carousel Functionality
            let currentAnnouncementSlide = 0;
            const announcementSlides = document.querySelectorAll('.announcement-slide');
            const announcementDots = document.querySelectorAll('.announcement-dots .dot');
            let announcementInterval;

            function showAnnouncementSlide(index) {
                if (announcementSlides.length === 0) return;
                
                // Remove active class from all slides and dots
                announcementSlides.forEach(slide => slide.classList.remove('active'));
                announcementDots.forEach(dot => dot.classList.remove('active'));
                
                // Add active class to current slide and dot
                if (announcementSlides[index]) {
                    announcementSlides[index].classList.add('active');
                }
                if (announcementDots[index]) {
                    announcementDots[index].classList.add('active');
                }
                
                currentAnnouncementSlide = index;
            }

            function nextAnnouncementSlide() {
                const nextIndex = (currentAnnouncementSlide + 1) % announcementSlides.length;
                showAnnouncementSlide(nextIndex);
            }

            function startAnnouncementCarousel() {
                if (announcementSlides.length > 1) {
                    announcementInterval = setInterval(nextAnnouncementSlide, 8000); // 8 seconds per slide
                }
            }

            function stopAnnouncementCarousel() {
                clearInterval(announcementInterval);
            }

            // Initialize announcement carousel
            if (announcementSlides.length > 0) {
                // Add click event to dots
                announcementDots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        stopAnnouncementCarousel();
                        showAnnouncementSlide(index);
                        startAnnouncementCarousel();
                    });
                });

                // Pause on hover
                const announcementSection = document.querySelector('.announcements-section');
                if (announcementSection) {
                    announcementSection.addEventListener('mouseenter', stopAnnouncementCarousel);
                    announcementSection.addEventListener('mouseleave', startAnnouncementCarousel);
                }

                // Start the carousel
                startAnnouncementCarousel();
            }

            // Countdown Timer Functionality
            function updateCountdowns() {
                document.querySelectorAll('.announcement-countdown').forEach(countdown => {
                    const targetDate = new Date(countdown.dataset.countdown);
                    const now = new Date();
                    const difference = targetDate - now;

                    if (difference > 0) {
                        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                        const daysEl = countdown.querySelector('.days');
                        const hoursEl = countdown.querySelector('.hours');
                        const minutesEl = countdown.querySelector('.minutes');
                        const secondsEl = countdown.querySelector('.seconds');

                        if (daysEl) daysEl.textContent = days.toString().padStart(2, '0');
                        if (hoursEl) hoursEl.textContent = hours.toString().padStart(2, '0');
                        if (minutesEl) minutesEl.textContent = minutes.toString().padStart(2, '0');
                        if (secondsEl) secondsEl.textContent = seconds.toString().padStart(2, '0');
                    } else {
                        // Countdown expired
                        countdown.style.display = 'none';
                    }
                });
            }

            // Update countdowns every second
            if (document.querySelector('.announcement-countdown')) {
                setInterval(updateCountdowns, 1000);
                updateCountdowns(); // Initial call
            }

        });
    </script>

    @if(session('success') && session('clear_cart'))
        <script>
            // Clear cart on successful order
            localStorage.removeItem('cart');
            localStorage.removeItem('ts-cart');
            
            // Update cart count displays (multiple cart systems)
            const cartCountElements = document.querySelectorAll('.cart-count, .ts-cart-count');
            cartCountElements.forEach(element => {
                if (element) {
                    element.textContent = '0';
                    element.style.display = 'none';
                }
            });
            
            // Update global cart objects if they exist
            if (typeof window.cart !== 'undefined') {
                window.cart = {};
            }
            if (typeof window.shopManager !== 'undefined' && window.shopManager.cart) {
                window.shopManager.cart = [];
                if (typeof window.shopManager.updateCartUI === 'function') {
                    window.shopManager.updateCartUI();
                }
            }
            if (typeof window.updateCartDisplay === 'function') {
                window.updateCartDisplay();
            }
        </script>
    @endif

    <!-- Moving Reviews Section -->
    @if($fiveStarReviews->count() > 0)
    <section class="moving-reviews-section">
        <div class="moving-reviews-wrapper">
            <div class="moving-reviews-track">
                @foreach($fiveStarReviews as $review)
                <div class="review-item">
                    <div class="review-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                    </div>
                    <div class="review-text">
                        "{{ Str::limit($review->comment ?: $review->title, 80) }}"
                    </div>
                    <div class="review-author">
                        - {{ $review->masked_name }}
                        @if($review->product)
                            <span class="review-product">for {{ $review->product->name }}</span>
                        @endif
                    </div>
                </div>
                @endforeach
                <!-- Duplicate for seamless infinite loop -->
                @foreach($fiveStarReviews as $review)
                <div class="review-item">
                    <div class="review-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                    </div>
                    <div class="review-text">
                        "{{ Str::limit($review->comment ?: $review->title, 80) }}"
                    </div>
                    <div class="review-author">
                        - {{ $review->masked_name }}
                        @if($review->product)
                            <span class="review-product">for {{ $review->product->name }}</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <style>
    /* Moving Reviews Section - Minimal styling with proper spacing */
    .moving-reviews-section {
        overflow: hidden;
        position: relative;
        margin: 30px 0 20px 0;
        padding: 15px 0;
    }

    .moving-reviews-wrapper {
        position: relative;
        width: 100%;
        height: 50px;
        overflow: hidden;
    }

    .moving-reviews-track {
        display: flex;
        gap: 3rem;
        animation: moveReviewsInfinite 120s linear infinite;
        white-space: nowrap;
        align-items: center;
        height: 100%;
        width: max-content;
    }

    @keyframes moveReviewsInfinite {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }

    .review-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
        background: white;
        padding: 8px 12px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #f0f0f0;
    }

    .review-stars {
        display: flex;
        gap: 1px;
        flex-shrink: 0;
    }

    .review-stars .fas.fa-star {
        color: #ffc107;
        font-size: 10px;
    }

    .review-text {
        font-size: 11px;
        color: #666;
        font-style: italic;
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        line-height: 1.2;
    }

    .review-author {
        font-size: 10px;
        color: #8D68AD;
        font-weight: 500;
        flex-shrink: 0;
    }

    .review-product {
        color: #999;
        font-weight: 400;
        font-size: 9px;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .moving-reviews-section {
            margin: 20px 0 15px 0;
            padding: 10px 0;
        }
        
        .moving-reviews-wrapper {
            height: 45px;
        }
        
        .review-item {
            padding: 6px 10px;
            gap: 0.4rem;
        }
        
        .review-stars .fas.fa-star {
            font-size: 9px;
        }
        
        .review-text {
            font-size: 10px;
            max-width: 140px;
        }
        
        .review-author {
            font-size: 9px;
        }
        
        .review-product {
            font-size: 8px;
        }
        
        .moving-reviews-track {
            gap: 2rem;
            animation-duration: 100s;
        }
    }

    @media (max-width: 480px) {
        .moving-reviews-wrapper {
            height: 40px;
        }
        
        .review-item {
            padding: 5px 8px;
            gap: 0.3rem;
        }
        
        .review-text {
            font-size: 9px;
            max-width: 120px;
        }
        
        .review-author {
            font-size: 8px;
        }
        
        .review-product {
            font-size: 7px;
        }
        
        .moving-reviews-track {
            gap: 1.5rem;
            animation-duration: 80s;
        }
    }
    </style>
@endsection
