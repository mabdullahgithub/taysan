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
        --primary-dark: #6B4E84;
        --text-dark: #2c3e50;
        --text-light: #64748b;
        --bg-light: #f8fafc;
        --white: #ffffff;
        --shadow: 0 4px 20px rgba(0,0,0,0.08);
        --shadow-lg: 0 10px 40px rgba(0,0,0,0.1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* About Banner Styles */
    .about-page-banner {
        position: relative;
        padding: 120px 0 80px;
        background-color: #f5f5f5;
        margin-top: 130px;
        z-index: 1;
        min-height: 300px;
        display: flex;
        align-items: center;
    }

    .about-banner-content {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        padding: 0 15px;
        position: relative;
        z-index: 2;
    }

    .about-banner-title {
        font-size: 48px;
        color: #fff;
        margin-bottom: 15px;
        font-weight: 700;
        text-transform: capitalize;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .about-banner-breadcrumb {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .about-banner-breadcrumb li {
        color: #fff;
        font-size: 16px;
        position: relative;
    }

    .about-banner-breadcrumb li a {
        color: #fff;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .about-banner-breadcrumb li a:hover {
        text-decoration: underline;
    }

    .about-banner-breadcrumb li:not(:last-child)::after {
        content: "/";
        margin-left: 10px;
        color: #fff;
    }

    /* Main Content */
    .content {
        padding: 60px 0;
        background: var(--bg-light);
    }

    .section {
        margin-bottom: 60px;
    }

    .section-title {
        text-align: center;
        margin-bottom: 40px;
    }

    .section-title h2 {
        font-size: 2.2rem;
        color: var(--text-dark);
        margin-bottom: 0.8rem;
        font-weight: 700;
        position: relative;
    }

    .section-title h2::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: 2px;
    }

    .section-title p {
        font-size: 1rem;
        color: var(--text-light);
        max-width: 500px;
        margin: 20px auto 0;
        line-height: 1.6;
    }

    /* About Text */
    .about-text {
        max-width: 700px;
        margin: 0 auto;
        text-align: center;
        font-size: 1rem;
        line-height: 1.7;
        color: var(--text-light);
        /* background: var(--white); */
        padding: 40px;
        border-radius: 15px;
        /* box-shadow: var(--shadow); */
    }

    /* Features Grid */
    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-top: 40px;
    }

    .feature {
        background: var(--white);
        padding: 35px 25px;
        border-radius: 15px;
        text-align: center;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .feature:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-light);
    }

    .feature-icon {
        width: 65px;
        height: 65px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: var(--white);
        font-size: 22px;
        transition: transform 0.3s ease;
    }

    .feature:hover .feature-icon {
        transform: scale(1.1);
    }

    .feature h3 {
        font-size: 1.2rem;
        color: var(--text-dark);
        margin-bottom: 12px;
        font-weight: 600;
    }

    .feature p {
        color: var(--text-light);
        line-height: 1.5;
        font-size: 0.9rem;
    }

    /* Achievement Cards */
    .achievements {
        background: var(--white);
        padding: 50px 30px;
        border-radius: 20px;
        box-shadow: var(--shadow-lg);
        margin: 40px 0;
    }

    .achievements-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .achievement-card {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        padding: 30px 20px;
        border-radius: 15px;
        text-align: center;
        color: var(--white);
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .achievement-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transition: transform 0.3s ease;
    }

    .achievement-card:hover {
        transform: translateY(-5px);
    }

    .achievement-card:hover::before {
        transform: scale(1.2);
    }

    .achievement-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 8px;
        position: relative;
        z-index: 2;
    }

    .achievement-label {
        font-size: 0.95rem;
        opacity: 0.95;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        z-index: 2;
    }

    /* CTA */
    .cta {
        /* background: var(--white); */
        padding: 50px 30px;
        border-radius: 20px;
        text-align: center;
        /* box-shadow: var(--shadow-lg); */
        /* border: 2px solid var(--primary-light); */
    }

    .cta h2 {
        font-size: 2rem;
        color: var(--text-dark);
        margin-bottom: 15px;
        font-weight: 700;
    }

    .cta p {
        font-size: 1rem;
        color: var(--text-light);
        margin-bottom: 25px;
        max-width: 450px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .btn {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: var(--white);
        padding: 15px 35px;
        border: none;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(141, 104, 173, 0.3);
    }

    .btn:hover {
        transform: translateY(-3px);
        color: var(--white);
        text-decoration: none;
        box-shadow: 0 8px 25px rgba(141, 104, 173, 0.4);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .about-page-banner {
            padding: 80px 0 60px;
            margin-top: 0px; /* Remove margin since navbar already has padding-top */
            min-height: 250px;
        }
        
        .about-banner-title {
            font-size: 36px;
        }
        
        .about-banner-breadcrumb {
            font-size: 14px;
        }
        
        .content {
            padding: 40px 0;
        }
        
        .section {
            margin-bottom: 40px;
        }
        
        .section-title h2 {
            font-size: 1.8rem;
        }
        
        .about-text {
            padding: 30px 20px;
        }
        
        .features {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .feature {
            padding: 25px 15px;
        }
        
        .achievements {
            padding: 40px 20px;
        }
        
        .achievements-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .achievement-number {
            font-size: 2rem;
        }
        
        .achievement-label {
            font-size: 0.85rem;
        }
        
        .cta {
            padding: 40px 20px;
        }
        
        .cta h2 {
            font-size: 1.7rem;
        }
    }

    @media (max-width: 480px) {
        .about-banner-title {
            font-size: 28px;
        }
        
        .about-banner-breadcrumb {
            font-size: 12px;
        }
        
        .section-title h2 {
            font-size: 1.5rem;
        }
        
        .achievements-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .feature-icon {
            width: 55px;
            height: 55px;
            font-size: 18px;
        }
        
        .achievement-number {
            font-size: 1.6rem;
        }

        .achievement-label {
            font-size: 0.8rem;
        }

        .achievement-card {
            padding: 20px 15px;
        }

        /* Features mobile adjustments */
        .features {
            gap: 10px;
        }

        .feature {
            padding: 20px 12px;
        }

        .feature h3 {
            font-size: 1rem;
        }

        .feature p {
            font-size: 0.85rem;
        }
    }

    /* Extra small screens */
    @media (max-width: 320px) {
        .achievements-grid {
            gap: 10px;
        }

        .achievement-card {
            padding: 15px 10px;
        }

        .achievement-number {
            font-size: 1.4rem;
        }

        .achievement-label {
            font-size: 0.75rem;
        }

        .features {
            gap: 8px;
        }

        .feature {
            padding: 15px 8px;
        }

        .feature h3 {
            font-size: 0.9rem;
        }

        .feature p {
            font-size: 0.8rem;
        }

        .feature-icon {
            width: 45px;
            height: 45px;
            font-size: 16px;
        }
    }

    /* Founder Profile Styles */
    .about-content-wrapper {
        margin-top: 2rem;
    }

    .founder-profile {
        padding: 1.5rem;
        background: rgba(141, 104, 173, 0.05);
        border-radius: 15px;
        margin-top: 1rem;
    }

    .founder-image-small:hover {
        transform: scale(1.05);
        transition: all 0.3s ease;
    }

    .btn-contact-small:hover {
        background: #20B954 !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
        color: white !important;
        text-decoration: none;
    }

    .founder-mission {
        position: relative;
    }

    .founder-mission::before {
        content: '';
        left: -4px;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(135deg, #8D68AD, #A67BC9);
        border-radius: 2px;
    }

    /* Mobile responsive styles for founder profile */
    @media (max-width: 991px) {
        .founder-profile {
            margin-top: 2rem;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .founder-profile h4 {
            font-size: 1.2rem;
        }

        .btn-contact-small {
            font-size: 0.8rem !important;
            padding: 0.4rem 0.8rem !important;
        }
    }

    /* WhatsApp Button Hover */
    .btn-whatsapp:hover {
        background: #20B954 !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
        color: white !important;
        text-decoration: none;
    }

    /* Animation for numbers */
    @keyframes countUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .achievement-card.animate .achievement-number {
        animation: countUp 0.6s ease-out;
    }
</style>

<!-- About Banner -->
@if(isset($aboutBanner) && $aboutBanner->image)
<section class="about-page-banner" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('storage/'.$aboutBanner->image) }}') no-repeat center center/cover;">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="about-banner-content">
                    <h2 class="about-banner-title">{{ $aboutBanner->title ?? 'About Us' }}</h2>
                    <ol class="about-banner-breadcrumb">
                        <li><a href="{{ url('/') }}">{{ $aboutBanner->subtitle ?? 'Home' }}</a></li>
                        <li>About</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
@else
<section class="about-page-banner" style="background: linear-gradient(135deg, var(--primary), var(--primary-light));">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="about-banner-content">
                    <h2 class="about-banner-title">About Us</h2>
                    <ol class="about-banner-breadcrumb">
                        <li><a href="/">Home</a></li>
                        <li>About</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Main Content -->
<section class="content">
    <div class="container">
        
        <!-- About Introduction -->
        <div class="section">
            <div class="section-title">
                <h2>Welcome to Taysan Beauty</h2>
                <p>Natural skincare crafted with passion and dedication</p>
            </div>
            <div class="about-content-wrapper">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="about-text">
                            @php
                                $founderName = \App\Models\Setting::get('footer_founder_name', 'Muhammad Abdullah');
                            @endphp
                            <p>Founded with passion and dedication by <strong style="color: #8D68AD;">{{ $founderName }}</strong>, Taysan Beauty represents the perfect blend of natural ingredients and sustainable practices. We create handcrafted soaps and skincare products that don't compromise on quality while respecting our planet and communities.</p>
                            
                            <p>Each product is lovingly crafted using traditional methods combined with modern quality standards. From our premium handmade soaps to our organic skincare line, every item reflects our commitment to natural beauty and environmental responsibility.</p>
                            
                            <div class="founder-mission" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 1.5rem; border-radius: 10px; margin: 1.5rem 0; border-left: 4px solid #8D68AD;">
                                <p style="margin: 0; font-style: italic; color: #666;">
                                    <i class="fas fa-quote-left" style="color: #8D68AD; margin-right: 10px;"></i>
                                    "Our mission is to provide natural, eco-friendly beauty products that not only make you look beautiful but also make you feel good about your choices for the environment."
                                    <br><span style="font-size: 0.9rem; color: #8D68AD; font-weight: 600;">- {{ $founderName }}, Founder</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="founder-profile text-center">
                            <div class="founder-image-small" style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #8D68AD, #A67BC9); margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(141, 104, 173, 0.3); position: relative;">
                                @php
                                    $ceoImage = \App\Models\Setting::get('ceo_image');
                                    $founderName = \App\Models\Setting::get('footer_founder_name', 'Muhammad Abdullah');
                                    $founderTitle = \App\Models\Setting::get('footer_founder_title', 'Founder & CEO');
                                @endphp
                                @if($ceoImage)
                                    <img src="{{ asset('storage/' . $ceoImage) }}" alt="{{ $founderName }} - {{ $founderTitle }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                @else
                                    <i class="fas fa-user" style="font-size: 3rem; color: white; opacity: 0.9;"></i>
                                @endif
                                <!-- Crown Icon - Always visible with higher z-index -->
                                <div style="position: absolute; top: -8px; right: -8px; width: 35px; height: 35px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 3px 10px rgba(0,0,0,0.1); z-index: 10;">
                                    <i class="fas fa-crown" style="color: #8D68AD; font-size: 0.9rem;"></i>
                                </div>
                            </div>
                            <h4 style="color: #8D68AD; margin-bottom: 0.5rem;">{{ $founderName }}</h4>
                            <p style="font-size: 0.9rem; color: #666; margin-bottom: 1rem;">{{ $founderTitle }}</p>
                            <a href="https://wa.me/923115904288" class="btn-contact-small" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: #25D366; color: white; text-decoration: none; border-radius: 20px; font-size: 0.85rem; font-weight: 500; transition: all 0.3s ease;">
                                <i class="fab fa-whatsapp"></i>
                                Contact via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Story -->
        {{-- <div class="section">
            <div class="section-title">
                <h2>Our Story</h2>
            </div>
            <div class="about-text">
                <p>What started as a small dream has grown into a beloved brand trusted by customers worldwide. We began with a simple mission: to create beautiful, sustainable fashion that makes everyone feel confident and comfortable. Every piece is carefully crafted with attention to detail, using ethically sourced materials and responsible production methods.</p>
            </div>
        </div> --}}

        <!-- Why Choose Us -->
        <div class="section">
            <div class="section-title">
                <h2>Why Choose Taysan Beauty</h2>
                <p>What makes our natural skincare products special</p>
            </div>
            
            <div class="features">
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>100% Natural</h3>
                    <p>Pure organic ingredients sourced responsibly for healthy, glowing skin</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-hand-sparkles"></i>
                    </div>
                    <h3>Handcrafted Quality</h3>
                    <p>Every soap and skincare product is lovingly handmade with attention to detail</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <h3>Eco-Friendly</h3>
                    <p>Sustainable packaging and environmentally conscious production methods</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Skin Loving</h3>
                    <p>Gentle formulas that nourish and pamper all skin types naturally</p>
                </div>
            </div>
        </div>

        <!-- Our Achievements -->
        <div class="section">
            <div class="achievements">
                <div class="section-title">
                    <h2>Our Achievements</h2>
                    <p>Numbers that reflect our commitment to excellence</p>
                </div>
                
                <div class="achievements-grid">
                    <div class="achievement-card">
                        <div class="achievement-number" data-count="10000">0</div>
                        <div class="achievement-label">Happy Customers</div>
                    </div>
                    
                    <div class="achievement-card">
                        <div class="achievement-number" data-count="500">0</div>
                        <div class="achievement-label">Products</div>
                    </div>
                    
                    <div class="achievement-card">
                        <div class="achievement-number" data-count="50">0</div>
                        <div class="achievement-label">Countries</div>
                    </div>
                    
                    <div class="achievement-card">
                        <div class="achievement-number" data-count="9">0</div>
                        <div class="achievement-label">Years Experience</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ready to Experience -->
        <div class="section">
            <div class="cta">
                <h2>Ready to Experience Taysan Beauty?</h2>
                <p>Join thousands of satisfied customers who have made us their go-to destination for natural skincare and handmade soaps</p>
                <a href="{{ route('web.view.shop') }}" class="btn">Explore Our Products</a>
            </div>
        </div>

    </div>
</section>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation function
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-count'));
        const increment = target / 100;
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target.toLocaleString() + (target >= 1000 ? '+' : '');
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString();
            }
        }, 20);
    }

    // Intersection Observer for counter animation
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const card = entry.target;
                const numberElement = card.querySelector('.achievement-number');
                
                card.classList.add('animate');
                animateCounter(numberElement);
                observer.unobserve(card);
            }
        });
    }, observerOptions);

    // Observe all achievement cards
    document.querySelectorAll('.achievement-card').forEach(card => {
        observer.observe(card);
    });

    // Feature cards animation
    const featureObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.feature, .about-text').forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(30px)';
        item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        featureObserver.observe(item);
    });
});
</script>

@endsection