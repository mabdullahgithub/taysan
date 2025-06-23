@extends('web.layout.app')
@section('title', $product->name . ' - Taysan Beauty')
@section('content')
    @include('web.partials.cart_related')
    <!-- Quick View Modal -->
    @include('web.shop.partials.quick-view-modal')
    <!-- Cart Sidebar -->
    @include('web.shop.partials.cart-sidebar')
    @include('web.shop.partials.toast')

    <style>
        :root {
            --primary-color: #8D68AD;
            --primary-light: #A893C4;
            --secondary-color: #f8f0ff;
            --text-color: #333;
            --text-light: #666;
            --border-color: #ddd;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        /* Product Detail Styles */
        .product-detail {
            background: #ffffff;
            padding: 120px 0 80px;
        }

        .product-detail-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Breadcrumb */
        .product-breadcrumb {
            margin-bottom: 40px;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            padding: 0;
            list-style: none;
            font-size: 0.9rem;
        }

        .breadcrumb-item {
            color: var(--text-light);
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-light);
        }

        .breadcrumb-separator {
            color: var(--text-light);
            margin: 0 5px;
        }

        /* Product Main Content */
        .product-main {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-bottom: 80px;
        }

        /* Image Gallery */
        .product-gallery {
            position: sticky;
            top: 120px;
            height: fit-content;
        }

        .main-image-container {
            position: relative;
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .main-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .zoom-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .zoom-overlay:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Deal Badge */
        .deal-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(135deg, #FF6B6B, #FF8E8E);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 10;
            animation: dealPulse 2s infinite;
        }

        @keyframes dealPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* Thumbnail Gallery */
        .thumbnail-gallery {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 5px 0;
        }

        .thumbnail {
            min-width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .thumbnail.active {
            border-color: var(--primary-color);
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumbnail:hover {
            border-color: var(--primary-light);
            transform: translateY(-2px);
        }

        /* Product Info */
        .product-info {
            padding: 20px 0;
        }

        .product-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .deal-badge-special {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(238, 90, 36, 0.3);
            animation: pulse-deal 2s infinite;
        }

        @keyframes pulse-deal {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .product-sku {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .stars {
            color: #FFD700;
            font-size: 1.1rem;
        }

        .rating-text {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* Price Section */
        .price-section {
            margin-bottom: 30px;
            padding: 20px;
            background: var(--secondary-color);
            border-radius: 12px;
        }

        .price-container {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .current-price {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .original-price {
            font-size: 1.5rem;
            color: var(--text-light);
            text-decoration: line-through;
        }

        .savings-badge {
            background: var(--success-color);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Product Badges */
        .product-badges {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-organic { background: #28a745; color: white; }
        .badge-vegan { background: #17a2b8; color: white; }
        .badge-cruelty-free { background: #6f42c1; color: white; }

        /* Stock Status */
        .stock-status {
            margin-bottom: 30px;
        }

        .stock-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .stock-indicator.in-stock {
            color: var(--success-color);
        }

        .stock-indicator.low-stock {
            color: var(--warning-color);
        }

        .stock-indicator.out-of-stock {
            color: var(--danger-color);
        }

        .stock-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
        }

        /* Add to Cart Section */
        .add-to-cart-section {
            background: #f9f9f9;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 40px;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .quantity-label {
            font-weight: 500;
            color: var(--text-color);
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .quantity-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: var(--primary-light);
        }

        .quantity-input {
            width: 60px;
            height: 40px;
            text-align: center;
            border: none;
            background: white;
            font-weight: 500;
        }

        .cart-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .cart-actions .btn-buy-now:only-child {
            flex: 1;
        }

        .btn-add-cart {
            flex: 1;
            min-width: 200px;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-add-cart:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }

        .btn-buy-now {
            background: #28a745;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-buy-now:hover {
            background: #218838;
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }

        /* Product Tabs */
        .product-tabs {
            margin-bottom: 60px;
        }

        .tab-nav {
            display: flex;
            border-bottom: 2px solid #eee;
            margin-bottom: 30px;
            gap: 0;
        }

        .tab-btn {
            padding: 15px 25px;
            background: none;
            border: none;
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-light);
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }

        .tab-btn.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .tab-content h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .tab-content p, .tab-content ul {
            color: var(--text-color);
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .tab-content ul {
            padding-left: 20px;
        }

        /* Product Tags */
        .product-tags {
            margin-top: 30px;
        }

        .tags-list {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .tag {
            background: #f8f9fa;
            color: var(--text-color);
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            border: 1px solid #e9ecef;
        }

        /* Related Products Carousel */
        .related-products {
            margin-top: 80px;
            background: #f8f9fa;
            padding: 60px 0;
            margin-left: -2rem;
            margin-right: -2rem;
            border-radius: 20px;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 300;
            color: var(--text-color);
            text-align: center;
            margin-bottom: 50px;
        }

        .related-products-carousel-container {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .related-carousel-nav {
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

        .related-carousel-nav:hover {
            background: #8D68AD;
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .related-carousel-nav-prev {
            left: -25px;
        }

        .related-carousel-nav-next {
            right: -25px;
        }

        .related-carousel-wrapper {
            overflow: hidden;
            border-radius: 15px;
        }

        .related-carousel {
            display: flex;
            transition: transform 0.5s ease;
            gap: 20px;
        }

        .related-product {
            min-width: calc(25% - 15px); /* 4 products on desktop */
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .related-product:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .related-product-image {
            position: relative;
            padding-top: 100%;
            overflow: hidden;
        }

        .related-product-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .related-product:hover .related-product-image img {
            transform: scale(1.1);
        }

        .related-product-info {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex-grow: 1;
        }

        .related-product-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 5px;
            line-height: 1.4;
        }

        .related-product-category {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .related-product-price {
            color: var(--primary-color);
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .related-product-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .related-view-btn {
            flex: 1;
            padding: 8px 12px;
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .related-view-btn:hover {
            background: var(--primary-color);
            color: white;
            text-decoration: none;
        }

        .related-add-cart-btn {
            flex: 2;
            padding: 8px 12px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .related-add-cart-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        /* Carousel Indicators */
        .related-carousel-indicators {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            gap: 8px;
        }

        .related-carousel-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(141, 104, 173, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .related-carousel-indicator.active {
            background: #8D68AD;
            transform: scale(1.2);
        }

        /* Mobile Responsive Styles for Related Carousel */
        @media (max-width: 768px) {
            .related-products {
                margin-left: -15px;
                margin-right: -15px;
                padding: 40px 0;
            }

            .related-product {
                min-width: calc(50% - 10px); /* 2 products on mobile */
            }

            .related-carousel-nav {
                width: 40px;
                height: 40px;
                font-size: 0.9rem;
            }

            .related-carousel-nav-prev {
                left: -20px;
            }

            .related-carousel-nav-next {
                right: -20px;
            }

            .related-carousel {
                gap: 15px;
            }

            .section-title {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 480px) {
            .related-carousel-nav-prev {
                left: -15px;
            }

            .related-carousel-nav-next {
                right: -15px;
            }

            .related-carousel-nav {
                width: 35px;
                height: 35px;
                font-size: 0.8rem;
            }

            .related-carousel {
                gap: 12px;
            }

            .related-product-info {
                padding: 15px;
            }

            .related-product-title {
                font-size: 1rem;
            }

            .related-product-price {
                font-size: 1rem;
            }

            .related-product-actions {
                flex-direction: column;
            }
        }

        .related-product-price {
            color: var(--primary-color);
            font-size: 1.2rem;
            font-weight: 700;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-detail {
                padding: 100px 0 60px;
            }

            .product-main {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .product-gallery {
                position: static;
            }

            .main-image {
                height: 400px;
            }

            .product-title {
                font-size: 2rem;
            }

            .current-price {
                font-size: 2rem;
            }

            .cart-actions {
                flex-direction: column;
            }

            .btn-add-cart {
                min-width: 100%;
            }

            .tab-nav {
                flex-wrap: wrap;
            }

            .tab-btn {
                flex: 1;
                min-width: 120px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .product-detail-container {
                padding: 0 15px;
            }

            .product-title {
                font-size: 1.6rem;
            }

            .current-price {
                font-size: 1.8rem;
            }

            .thumbnail-gallery {
                gap: 8px;
            }

            .thumbnail {
                min-width: 60px;
                height: 60px;
            }

            .add-to-cart-section {
                padding: 20px;
            }

            .quantity-controls {
                flex: 1;
            }
        }

        /* Image Zoom Modal */
        .zoom-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .zoom-modal.active {
            display: flex;
        }

        .zoom-content {
            max-width: 90%;
            max-height: 90%;
            position: relative;
        }

        .zoom-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .zoom-close {
            position: absolute;
            top: -50px;
            right: 0;
            background: none;
            border: none;
            color: white;
            font-size: 2rem;
            cursor: pointer;
        }
    </style>

    <div class="product-detail">
        <div class="product-detail-container">
            <!-- Breadcrumb -->
            <div class="product-breadcrumb">
                <nav class="breadcrumb">
                    <span class="breadcrumb-item"><a href="{{ route('web.view.index') }}">Home</a></span>
                    <span class="breadcrumb-separator">›</span>
                    <span class="breadcrumb-item"><a href="{{ route('web.view.shop') }}">Shop</a></span>
                    <span class="breadcrumb-separator">›</span>
                    <span class="breadcrumb-item"><a href="{{ route('web.view.shop') }}?category={{ $product->category->id }}">{{ $product->category->name }}</a></span>
                    <span class="breadcrumb-separator">›</span>
                    <span class="breadcrumb-item">{{ $product->name }}</span>
                </nav>
            </div>

            <!-- Main Product Content -->
            <div class="product-main">
                <!-- Image Gallery -->
                <div class="product-gallery">
                    <div class="main-image-container">
                        @if($deal)
                            <div class="deal-badge">
                                {{ round($deal->discount_percentage) }}% OFF
                            </div>
                        @endif
                        <img src="{{ $product->all_images[0] }}" alt="{{ $product->name }}" class="main-image" id="mainImage">
                        <div class="zoom-overlay" onclick="openZoom()">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                    
                    @if($product->hasMultipleImages())
                    <div class="thumbnail-gallery">
                        @foreach($product->all_images as $index => $image)
                        <div class="thumbnail {{ $index === 0 ? 'active' : '' }}" onclick="changeMainImage('{{ $image }}', this)">
                            <img src="{{ $image }}" alt="{{ $product->name }}">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="product-info">
                    <h1 class="product-title">{{ $product->name }}</h1>
                    
                    @if($fromDeal)
                    <div class="deal-badge-special">
                        <i class="fas fa-fire"></i>
                        Deal of the Day Special
                    </div>
                    @endif
                    
                    @if($product->sku)
                    <div class="product-sku">SKU: {{ $product->sku }}</div>
                    @endif

                    <!-- Rating (Placeholder for future implementation) -->
                    <div class="product-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="rating-text">(0 reviews)</span>
                    </div>

                    <!-- Price Section -->
                    <div class="price-section">
                        <div class="price-container">
                            @if($deal)
                                <span class="current-price">PKR {{ number_format($deal->final_price, 0) }}</span>
                                <span class="original-price">PKR {{ number_format($product->price, 0) }}</span>
                                <span class="savings-badge">Save PKR {{ number_format($deal->savings, 0) }}</span>
                            @else
                                <span class="current-price">PKR {{ number_format($product->price, 0) }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Product Badges -->
                    @if($product->is_organic || $product->is_vegan || $product->is_cruelty_free)
                    <div class="product-badges">
                        @if($product->is_organic)
                            <span class="badge badge-organic">Organic</span>
                        @endif
                        @if($product->is_vegan)
                            <span class="badge badge-vegan">Vegan</span>
                        @endif
                        @if($product->is_cruelty_free)
                            <span class="badge badge-cruelty-free">Cruelty-Free</span>
                        @endif
                    </div>
                    @endif

                    <!-- Stock Status -->
                    <div class="stock-status">
                        @if($product->stock > 10)
                            <div class="stock-indicator in-stock">
                                <span class="stock-dot"></span>
                                In Stock ({{ $product->stock }} available)
                            </div>
                        @elseif($product->stock > 0)
                            <div class="stock-indicator low-stock">
                                <span class="stock-dot"></span>
                                Low Stock ({{ $product->stock }} left)
                            </div>
                        @else
                            <div class="stock-indicator out-of-stock">
                                <span class="stock-dot"></span>
                                Out of Stock
                            </div>
                        @endif
                    </div>

                    <!-- Add to Cart Section -->
                    @if($product->stock > 0)
                    <div class="add-to-cart-section">
                        <div class="quantity-selector">
                            <span class="quantity-label">Quantity:</span>
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="decreaseQuantity()">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" class="quantity-input" id="productQuantity" value="1" min="1" max="{{ $product->stock }}">
                                <button class="quantity-btn" onclick="increaseQuantity()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="cart-actions">
                            @if(!$fromDeal)
                            <button class="btn-add-cart" 
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->price }}"
                                    data-image="{{ $product->all_images[0] }}"
                                    data-deal="false">
                                <i class="fas fa-shopping-cart"></i>
                                Add to Cart
                            </button>
                            @endif
                            <a href="{{ route('web.checkout.product', $product->id) }}" class="btn-buy-now">
                                <i class="fas fa-bolt"></i>
                                Buy Now
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="add-to-cart-section">
                        <button class="btn-add-cart" disabled style="opacity: 0.5; cursor: not-allowed;">
                            <i class="fas fa-times"></i>
                            Out of Stock
                        </button>
                    </div>
                    @endif

                    <!-- Product Tags -->
                    @if($product->tags)
                    <div class="product-tags">
                        <div class="tags-list">
                            @foreach($product->tags as $tag)
                                <span class="tag">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Tabs -->
            <div class="product-tabs">
                <div class="tab-nav">
                    <button class="tab-btn active" onclick="showTab('description')">Description</button>
                    @if($product->detailed_description)
                    <button class="tab-btn" onclick="showTab('details')">Details</button>
                    @endif
                    @if($product->ingredients)
                    <button class="tab-btn" onclick="showTab('ingredients')">Ingredients</button>
                    @endif
                    @if($product->benefits)
                    <button class="tab-btn" onclick="showTab('benefits')">Benefits</button>
                    @endif
                    @if($product->usage_instructions)
                    <button class="tab-btn" onclick="showTab('usage')">How to Use</button>
                    @endif
                    <button class="tab-btn" onclick="showTab('shipping')">Shipping Info</button>
                </div>

                <div class="tab-content active" id="description">
                    <h3>Product Description</h3>
                    <p>{{ $product->description }}</p>
                    
                    @if($product->weight || $product->dimensions || $product->origin_country)
                    <h3>Product Specifications</h3>
                    <ul>
                        @if($product->weight)
                        <li><strong>Weight:</strong> {{ $product->weight }}g</li>
                        @endif
                        @if($product->dimensions)
                        <li><strong>Dimensions:</strong> {{ $product->dimensions }}</li>
                        @endif
                        @if($product->origin_country)
                        <li><strong>Origin:</strong> {{ $product->origin_country }}</li>
                        @endif
                    </ul>
                    @endif
                </div>

                @if($product->detailed_description)
                <div class="tab-content" id="details">
                    <h3>Detailed Information</h3>
                    <p>{{ $product->detailed_description }}</p>
                </div>
                @endif

                @if($product->ingredients)
                <div class="tab-content" id="ingredients">
                    <h3>Ingredients</h3>
                    <p>{{ $product->ingredients }}</p>
                </div>
                @endif

                @if($product->benefits)
                <div class="tab-content" id="benefits">
                    <h3>Benefits</h3>
                    <p>{{ $product->benefits }}</p>
                </div>
                @endif

                @if($product->usage_instructions)
                <div class="tab-content" id="usage">
                    <h3>How to Use</h3>
                    <p>{{ $product->usage_instructions }}</p>
                </div>
                @endif

                <div class="tab-content" id="shipping">
                    <h3>Shipping Information</h3>
                    <ul>
                        <li><strong>Free Shipping:</strong> On orders over PKR {{ number_format($freeShippingThreshold ?? 2000, 0) }}</li>
                        <li><strong>Delivery Time:</strong> 3-5 business days</li>
                        <li><strong>Shipping Cost:</strong> PKR {{ number_format($shippingCharges ?? 150, 0) }}</li>
                        <li><strong>Return Policy:</strong> 30-day return policy</li>
                    </ul>
                </div>
            </div>

            <!-- Related Products Carousel -->
            @if($relatedProducts->count() > 0)
            <div class="related-products">
                <h2 class="section-title">You May Also Like</h2>
                <div class="related-products-carousel-container">
                    <!-- Navigation Arrows -->
                    <button class="related-carousel-nav related-carousel-nav-prev" id="relatedCarouselPrev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="related-carousel-nav related-carousel-nav-next" id="relatedCarouselNext">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <!-- Carousel Wrapper -->
                    <div class="related-carousel-wrapper">
                        <div class="related-carousel" id="relatedCarousel">
                            @foreach($relatedProducts as $relatedProduct)
                            <div class="related-product">
                                <div class="related-product-image">
                                    <img src="{{ $relatedProduct->all_images[0] }}" alt="{{ $relatedProduct->name }}">
                                </div>
                                <div class="related-product-info">
                                    <div class="related-product-category">{{ $relatedProduct->category->name }}</div>
                                    <h3 class="related-product-title">{{ $relatedProduct->name }}</h3>
                                    <div class="related-product-price">PKR {{ number_format($relatedProduct->price, 0) }}</div>
                                    <div class="related-product-actions">
                                        <a href="{{ route('web.product.show', $relatedProduct) }}" class="related-view-btn">
                                            <i class="fas fa-eye"></i>
                                            View
                                        </a>
                                        <button class="related-add-cart-btn btn-add-cart"
                                                data-id="{{ $relatedProduct->id }}"
                                                data-name="{{ $relatedProduct->name }}"
                                                data-price="{{ $relatedProduct->price }}"
                                                data-image="{{ $relatedProduct->all_images[0] }}">
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
                    <div class="related-carousel-indicators" id="relatedCarouselIndicators">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Image Zoom Modal -->
    <div class="zoom-modal" id="zoomModal" onclick="closeZoom()">
        <div class="zoom-content">
            <button class="zoom-close" onclick="closeZoom()">×</button>
            <img src="" alt="" class="zoom-image" id="zoomImage">
        </div>
    </div>

    <script>
        // Tab functionality
        function showTab(tabId) {
            // Remove active class from all tabs and contents
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            event.target.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        }

        // Image gallery functionality
        function changeMainImage(imageSrc, thumbnail) {
            document.getElementById('mainImage').src = imageSrc;
            
            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
            thumbnail.classList.add('active');
        }

        // Quantity controls
        function increaseQuantity() {
            const input = document.getElementById('productQuantity');
            const max = parseInt(input.getAttribute('max'));
            const current = parseInt(input.value);
            if (current < max) {
                input.value = current + 1;
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('productQuantity');
            const current = parseInt(input.value);
            if (current > 1) {
                input.value = current - 1;
            }
        }

        // Image zoom functionality
        function openZoom() {
            const mainImage = document.getElementById('mainImage');
            const zoomImage = document.getElementById('zoomImage');
            const zoomModal = document.getElementById('zoomModal');
            
            zoomImage.src = mainImage.src;
            zoomModal.classList.add('active');
        }

        function closeZoom() {
            document.getElementById('zoomModal').classList.remove('active');
        }

        // Add to cart functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Related Products Carousel
            initRelatedProductsCarousel();
            
            // Add to cart buttons
            document.querySelectorAll('.btn-add-cart').forEach(button => {
                button.addEventListener('click', function() {
                    if (this.disabled) return;
                    
                    const productId = parseInt(this.getAttribute('data-id'));
                    const productName = this.getAttribute('data-name');
                    const productPrice = parseFloat(this.getAttribute('data-price'));
                    const productImage = this.getAttribute('data-image');
                    const isDeal = this.getAttribute('data-deal') === 'true';
                    
                    let quantity = 1;
                    const quantityInput = document.getElementById('productQuantity');
                    if (quantityInput) {
                        quantity = parseInt(quantityInput.value);
                    }
                    
                    // Create cart item object
                    const cartItem = {
                        id: productId,
                        name: productName,
                        price: productPrice,
                        image: productImage,
                        quantity: quantity,
                        isDeal: isDeal
                    };
                    
                    console.log('Adding to cart:', cartItem);
                    
                    // Use shopManager if available
                    if (window.shopManager && typeof window.shopManager.addToCart === 'function') {
                        console.log('Using shopManager.addToCart');
                        window.shopManager.addToCart(cartItem);
                    } else {
                        console.log('Using fallback cart handling');
                        // Fallback to manual cart handling
                        let cart = JSON.parse(localStorage.getItem('ts-cart')) || [];
                        
                        // Check if item already exists in cart
                        const existingItemIndex = cart.findIndex(item => item.id == productId);
                        
                        if (existingItemIndex > -1) {
                            // Update quantity
                            cart[existingItemIndex].quantity += quantity;
                            console.log('Updated existing item quantity');
                        } else {
                            // Add new item
                            cart.push(cartItem);
                            console.log('Added new item to cart');
                        }
                        
                        // Save to localStorage
                        localStorage.setItem('ts-cart', JSON.stringify(cart));
                        console.log('Cart saved to localStorage:', cart);
                        
                        // Update cart count if element exists
                        const cartCountElement = document.querySelector('.ts-cart-count');
                        if (cartCountElement) {
                            const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
                            cartCountElement.textContent = totalQuantity;
                            console.log('Updated cart count:', totalQuantity);
                        }
                        
                        // Show toast message
                        const toast = document.querySelector('.ts-toast');
                        if (toast) {
                            toast.textContent = `Added ${productName} to cart!`;
                            toast.classList.add('show');
                            setTimeout(() => toast.classList.remove('show'), 3000);
                            console.log('Toast shown');
                        } else {
                            console.log('Toast element not found, using alert');
                            alert(`${productName} added to cart!`);
                        }
                    }
                });
            });
        });

        // Related Products Carousel Functionality
        function initRelatedProductsCarousel() {
            const carousel = document.getElementById('relatedCarousel');
            const prevBtn = document.getElementById('relatedCarouselPrev');
            const nextBtn = document.getElementById('relatedCarouselNext');
            const indicatorsContainer = document.getElementById('relatedCarouselIndicators');

            if (!carousel || !prevBtn || !nextBtn) return;

            const products = carousel.querySelectorAll('.related-product');
            const productsPerPage = getProductsPerPage();
            const totalPages = Math.ceil(products.length / productsPerPage);
            let currentPage = 0;

            // Create indicators
            function createIndicators() {
                indicatorsContainer.innerHTML = '';
                for (let i = 0; i < totalPages; i++) {
                    const indicator = document.createElement('div');
                    indicator.classList.add('related-carousel-indicator');
                    if (i === 0) indicator.classList.add('active');
                    indicator.addEventListener('click', () => goToPage(i));
                    indicatorsContainer.appendChild(indicator);
                }
            }

            // Get products per page based on screen size
            function getProductsPerPage() {
                if (window.innerWidth <= 480) return 1;
                if (window.innerWidth <= 768) return 2;
                if (window.innerWidth <= 1024) return 3;
                return 4;
            }

            // Update carousel position
            function updateCarousel() {
                const productWidth = 100 / productsPerPage;
                const translateX = -(currentPage * 100);
                carousel.style.transform = `translateX(${translateX}%)`;

                // Update indicators
                indicatorsContainer.querySelectorAll('.related-carousel-indicator').forEach((indicator, index) => {
                    indicator.classList.toggle('active', index === currentPage);
                });

                // Update navigation buttons
                prevBtn.style.opacity = currentPage === 0 ? '0.5' : '1';
                nextBtn.style.opacity = currentPage === totalPages - 1 ? '0.5' : '1';
            }

            // Go to specific page
            function goToPage(page) {
                if (page >= 0 && page < totalPages) {
                    currentPage = page;
                    updateCarousel();
                }
            }

            // Navigation functions
            function nextSlide() {
                if (currentPage < totalPages - 1) {
                    currentPage++;
                    updateCarousel();
                }
            }

            function prevSlide() {
                if (currentPage > 0) {
                    currentPage--;
                    updateCarousel();
                }
            }

            // Event listeners
            nextBtn.addEventListener('click', nextSlide);
            prevBtn.addEventListener('click', prevSlide);

            // Auto-play functionality (optional)
            let autoPlayInterval;
            function startAutoPlay() {
                autoPlayInterval = setInterval(() => {
                    if (currentPage < totalPages - 1) {
                        nextSlide();
                    } else {
                        currentPage = 0;
                        updateCarousel();
                    }
                }, 5000);
            }

            function stopAutoPlay() {
                clearInterval(autoPlayInterval);
            }

            // Mouse events for auto-play
            carousel.addEventListener('mouseenter', stopAutoPlay);
            carousel.addEventListener('mouseleave', startAutoPlay);

            // Touch events for mobile
            let startX = 0;
            let endX = 0;

            carousel.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                stopAutoPlay();
            });

            carousel.addEventListener('touchend', (e) => {
                endX = e.changedTouches[0].clientX;
                const diff = startX - endX;

                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        nextSlide();
                    } else {
                        prevSlide();
                    }
                }
                startAutoPlay();
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    prevSlide();
                } else if (e.key === 'ArrowRight') {
                    nextSlide();
                }
            });

            // Window resize handler
            window.addEventListener('resize', () => {
                const newProductsPerPage = getProductsPerPage();
                if (newProductsPerPage !== productsPerPage) {
                    location.reload(); // Simple solution for responsive changes
                }
            });

            // Initialize
            createIndicators();
            updateCarousel();
            startAutoPlay();
        }

        // Close zoom modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeZoom();
            }
        });
    </script>

@endsection
