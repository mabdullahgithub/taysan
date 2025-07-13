@extends('web.layout.app')
@section('content')

<style>
    /* Reset and Variables */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary: #8D68AD;
        --primary-light: #A67BC9;
        --text-primary: #1d1d1f;
        --text-secondary: #6e6e73;
        --text-tertiary: #86868b;
        --background-light: #f5f5f7;
        --white: #ffffff;
        --shadow-light: 0 2px 10px rgba(0, 0, 0, 0.05);
        --shadow-medium: 0 4px 20px rgba(0, 0, 0, 0.08);
        --border-light: rgba(0, 0, 0, 0.08);
    }

    /* Typography - Apple Style */
    .hero-section {
        background: linear-gradient(135deg, #f5f5f7 0%, #ffffff 100%);
        padding: 140px 0 80px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .hero-title {
        font-size: 42px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 15px;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }

    .hero-subtitle {
        font-size: 20px;
        font-weight: 400;
        color: var(--text-secondary);
        margin-bottom: 30px;
        line-height: 1.3;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-description {
        font-size: 15px;
        color: var(--text-tertiary);
        line-height: 1.6;
        max-width: 600px;
        margin: 0 auto 40px;
    }

    /* Content Sections */
    .content-section {
        padding: 60px 0;
        position: relative;
    }

    .section-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .section-title {
        font-size: 34px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 15px;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }

    .section-subtitle {
        font-size: 16px;
        color: var(--text-secondary);
        line-height: 1.4;
        max-width: 700px;
        margin: 0 auto;
    }

    /* AI Doctor Platform Section */
    .ai-platform-section {
        background: var(--white);
        position: relative;
    }

    .platform-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        margin-bottom: 60px;
    }

    .platform-content h3 {
        font-size: 24px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .platform-content p {
        font-size: 15px;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .platform-visual {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .ai-icon-container {
        width: 180px;
        height: 180px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        box-shadow: 0 20px 60px rgba(141, 104, 173, 0.25);
        animation: float 6s ease-in-out infinite;
    }

    .ai-icon-container i {
        font-size: 70px;
        color: white;
    }

    /* Floating animation */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    /* Features Grid */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .feature-card {
        background: var(--white);
        padding: 30px 25px;
        border-radius: 20px;
        text-align: center;
        border: 1px solid var(--border-light);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-light));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .feature-card:hover::before {
        transform: scaleX(1);
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-medium);
    }

    .feature-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 20px;
        color: white;
        transition: transform 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1);
    }

    .feature-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 12px;
    }

    .feature-description {
        font-size: 14px;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    /* Story Section */
    .story-section {
        background: var(--background-light);
    }

    .story-content {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
    }

    .story-text {
        font-size: 16px;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 30px;
    }

    /* Founder Section */
    .founder-section {
        display: flex;
        align-items: center;
        gap: 40px;
        margin-top: 40px;
        padding: 30px;
        background: var(--white);
        border-radius: 20px;
        box-shadow: var(--shadow-light);
        border: 1px solid var(--border-light);
    }

    .founder-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--primary);
        box-shadow: 0 8px 25px rgba(141, 104, 173, 0.2);
        flex-shrink: 0;
        aspect-ratio: 1/1;
    }

    .founder-content h4 {
        font-size: 20px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 8px;
    }

    .founder-content .founder-title {
        font-size: 14px;
        color: var(--primary);
        font-weight: 500;
        margin-bottom: 12px;
    }

    .founder-content p {
        font-size: 14px;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    /* Innovation Timeline */
    .innovation-section {
        background: var(--white);
    }

    .timeline {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 30px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, var(--primary), var(--primary-light));
        transform: translateX(-50%);
    }

    .timeline-item {
        display: flex;
        align-items: center;
        margin-bottom: 60px;
        position: relative;
        min-height: 100px;
    }

    .timeline-content {
        flex: 1;
        padding: 25px;
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow-light);
        border: 1px solid var(--border-light);
        margin: 0 0 0 70px;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .timeline-content:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-medium);
    }

    .timeline-year {
        font-size: 14px;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 8px;
    }

    .timeline-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 8px;
    }

    .timeline-description {
        font-size: 14px;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    .timeline-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        left: 30px;
        transform: translateX(-50%);
        z-index: 10;
        box-shadow: 0 4px 20px rgba(141, 104, 173, 0.3);
        border: 4px solid var(--white);
    }

    .timeline-icon i {
        color: white;
        font-size: 20px;
    }

    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        text-align: center;
        padding: 60px 0;
    }

    .cta-title {
        font-size: 30px;
        font-weight: 600;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .cta-description {
        font-size: 16px;
        margin-bottom: 30px;
        opacity: 0.9;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .cta-button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: white;
        color: var(--primary);
        padding: 16px 32px;
        border-radius: 50px;
        text-decoration: none;
        font-size: 17px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .cta-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        color: var(--primary);
        text-decoration: none;
    }

    /* Responsive Design */
    @media (min-width: 1025px) {
        /* Large screens optimization */
        .hero-title {
            font-size: 48px;
        }
        
        .hero-subtitle {
            font-size: 22px;
        }
        
        .hero-description {
            font-size: 17px;
        }
        
        .section-title {
            font-size: 38px;
        }
        
        .section-subtitle {
            font-size: 18px;
        }
        
        .platform-content h3 {
            font-size: 26px;
        }
        
        .platform-content p {
            font-size: 16px;
        }
        
        .feature-title {
            font-size: 20px;
        }
        
        .feature-description {
            font-size: 15px;
        }
        
        .timeline-item {
            margin-bottom: 80px;
        }
        
        .timeline-content {
            padding: 30px;
            margin: 0 0 0 80px;
        }
        
        .founder-content h4 {
            font-size: 22px;
        }
        
        .founder-content p {
            font-size: 15px;
        }
    }

    @media (max-width: 1024px) {
        .hero-section {
            padding: 120px 0 70px;
        }
        
        .platform-grid {
            gap: 60px;
        }
        
        .ai-icon-container {
            width: 160px;
            height: 160px;
        }
        
        .ai-icon-container i {
            font-size: 60px;
        }
        
        .timeline-item {
            margin-bottom: 50px;
        }
        
        .timeline-content {
            margin: 0 0 0 70px;
        }
        
        .timeline-icon {
            width: 55px;
            height: 55px;
            left: 30px;
        }
        
        .timeline-icon i {
            font-size: 18px;
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 80px 0 40px;
        }
        
        .hero-title {
            font-size: 28px;
        }
        
        .hero-subtitle {
            font-size: 18px;
        }
        
        .hero-description {
            font-size: 14px;
        }
        
        .content-section {
            padding: 40px 0;
        }
        
        .section-title {
            font-size: 26px;
        }
        
        .section-subtitle {
            font-size: 15px;
        }
        
        .platform-grid {
            grid-template-columns: 1fr;
            gap: 30px;
            text-align: center;
        }
        
        /* AI Doctor image on top and centered for mobile */
        .platform-visual {

            order: -1;
            width: 100%;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin: 0 auto !important;
        }
        
        .ai-icon-container {
            margin: 0 auto;
        }
        
        .platform-content h3 {
            font-size: 20px;
        }
        
        .platform-content p {
            font-size: 14px;
        }
        
        .features-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .founder-section {
            flex-direction: column;
            text-align: center;
            gap: 25px;
            padding: 25px;
        }
        
        .founder-image {
            width: 100px;
            height: 100px;
        }
        
        .timeline::before {
            left: 20px;
        }
        
        .timeline-item {
            flex-direction: row !important;
            margin-bottom: 30px;
        }
        
        .timeline-content {
            margin: 0 0 0 50px;
            padding: 20px;
        }
        
        .timeline-icon {
            left: 20px;
            transform: translateX(-50%);
            width: 45px;
            height: 45px;
        }
        
        .timeline-icon i {
            font-size: 16px;
        }
        
        .cta-title {
            font-size: 24px;
        }
        
        .cta-description {
            font-size: 15px;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 24px;
        }
        
        .hero-subtitle {
            font-size: 16px;
        }
        
        .hero-description {
            font-size: 13px;
        }
        
        .section-title {
            font-size: 22px;
        }
        
        .section-subtitle {
            font-size: 14px;
        }
        
        .ai-icon-container {
            width: 100px;
            height: 100px;
        }
        
        .ai-icon-container i {
            font-size: 35px;
        }
        
        .feature-card {
            padding: 25px 15px;
        }
        
        .feature-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
        
        .founder-section {
            padding: 20px;
            gap: 20px;
        }
        
        .founder-image {
            width: 80px;
            height: 80px;
        }
        
        .founder-content h4 {
            font-size: 18px;
        }
        
        .timeline-content {
            padding: 15px;
            margin: 0 0 0 40px;
        }
        
        .timeline-icon {
            width: 35px;
            height: 35px;
            border: 2px solid var(--white);
        }
        
        .timeline-icon i {
            font-size: 14px;
        }
        
        .cta-title {
            font-size: 20px;
        }
        
        .cta-description {
            font-size: 14px;
        }
        
        .cta-button {
            padding: 12px 24px;
            font-size: 15px;
        }
    }

    /* Additional animations */
    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }

    .fade-in-up.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Pulse animation for AI doctor badge */
    .ai-badge {
        position: absolute;
        top: -10px;
        right: -10px;
        background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        animation: pulse 2s infinite;
        box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="fade-in-up">
            <h1 class="hero-title">Pakistan's First AI-Powered<br>Skincare Platform</h1>
            <p class="hero-subtitle">Revolutionizing beauty with intelligent skin analysis and personalized care</p>
            <p class="hero-description">
                Experience the future of skincare with our AI doctor that understands your skin better than anyone. 
                Get instant consultations, personalized recommendations, and professional guidance—all at your fingertips.
            </p>
        </div>
    </div>
</section>

<!-- AI Platform Section -->
<section class="content-section ai-platform-section">
    <div class="container">
        <div class="section-header fade-in-up">
            <h2 class="section-title">Meet Your AI Skincare Doctor</h2>
            <p class="section-subtitle">
                Our revolutionary AI technology provides instant, professional skincare consultations 24/7. 
                No more waiting for appointments or expensive visits—get expert advice whenever you need it.
            </p>
        </div>
        
        <div class="platform-grid">
            <div class="platform-content fade-in-up">
                <h3>Intelligent Skin Analysis</h3>
                <p>Our AI doctor uses advanced machine learning algorithms to analyze your skin concerns, understand your specific needs, and provide personalized treatment recommendations.</p>
                
                <h3 style="margin-top: 30px;">Instant Professional Guidance</h3>
                <p>Get immediate answers to all your skincare questions. Our AI understands dermatology, ingredient science, and product compatibility to give you expert-level advice.</p>
                
                <h3 style="margin-top: 30px;">Personalized Product Matching</h3>
                <p>Based on your skin analysis and concerns, receive tailored product recommendations from our curated collection of natural, handcrafted skincare solutions.</p>
            </div>

            <div class="platform-visual fade-in-up">
                <div class="ai-icon-container">
                    <i class="fas fa-user-md"></i>
                    <div class="ai-badge">AI Doctor</div>
                </div>
            </div>
        </div>
        
        <!-- Features Grid -->
        <div class="features-grid">
            <div class="feature-card fade-in-up">
                <div class="feature-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <h3 class="feature-title">Advanced AI Technology</h3>
                <p class="feature-description">Powered by cutting-edge machine learning trained on thousands of skin conditions and treatments</p>
            </div>
            
            <div class="feature-card fade-in-up">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 class="feature-title">24/7 Availability</h3>
                <p class="feature-description">Access professional skincare consultations anytime, anywhere—no appointments needed</p>
            </div>
            
            <div class="feature-card fade-in-up">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="feature-title">Privacy Protected</h3>
                <p class="feature-description">Your consultations are completely private and secure with end-to-end encryption</p>
            </div>
            
            <div class="feature-card fade-in-up">
                <div class="feature-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3 class="feature-title">Natural Solutions</h3>
                <p class="feature-description">Recommendations focus on natural, organic ingredients that are gentle yet effective</p>
            </div>
            
            <div class="feature-card fade-in-up">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">Progress Tracking</h3>
                <p class="feature-description">Monitor your skin improvement journey with intelligent progress analysis</p>
            </div>
            
            <div class="feature-card fade-in-up">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="feature-title">Community Support</h3>
                <p class="feature-description">Connect with others on similar skincare journeys while maintaining your privacy</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="content-section story-section">
    <div class="container">
        <div class="section-header fade-in-up">
            <h2 class="section-title">Our Story</h2>
            <p class="section-subtitle">From a passionate vision to Pakistan's most innovative beauty platform</p>
        </div>
        
        <div class="story-content fade-in-up">
            @php
                $founderName = \App\Models\Setting::get('footer_founder_name', 'Muhammad Abdullah');
            @endphp
            <p class="story-text">
                Founded by <strong style="color: var(--primary);">{{ $founderName }}</strong>, Taysan Beauty began with a simple yet powerful vision: 
                to make professional skincare guidance accessible to everyone in Pakistan. Recognizing the challenges people face in 
                getting expert dermatological advice—long waiting times, expensive consultations, and limited availability—we set out 
                to revolutionize the industry.
            </p>
            
            <p class="story-text">
                Combining our passion for natural beauty with cutting-edge artificial intelligence, we created Pakistan's first 
                AI-powered skincare platform. Our AI doctor doesn't just recommend products; it understands your unique skin journey, 
                learns from your experiences, and provides personalized care that evolves with your needs.
            </p>
            
            <p class="story-text">
                Today, we're proud to serve thousands of customers across Pakistan, offering both innovative technology and 
                premium handcrafted skincare products. Our mission remains the same: to democratize beauty expertise and 
                make professional skincare guidance available to everyone, everywhere.
            </p>
            
            <!-- Founder Section -->
            <div class="founder-section fade-in-up">
                @php
                    // Get founder image from admin settings (CEO Image Settings)
                    $founderImage = \App\Models\Setting::get('ceo_image', '');
                @endphp
                @if($founderImage && file_exists(public_path('storage/' . $founderImage)))
                    <img src="{{ asset('storage/' . $founderImage) }}" alt="{{ $founderName }}" class="founder-image">
                @elseif($founderImage && filter_var($founderImage, FILTER_VALIDATE_URL))
                    <img src="{{ $founderImage }}" alt="{{ $founderName }}" class="founder-image">
                @else
                    {{-- Fallback: Show founder initials if no image is uploaded --}}
                    <div class="founder-image" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: 600;">
                        {{ substr($founderName, 0, 2) }}
                    </div>
                @endif
                <div class="founder-content">
                    <h4>{{ $founderName }}</h4>
                    <div class="founder-title">Founder & CEO</div>
                    <p>"Our vision is to revolutionize skincare in Pakistan by combining traditional beauty wisdom with cutting-edge AI technology, making expert dermatological guidance accessible to everyone."</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Innovation Timeline -->
<section class="content-section innovation-section">
    <div class="container">
        <div class="section-header fade-in-up">
            <h2 class="section-title">Our Innovation Journey</h2>
            <p class="section-subtitle">Milestones in revolutionizing Pakistan's beauty industry</p>
        </div>
        
        <div class="timeline">
            <div class="timeline-item fade-in-up">
                <div class="timeline-content">
                    <div class="timeline-year">2023</div>
                    <h3 class="timeline-title">The Beginning</h3>
                    <p class="timeline-description">Started with handcrafted soaps and natural skincare products, establishing our foundation in quality and sustainability.</p>
                </div>
                <div class="timeline-icon">
                    <i class="fas fa-seedling"></i>
                </div>
            </div>
            
            <div class="timeline-item fade-in-up">
                <div class="timeline-content">
                    <div class="timeline-year">2024</div>
                    <h3 class="timeline-title">AI Development</h3>
                    <p class="timeline-description">Invested in artificial intelligence research and development, partnering with dermatology experts to train our AI doctor.</p>
                </div>
                <div class="timeline-icon">
                    <i class="fas fa-brain"></i>
                </div>
            </div>
            
            <div class="timeline-item fade-in-up">
                <div class="timeline-content">
                    <div class="timeline-year">2024</div>
                    <h3 class="timeline-title">Platform Launch</h3>
                    <p class="timeline-description">Launched Pakistan's first AI-powered skincare consultation platform, making professional guidance accessible to all.</p>
                </div>
                <div class="timeline-icon">
                    <i class="fas fa-rocket"></i>
                </div>
            </div>
            
            <div class="timeline-item fade-in-up">
                <div class="timeline-content">
                    <div class="timeline-year">2025</div>
                    <h3 class="timeline-title">Market Leadership</h3>
                    <p class="timeline-description">Became Pakistan's leading AI-powered beauty platform, serving thousands of satisfied customers nationwide.</p>
                </div>
                <div class="timeline-icon">
                    <i class="fas fa-crown"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="fade-in-up">
            <h2 class="cta-title">Experience the Future of Skincare</h2>
            <p class="cta-description">
                Join thousands of satisfied customers who trust our AI doctor for their skincare needs. 
                Start your personalized beauty journey today.
            </p>
            <a href="/chatbot" class="cta-button">
                <i class="fas fa-comments"></i>
                Chat with AI Doctor
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all fade-in elements
    document.querySelectorAll('.fade-in-up').forEach(item => {
        observer.observe(item);
    });

    // Add some delay to timeline items for staggered animation
    document.querySelectorAll('.timeline-item').forEach((item, index) => {
        item.style.transitionDelay = `${index * 0.1}s`;
    });

    // Add delay to feature cards
    document.querySelectorAll('.feature-card').forEach((card, index) => {
        card.style.transitionDelay = `${index * 0.1}s`;
    });
});
</script>

@endsection