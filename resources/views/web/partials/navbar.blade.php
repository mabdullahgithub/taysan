<!-- Main Header -->
<header class="ts-header">
    <!-- Announcement Bar -->
    <div class="ts-announce">
        <div class="container-fluid">
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
                        <img src="{{ $logoUrl }}" alt="Taysan Beauty" class="ts-logo__img">
                    </a>
                </div>

                <!-- Navigation Menu -->
                <div class="ts-navbar__menu" id="tsMainMenu">
                    <!-- Close Button for Mobile -->
                    <button class="ts-menu-close d-lg-none">
                        <i class="fas fa-times"></i>
                    </button>

                    <!-- Navigation Links -->
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

                <!-- Cart Icon -->
                <div class="ts-navbar__cart">
                   
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
    padding: 15px 0;
    position: relative;
}

/* Logo Styling */
.ts-logo {
    display: inline-block;
    padding: 5px 0;
}

.ts-logo__img {
    height: 50px;
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

    .ts-logo__img {
        height: 40px;
    }

    body {
        padding-top: 80px; /* Adjusted for mobile header height */
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
    
    // Scroll handling
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        // Add scrolled class for background change
        if (currentScroll > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        lastScroll = currentScroll;
    });

    // Mobile menu handling
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileMenu.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    if (menuClose) {
        menuClose.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (mobileMenu && !mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // Handle window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth > 991 && mobileMenu) {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});
</script>