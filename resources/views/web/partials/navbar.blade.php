<!-- Main Header -->
<header class="ts-header">
    <!-- Announcement Bar -->
    <div class="ts-announce">
        <div style="" class="container-fluid">
            <div class="marquee-content">
                @php
                    $marqueeText = \App\Models\Setting::get('marquee_text', 'Welcome to our store!');
                @endphp
                {{ $marqueeText }}
            </div>
        </div>
    </div>
    
    <!-- Main Navigation -->
    <nav class="ts-navbar">
        <div class="container-fluid">
            <div class="ts-navbar__wrapper">
                <!-- Mobile Menu Toggle -->
                <div class="ts-navbar__mobile d-lg-none">
                    <button class="ts-menu-toggle" type="button" aria-label="Toggle menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>

                <!-- Brand Logo -->
                <div class="ts-navbar__brand">
                    <a href="{{ url('/') }}" class="ts-logo">
                        @php
                            $logo = \App\Models\Setting::get('logo');
                            $logoUrl = $logo ? asset('storage/' . $logo) : asset('logo.png');
                        @endphp
                        <img src="{{ $logoUrl }}" alt="Glowzel Beauty" class="ts-logo__img">
                    </a>
                </div>

                <!-- Navigation Menu -->
                <div class="ts-navbar__menu" id="tsMainMenu">
                    <!-- Close Button for Mobile -->
                    <button class="ts-menu-close d-lg-none">
                        <i class="fas fa-times"></i>
                    </button>                <!-- Navigation Links -->
                <ul class="ts-menu">
                    <li class="ts-menu__item {{ Request::is('/') ? 'active' : '' }}">
                        <a href="{{ route('web.view.index') }}" class="ts-menu__link">Home</a>
                    </li>
                    <li class="ts-menu__item {{ Request::is('shop*') ? 'active' : '' }}">
                        <a href="{{ route('web.view.shop') }}" class="ts-menu__link">Shop</a>
                    </li>
                    <li class="ts-menu__item {{ Request::is('about') ? 'active' : '' }}">
                        <a href="{{ route('web.view.about') }}" class="ts-menu__link">About</a>
                    </li>
                    <li class="ts-menu__item {{ Request::is('contact') ? 'active' : '' }}">
                        <a href="{{ route('web.view.contact') }}" class="ts-menu__link">Contact</a>
                    </li>
                </ul>
            </div>

            <!-- User Actions & Cart -->
            <div class="ts-navbar__actions">
                @auth
                    <!-- User Menu for Authenticated Users -->
                    <div class="ts-user-menu">
                        <button class="ts-user-toggle" type="button">
                            @if(auth()->user()->avatar)
                                <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="ts-user-avatar">
                            @else
                                <div class="ts-user-initial">{{ auth()->user()->initials }}</div>
                            @endif
                            <span class="ts-user-name d-none d-md-inline">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down ts-user-chevron"></i>
                        </button>
                        
                        <!-- User Dropdown Menu -->
                        <div class="ts-user-dropdown">
                            <div class="ts-user-info">
                                <div class="ts-user-avatar-large">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                                    @else
                                        <div class="ts-user-initial-large">{{ auth()->user()->initials }}</div>
                                    @endif
                                </div>
                                <div class="ts-user-details">
                                    <h6>{{ auth()->user()->name }}</h6>
                                    <p>{{ auth()->user()->email }}</p>
                                </div>
                            </div>

                            @if(auth()->user() && !auth()->user()->hasVerifiedEmail())
                                <!-- Email Verification Notice -->
                                <div class="ts-verification-notice">
                                    <div class="ts-verification-content">
                                        <div class="ts-verification-icon">
                                            <i class="fas fa-envelope-open-text"></i>
                                        </div>
                                        <div class="ts-verification-text">
                                            <strong>Verify Your Email</strong>
                                            <p>Please check your email and click the verification link.</p>
                                            <div class="ts-verification-timer" id="verificationTimer">
                                                <span class="timer-text">Link expires in: </span>
                                                <span class="timer-countdown" id="countdown">--:--</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ts-verification-actions">
                                        <form method="POST" action="{{ route('verification.send') }}" class="ts-resend-form" style="display: none;" id="resendForm">
                                            @csrf
                                            <button type="submit" class="ts-resend-btn">
                                                <i class="fas fa-paper-plane"></i>
                                                Resend Email
                                            </button>
                                        </form>
                                        <a href="{{ route('verification.notice') }}" class="ts-verification-link">
                                            <i class="fas fa-external-link-alt"></i>
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="ts-user-links">
                                <a href="{{ route('web.user.profile') }}" class="ts-user-link">
                                    <i class="fas fa-user"></i>
                                    <span>My Profile</span>
                                </a>
                                <a href="{{ route('web.user.orders') }}" class="ts-user-link">
                                    <i class="fas fa-shopping-bag"></i>
                                    <span>My Orders</span>
                                </a>
                                <a href="{{ route('web.user.reviews') }}" class="ts-user-link">
                                    <i class="fas fa-star"></i>
                                    <span>My Reviews</span>
                                </a>
                                <div class="ts-user-divider"></div>
                                <form action="{{ route('web.user.logout') }}" method="POST" class="ts-logout-form">
                                    @csrf
                                    <button type="submit" class="ts-user-link ts-logout-btn">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Auth Buttons for Guests -->
                    <div class="ts-auth-buttons">
                        <a href="{{ route('web.user.login.form') }}" class="ts-btn ts-btn--ghost ts-btn--mobile-small">
                            <i class="fas fa-sign-in-alt d-none d-md-inline"></i>
                            <span>Sign In</span>
                        </a>
                        <a href="{{ route('web.user.register.form') }}" class="ts-btn ts-btn--primary d-none d-sm-inline-flex">
                            <i class="fas fa-user-plus"></i>
                            <span class="d-none d-sm-inline">Become Member</span>
                        </a>
                    </div>
                @endauth

                <!-- Cart Icon -->
                <div class="ts-navbar__cart">
                   
                </div>
            </div>
            </div>
        </div>
    </nav>
</header>

<style>
/* Core Variables */
:root {
    --ts-primary: #9977B5;
    --ts-dark: #333333;
    --ts-light: #FFFFFF;
    --ts-gray: #666666;
    --ts-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --ts-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

/* Header Base */
.ts-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1040;
    will-change: transform;
    transition: transform 0.3s ease;
}

.ts-header.hidden {
    transform: translateY(-100%);
}

/* Announcement Bar */
.ts-announce {
    background: var(--ts-dark);
    padding: 8px 0;
    text-align: center;
    overflow: hidden;
    white-space: nowrap;
}

.ts-announce__text {
    color: var(--ts-light);
    margin: 0;
    font-size: 14px;
    letter-spacing: 0.5px;
}

.marquee-content {
    display: inline-block;
    animation: marquee 30s linear infinite;
    font-size: 14px;
    font-weight: 500;
    color: var(--ts-light);
    letter-spacing: 0.5px;
    margin: 0;
}

@keyframes marquee {
    0% {
        transform: translate3d(100%, 0, 0);
    }
    100% {
        transform: translate3d(-100%, 0, 0);
    }
}

/* Main Navbar */
.ts-navbar {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    transition: var(--ts-transition);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.ts-navbar.scrolled {
    background: rgba(255, 255, 255, 0.98);
    box-shadow: var(--ts-shadow);
}

.ts-navbar__wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100px;
    position: relative;
}

/* Logo Styling */
.ts-logo {
    display: inline-block;
    padding: 0;
}

.ts-logo__img {
    height: 100px;
    width: auto;
    transition: var(--ts-transition);
}

/* Navigation Menu */
.ts-menu {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 20px;
}

.ts-menu__link {
    color: var(--ts-dark);
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    padding: 8px 16px;
    transition: var(--ts-transition);
    position: relative;
}

.ts-menu__link:hover,
.ts-menu__item.active .ts-menu__link {
    color: var(--ts-primary);
    text-decoration: none;
}

.ts-menu__link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: var(--ts-primary);
    transition: var(--ts-transition);
    transform: translateX(-50%);
}

.ts-menu__link:hover::after,
.ts-menu__item.active .ts-menu__link::after {
    width: 80%;
}

/* Navbar Actions */
.ts-navbar__actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

/* Auth Buttons */
.ts-auth-buttons {
    display: flex;
    align-items: center;
    gap: 10px;
}

.ts-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 25px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: var(--ts-transition);
    border: none;
    cursor: pointer;
    white-space: nowrap;
}

.ts-btn--ghost {
    background: transparent;
    color: var(--ts-dark);
    border: 1px solid transparent;
}

.ts-btn--ghost:hover {
    background: rgba(153, 119, 181, 0.1);
    color: var(--ts-primary);
    text-decoration: none;
    border-color: var(--ts-primary);
}

.ts-btn--primary {
    background: var(--ts-primary);
    color: var(--ts-light);
    border: 1px solid var(--ts-primary);
}

.ts-btn--primary:hover {
    background: #8365A0;
    color: var(--ts-light);
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(153, 119, 181, 0.3);
}

/* User Menu */
.ts-user-menu {
    position: relative;
}

.ts-user-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    background: none;
    border: none;
    padding: 6px 12px;
    border-radius: 25px;
    cursor: pointer;
    transition: var(--ts-transition);
    color: var(--ts-dark);
}

.ts-user-toggle:hover {
    background: rgba(153, 119, 181, 0.1);
    color: var(--ts-primary);
}

.ts-user-avatar,
.ts-user-initial {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.ts-user-initial {
    background: var(--ts-primary);
    color: var(--ts-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 600;
}

.ts-user-name {
    font-size: 14px;
    font-weight: 500;
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.ts-user-chevron {
    font-size: 12px;
    transition: var(--ts-transition);
}

.ts-user-menu.active .ts-user-chevron {
    transform: rotate(180deg);
}

/* User Dropdown */
.ts-user-dropdown {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    background: var(--ts-light);
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    min-width: 280px;
    z-index: 1050;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: var(--ts-transition);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.ts-user-menu.active .ts-user-dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.ts-user-info {
    padding: 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    gap: 12px;
}

.ts-user-avatar-large,
.ts-user-initial-large {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    overflow: hidden;
}

.ts-user-avatar-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.ts-user-initial-large {
    background: var(--ts-primary);
    color: var(--ts-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 600;
}

.ts-user-details h6 {
    margin: 0 0 4px 0;
    font-size: 16px;
    font-weight: 600;
    color: var(--ts-dark);
}

.ts-user-details p {
    margin: 0;
    font-size: 14px;
    color: var(--ts-gray);
}

.ts-user-links {
    padding: 10px 0;
}

.ts-user-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 20px;
    color: var(--ts-dark);
    text-decoration: none;
    transition: var(--ts-transition);
    font-size: 14px;
    width: 100%;
    border: none;
    background: none;
    cursor: pointer;
}

.ts-user-link:hover {
    background: rgba(153, 119, 181, 0.1);
    color: var(--ts-primary);
    text-decoration: none;
}

.ts-user-link i {
    width: 16px;
    text-align: center;
    font-size: 14px;
}

.ts-user-divider {
    height: 1px;
    background: rgba(0, 0, 0, 0.05);
    margin: 10px 0;
}

.ts-logout-form {
    margin: 0;
    width: 100%;
}

.ts-logout-btn {
    color: #dc3545;
}

.ts-logout-btn:hover {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

/* Email Verification Notice */
.ts-verification-notice {
    margin: 0 0 10px 0;
    padding: 15px 20px;
    background: linear-gradient(135deg, #fff5f5, #fef2f2);
    border: 1px solid #fed7d7;
    border-radius: 10px;
    border-top: 3px solid #f56565;
}

.ts-verification-content {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 12px;
}

.ts-verification-icon {
    color: #f56565;
    font-size: 16px;
    margin-top: 2px;
    flex-shrink: 0;
}

.ts-verification-text {
    flex: 1;
}

.ts-verification-text strong {
    display: block;
    color: #742a2a;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 4px;
}

.ts-verification-text p {
    color: #a0574e;
    font-size: 12px;
    margin: 0 0 8px 0;
    line-height: 1.4;
}

.ts-verification-timer {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
}

.timer-text {
    color: #a0574e;
    font-weight: 500;
}

.timer-countdown {
    color: #f56565;
    font-weight: 700;
    font-family: 'Courier New', monospace;
}

.ts-verification-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.ts-resend-form {
    margin: 0;
}

.ts-resend-btn {
    background: #f56565;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 11px;
    font-weight: 500;
    cursor: pointer;
    transition: var(--ts-transition);
    display: flex;
    align-items: center;
    gap: 4px;
}

.ts-resend-btn:hover {
    background: #e53e3e;
    transform: translateY(-1px);
}

.ts-resend-btn:disabled {
    background: #cbd5e0;
    color: #718096;
    cursor: not-allowed;
    transform: none;
}

.ts-verification-link {
    color: #f56565;
    text-decoration: none;
    font-size: 11px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    border-radius: 12px;
    transition: var(--ts-transition);
}

.ts-verification-link:hover {
    background: rgba(245, 101, 101, 0.1);
    color: #e53e3e;
    text-decoration: none;
}

/* Additional styles to override any default link behavior */
a {
    color: inherit;
    text-decoration: none;
}

a:hover {
    color: var(--ts-primary);
    text-decoration: none;
}

/* Cart Toggle */
.ts-cart-toggle {
    background: none;
    border: none;
    padding: 8px;
    position: relative;
    cursor: pointer;
    color: var(--ts-dark);
    transition: var(--ts-transition);
}

.ts-cart-count {
    position: absolute;
    top: 0;
    right: 0;
    background: var(--ts-primary);
    color: var(--ts-light);
    font-size: 12px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Mobile Menu Toggle */
.ts-menu-toggle {
    border: none;
    background: none;
    padding: 10px;
    cursor: pointer;
    display: none;
}

.ts-menu-toggle span {
    display: block;
    width: 25px;
    height: 2px;
    background: var(--ts-dark);
    margin: 5px 0;
    transition: var(--ts-transition);
}

/* Mobile Styles */
@media (max-width: 991px) {
    .ts-navbar__menu {
        position: fixed;
        top: 0;
        left: -280px;
        width: 280px;
        height: 100vh;
        background: var(--ts-light);
        padding: 40px 20px;
        transition: var(--ts-transition);
        box-shadow: var(--ts-shadow);
        overflow-y: auto;
        z-index: 1050;
    }

    .ts-navbar__menu.active {
        left: 0;
    }

    .ts-menu {
        flex-direction: column;
        gap: 10px;
    }

    .ts-menu__link {
        padding: 12px 0;
        display: block;
    }

    .ts-menu-toggle {
        display: block;
    }

    .ts-menu-close {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        font-size: 24px;
        color: var(--ts-dark);
        cursor: pointer;
    }

    .ts-navbar__wrapper {
        height: 80px;
    }

    .ts-logo__img {
        height: 70px;
    }

    .ts-navbar__actions {
        gap: 8px;
    }

    .ts-auth-buttons {
        gap: 6px;
    }

    .ts-btn {
        padding: 6px 12px;
        font-size: 13px;
    }

    .ts-user-name {
        display: none !important;
    }

    .ts-user-dropdown {
        right: -10px;
        min-width: 260px;
    }

    body {
        padding-top: 120px;
    }
}

@media (max-width: 991px) {
    .ts-navbar__wrapper {
        height: 70px;
    }

    .ts-logo__img {
        height: 60px;
    }

    .ts-btn span {
        display: none;
    }

    .ts-btn {
        padding: 8px;
        width: 40px;
        height: 40px;
        justify-content: center;
    }

    /* Special styling for mobile Sign In button */
    .ts-btn--mobile-small {
        width: auto !important;
        height: auto !important;
        padding: 6px 12px !important;
        font-size: 12px !important;
    }

    .ts-btn--mobile-small span {
        display: inline !important;
    }

    .ts-user-dropdown {
        right: -20px;
        min-width: 240px;
    }

    body {
        padding-top: 90px;
    }
}

/* Animation Classes */
.fade-in {
    animation: fadeIn 0.3s ease forwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const navbar = document.querySelector('.ts-navbar');
    const menuToggle = document.querySelector('.ts-menu-toggle');
    const mobileMenu = document.querySelector('.ts-navbar__menu');
    const menuClose = document.querySelector('.ts-menu-close');
    const userMenu = document.querySelector('.ts-user-menu');
    const userToggle = document.querySelector('.ts-user-toggle');
    
    // Scroll handling
    let lastScroll = 0;
    let isScrolling = false;
    
    window.addEventListener('scroll', () => {
        if (!isScrolling) {
            window.requestAnimationFrame(() => {
                const currentScroll = window.pageYOffset;
                const header = document.querySelector('.ts-header');
                
                // Add scrolled class for background change
                if (currentScroll > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
                
                // Hide/show header based on scroll direction (only on mobile)
                if (window.innerWidth <= 991) {
                    if (currentScroll > lastScroll && currentScroll > 100) {
                        // Scrolling down - hide header
                        header.classList.add('hidden');
                    } else if (currentScroll < lastScroll) {
                        // Scrolling up - show header
                        header.classList.remove('hidden');
                    }
                }
                
                lastScroll = currentScroll;
                isScrolling = false;
            });
        }
        isScrolling = true;
    });

    // Mobile menu handling
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileMenu.classList.add('active');
            document.body.style.overflow = 'hidden';
            // Close user menu if open
            if (userMenu) {
                userMenu.classList.remove('active');
            }
        });
    }

    if (menuClose) {
        menuClose.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // User menu handling
    if (userToggle && userMenu) {
        userToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenu.classList.toggle('active');
            // Close mobile menu if open
            if (mobileMenu) {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }

    // Close menus when clicking outside
    document.addEventListener('click', (e) => {
        // Close mobile menu
        if (mobileMenu && !mobileMenu.contains(e.target) && !menuToggle?.contains(e.target)) {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        // Close user menu
        if (userMenu && !userMenu.contains(e.target)) {
            userMenu.classList.remove('active');
        }
    });

    // Handle window resize
    window.addEventListener('resize', () => {
        const header = document.querySelector('.ts-header');
        
        if (window.innerWidth > 991) {
            // Desktop: always show header
            header.classList.remove('hidden');
            if (mobileMenu) {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            }
            if (userMenu) {
                userMenu.classList.remove('active');
            }
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Email verification countdown timer
    @auth
        @if(!auth()->user()->hasVerifiedEmail())
            const verificationTimer = document.getElementById('verificationTimer');
            const countdown = document.getElementById('countdown');
            const resendForm = document.getElementById('resendForm');
            
            if (verificationTimer && countdown) {
                // Get the creation time from session storage or estimate it
                const registrationTime = sessionStorage.getItem('registrationTime') || new Date().getTime();
                const expirationTime = parseInt(registrationTime) + (60 * 60 * 1000); // 60 minutes
                
                function updateTimer() {
                    const now = new Date().getTime();
                    const timeLeft = expirationTime - now;
                    
                    if (timeLeft > 0) {
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                        
                        countdown.textContent = 
                            String(minutes).padStart(2, '0') + ':' + 
                            String(seconds).padStart(2, '0');
                    } else {
                        countdown.textContent = 'Expired';
                        countdown.style.color = '#e53e3e';
                        // Show resend form
                        if (resendForm) {
                            resendForm.style.display = 'block';
                            verificationTimer.style.display = 'none';
                        }
                    }
                }
                
                // Update immediately and then every second
                updateTimer();
                setInterval(updateTimer, 1000);
                
                // Store registration time if this is a new registration
                @if(session('success') && str_contains(session('success'), 'Welcome to Glowzel'))
                    sessionStorage.setItem('registrationTime', new Date().getTime());
                @endif
            }
        @endif
    @endauth
});
</script>