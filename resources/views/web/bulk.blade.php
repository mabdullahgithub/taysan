@extends('web.layout.app')
@section('content')

<style>
    /* Floating Cart Button Styles */
    .ts-floating-cart-btn {
        position: fixed;
        bottom: 85px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #8D68AD, #A67BC9);
        border: none;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        cursor: pointer;
        z-index: 1000;
        transition: all 0.3s ease;
    }

    .ts-floating-cart-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .ts-floating-cart-btn i {
        font-size: 24px;
    }

    .ts-cart-count {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #e74c3c;
        color: white;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
    }

    :root {
        --primary: #8D68AD;
        --primary-light: #A67BC9;
        --primary-dark: #735891;
        --white: #ffffff;
        --black: #333333;
        --gray: #666666;
        --light-gray: #f5f5f5;
        --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    /* Banner Styles */
    .bulk-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        padding: 100px 0;
        color: var(--white);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .bulk-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>') repeat;
        background-size: 50px 50px;
        animation: float 20s linear infinite;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        100% { transform: translateY(-50px); }
    }

    .bulk-banner-title {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        font-weight: 300;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .bulk-banner-breadcrumb {
        list-style: none;
        display: flex;
        justify-content: center;
        margin: 0;
        padding: 0;
        font-size: 1.1rem;
    }

    .bulk-banner-breadcrumb li {
        margin: 0 10px;
        position: relative;
    }

    .bulk-banner-breadcrumb li:not(:last-child)::after {
        content: '/';
        position: absolute;
        right: -15px;
        opacity: 0.7;
    }

    .bulk-banner-breadcrumb a {
        color: var(--white);
        text-decoration: none;
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }

    .bulk-banner-breadcrumb a:hover {
        opacity: 1;
    }

    /* Coming Soon Section */
    .coming-soon-section {
        padding: 100px 0;
        text-align: center;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .coming-soon-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .coming-soon-icon {
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 3rem;
        box-shadow: 0 20px 40px rgba(141, 104, 173, 0.3);
        animation: pulse 3s ease-in-out infinite;
    }

    .coming-soon-icon i {
        font-size: 4rem;
        color: white;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 20px 40px rgba(141, 104, 173, 0.3);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 25px 50px rgba(141, 104, 173, 0.4);
        }
    }

    .coming-soon-title {
        font-size: 3.5rem;
        color: var(--primary);
        margin-bottom: 1.5rem;
        font-weight: 300;
        letter-spacing: 2px;
    }

    .coming-soon-subtitle {
        font-size: 1.8rem;
        color: var(--gray);
        margin-bottom: 2rem;
        font-weight: 400;
    }

    .coming-soon-description {
        font-size: 1.2rem;
        line-height: 1.8;
        color: var(--gray);
        margin-bottom: 3rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .bulk-benefits {
        margin: 4rem 0;
    }

    .benefit-row {
        display: flex;
        align-items: flex-start;
        padding: 1.5rem 0;
        border-bottom: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        gap: 1.5rem;
    }

    .benefit-row:hover {
        background-color: #f9f9f9;
        padding-left: 1rem;
        padding-right: 1rem;
        border-radius: 8px;
        border-bottom-color: transparent;
    }

    .benefit-row:hover .benefit-icon {
        transform: scale(1.1) rotate(10deg);
        color: var(--primary);
    }

    .benefit-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .benefit-icon {
        font-size: 2.5rem;
        color: var(--primary-light);
        transition: all 0.4s ease;
        animation: pulse 2s infinite;
        flex-shrink: 0;
        width: 60px;
        text-align: center;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    .benefit-content {
        flex: 1;
        text-align: left;
    }

    .benefit-title {
        font-size: 1.4rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .benefit-description {
        color: var(--gray);
        line-height: 1.6;
        font-size: 1rem;
        margin: 0;
    }

    .notify-section {
        background: white;
        padding: 3rem;
        border-radius: 20px;
        box-shadow: var(--shadow-lg);
        margin-top: 3rem;
    }

    .notify-title {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .notify-description {
        color: var(--gray);
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }

    .contact-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .contact-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid;
    }

    .contact-btn.whatsapp {
        background: #25D366;
        color: white;
        border-color: #25D366;
    }

    .contact-btn.whatsapp:hover {
        background: #20B954;
        border-color: #20B954;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
        color: white;
        text-decoration: none;
    }

    .contact-btn.email {
        background: transparent;
        color: var(--primary);
        border-color: var(--primary);
    }

    .contact-btn.email:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(141, 104, 173, 0.4);
        text-decoration: none;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .bulk-banner-title {
            font-size: 2.5rem;
        }

        .coming-soon-title {
            font-size: 2.5rem;
        }

        .coming-soon-subtitle {
            font-size: 1.4rem;
        }

        .coming-soon-description {
            font-size: 1rem;
        }

        .coming-soon-icon {
            width: 120px;
            height: 120px;
        }

        .coming-soon-icon i {
            font-size: 3rem;
        }

        .bulk-benefits {
            margin: 3rem 0;
        }

        .benefit-row {
            flex-direction: row;
            gap: 1rem;
            padding: 1.2rem 0;
        }

        .benefit-row:hover {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .benefit-icon {
            font-size: 2rem;
            width: 50px;
        }

        .benefit-title {
            font-size: 1.2rem;
        }

        .benefit-description {
            font-size: 0.95rem;
        }

        .contact-buttons {
            flex-direction: column;
            align-items: center;
        }

        .contact-btn {
            width: 100%;
            max-width: 300px;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .bulk-banner-title {
            font-size: 2rem;
        }

        .coming-soon-title {
            font-size: 2rem;
        }

        .coming-soon-subtitle {
            font-size: 1.2rem;
        }

        .benefit-row {
            flex-direction: row;
            gap: 0.8rem;
            padding: 1rem 0;
        }

        .benefit-icon {
            font-size: 1.8rem;
            width: 40px;
        }

        .benefit-title {
            font-size: 1.1rem;
        }

        .benefit-description {
            font-size: 0.9rem;
        }

        .notify-section {
            padding: 2rem;
        }
    }
</style>

<!-- Banner Section -->
<section class="bulk-banner">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="bulk-banner-content">
                    <h1 class="bulk-banner-title">Bulk Orders</h1>
                    <ol class="bulk-banner-breadcrumb">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Bulk Orders</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Coming Soon Section -->
<section class="coming-soon-section">
    <div class="container">
        <div class="coming-soon-container">
            
            <!-- Coming Soon Icon -->
            <div class="coming-soon-icon">
                <i class="fas fa-boxes"></i>
            </div>

            <!-- Main Content -->
            <h1 class="coming-soon-title">Coming Soon</h1>
            <h2 class="coming-soon-subtitle">Bulk & Wholesale Orders</h2>
            
            <p class="coming-soon-description">
                We're working hard to bring you an amazing bulk ordering experience! Soon, you'll be able to purchase our premium natural soaps and skincare products in bulk quantities with special wholesale pricing for businesses, spas, hotels, and resellers.
            </p>

            <!-- Benefits Section -->
            <div class="bulk-benefits">
                <div class="benefit-row">
                    <div class="benefit-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="benefit-content">
                        <h3 class="benefit-title">Special Pricing</h3>
                        <p class="benefit-description">Enjoy exclusive wholesale rates and volume discounts on all our natural beauty products.</p>
                    </div>
                </div>

                <div class="benefit-row">
                    <div class="benefit-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="benefit-content">
                        <h3 class="benefit-title">Priority Shipping</h3>
                        <p class="benefit-description">Fast and reliable delivery for your bulk orders with tracking and insurance included.</p>
                    </div>
                </div>

                <div class="benefit-row">
                    <div class="benefit-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="benefit-content">
                        <h3 class="benefit-title">Business Partnership</h3>
                        <p class="benefit-description">Dedicated support and flexible terms for long-term business partnerships.</p>
                    </div>
                </div>

                <div class="benefit-row">
                    <div class="benefit-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="benefit-content">
                        <h3 class="benefit-title">Premium Quality</h3>
                        <p class="benefit-description">All our handcrafted products maintain the same high quality standards in bulk quantities.</p>
                    </div>
                </div>
            </div>

            <!-- Notification Section -->
            <div class="notify-section">
                <h3 class="notify-title">Get Notified When We Launch</h3>
                <p class="notify-description">
                    Interested in bulk orders? Contact us directly to discuss your requirements and be the first to know when our bulk ordering system goes live!
                </p>

                <div class="contact-buttons">
                    <a href="https://wa.me/923115904288" class="contact-btn whatsapp">
                        <i class="fab fa-whatsapp"></i>
                        WhatsApp: +92 311 5904288
                    </a>
                    <a href="mailto:info@taysan.co" class="contact-btn email">
                        <i class="fas fa-envelope"></i>
                        Email: info@taysan.co
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Floating Cart Button -->
<button class="ts-floating-cart-btn" onclick="window.location.href='/shop'">
    <i class="fas fa-shopping-cart"></i>
    <span class="ts-cart-count" id="floating-cart-count">0</span>
</button>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@endsection
