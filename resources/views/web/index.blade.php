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
}

</style>
    
    <!-- Featured Categories Section -->
    <section class="home-feat pt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="home-feat__card">
                        <div class="home-feat__content">
                            <i class="fas fa-soap home-feat__icon"></i>
                            <h3 class="home-feat__title">Handmade Soaps</h3>
                            <p class="home-feat__text">Pure & natural ingredients</p>
                            <a href="/shop" class="home-feat__link">Shop Now →</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="home-feat__card">
                        <div class="home-feat__content">
                            <i class="fas fa-seedling home-feat__icon"></i>
                            <h3 class="home-feat__title">Organic Skincare</h3>
                            <p class="home-feat__text">Nature's best for your skin</p>
                            <a href="/shop" class="home-feat__link">Shop Now →</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="home-feat__card">
                        <div class="home-feat__content">
                            <i class="fas fa-spa home-feat__icon"></i>
                            <h3 class="home-feat__title">Beauty Essentials</h3>
                            <p class="home-feat__text">Pamper yourself naturally</p>
                            <a href="/shop" class="home-feat__link">Shop Now →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


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

    <!-- Products Section - Using your existing grid -->
    <section class="home-products py-5">
        <div class="container">
            <div class="home-products__header text-center mb-5">
                <span class="home-products__subtitle">Natural Beauty</span>
                <h2 class="home-products__title">Featured Products</h2>
            </div>

            <!-- Category Filter -->
            <div class="home-filter mb-4">
                <div class="home-filter__wrap">
                    <button class="home-filter__btn active" data-category="all">All Products</button>
                    <button class="home-filter__btn" data-category="new">New Arrivals</button>
                    <button class="home-filter__btn" data-category="featured">Best Sellers</button>
                    <button class="home-filter__btn" data-category="sale">Special Offers</button>
                </div>
            </div>

            <!-- Your existing product grid -->
            <div class="ts-product-grid"
                style="flex: 1 !important; display: grid !important; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)) !important; gap: 1.5rem !important; align-content: start !important; margin-left: 0 !important;">
                @foreach ($products as $product)
                    <div class="ts-product-card" data-price="{{ $product->price }}"
                        data-category="{{ $product->category_id }}" data-flag="{{ $product->flag }}"
                        style="background: #fff !important; border-radius: 12px !important; overflow: hidden !important; transition: all 0.3s ease !important; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08) !important; display: flex !important; flex-direction: column !important;">

                        <div class="ts-product-image-wrapper"
                            style="position: relative !important; padding-top: 100% !important; background: #f8f9fa !important; overflow: hidden !important;">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                style="position: absolute !important; top: 0 !important; left: 0 !important; width: 100% !important; height: 100% !important; object-fit: cover !important; transition: transform 0.5s ease !important;">

                            <button class="ts-quick-view-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"
                                data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}" data-description="{{ $product->description }}"
                                data-category="{{ $product->category->name }}"
                                data-image="{{ asset('storage/' . $product->image) }}"
                                style="position: absolute !important; top: 1rem !important; right: 1rem !important; width: 35px !important; height: 35px !important; border-radius: 50% !important; background: rgba(255, 255, 255, 0.9) !important; border: none !important; display: flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; transition: all 0.3s ease !important; z-index: 1 !important;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <div class="ts-product-details"
                            style="padding: 1.25rem !important; display: flex !important; flex-direction: column !important; gap: 0.75rem !important;">
                            <h3 class="ts-product-title"
                                style="font-size: 1.1rem !important; font-weight: 600 !important; color: #333 !important; margin: 0 !important; line-height: 1.4 !important;">
                                {{ $product->name }}
                            </h3>

                            <div class="ts-product-meta"
                                style="display: flex !important; justify-content: space-between !important; align-items: center !important;">
                                <span class="ts-product-category"
                                    style="color: #666 !important; font-size: 0.9rem !important;">
                                    {{ $product->category->name }}
                                </span>
                                <span class="ts-product-price"
                                    style="color: #8D68AD !important; font-weight: 700 !important; font-size: 1.15rem !important;">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </div>

                            <button class="ts-add-to-cart-btn" data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                data-image="{{ asset('storage/' . $product->image) }}"
                                style="width: 100% !important; padding: 0.75rem !important; background: #8D68AD !important; color: #fff !important; border: none !important; border-radius: 6px !important; font-weight: 500 !important; display: flex !important; align-items: center !important; justify-content: center !important; gap: 0.5rem !important; cursor: pointer !important; transition: all 0.3s ease !important; margin-top: auto !important;">
                                <i class="fas fa-shopping-cart"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-us py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-subtitle" style="color: #8D68AD; text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem; display: block; margin-bottom: 0.5rem;">Why Choose Us</span>
                <h2 class="section-title" style="font-size: 2.5rem; color: #333; font-weight: 300;">The Taysan Beauty Difference</h2>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center" style="background: white; border-radius: 15px; padding: 2rem 1.5rem; height: 100%; transition: all 0.3s ease; box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);">
                        <div class="feature-icon mb-3" style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #8D68AD, #A67BC9); margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-leaf" style="font-size: 1.8rem; color: white;"></i>
                        </div>
                        <h4 style="color: #333; margin-bottom: 1rem;">100% Natural</h4>
                        <p style="color: #666; font-size: 0.9rem;">Made with pure, organic ingredients sourced from nature's finest</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center" style="background: white; border-radius: 15px; padding: 2rem 1.5rem; height: 100%; transition: all 0.3s ease; box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);">
                        <div class="feature-icon mb-3" style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #8D68AD, #A67BC9); margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-hand-sparkles" style="font-size: 1.8rem; color: white;"></i>
                        </div>
                        <h4 style="color: #333; margin-bottom: 1rem;">Handcrafted</h4>
                        <p style="color: #666; font-size: 0.9rem;">Every product is carefully handmade with love and attention to detail</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center" style="background: white; border-radius: 15px; padding: 2rem 1.5rem; height: 100%; transition: all 0.3s ease; box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);">
                        <div class="feature-icon mb-3" style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #8D68AD, #A67BC9); margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-recycle" style="font-size: 1.8rem; color: white;"></i>
                        </div>
                        <h4 style="color: #333; margin-bottom: 1rem;">Eco-Friendly</h4>
                        <p style="color: #666; font-size: 0.9rem;">Sustainable packaging and environmentally conscious production</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center" style="background: white; border-radius: 15px; padding: 2rem 1.5rem; height: 100%; transition: all 0.3s ease; box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);">
                        <div class="feature-icon mb-3" style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #8D68AD, #A67BC9); margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-heart" style="font-size: 1.8rem; color: white;"></i>
                        </div>
                        <h4 style="color: #333; margin-bottom: 1rem;">Skin Loving</h4>
                        <p style="color: #666; font-size: 0.9rem;">Gentle formulas that nourish and pamper all skin types</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            const products = document.querySelectorAll('.ts-product-card');

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
                });
            });
        });
    </script>
@endsection
