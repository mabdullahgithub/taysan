<!DOCTYPE html>
<html lang="en">

@include('web.partials.head')
<!-- Required CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<body>
@include('toast')
    <!-- st        /* Mirror Reflection Effect */
        .bottom-nav-reflection {
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%) scaleY(-1);
            width: 100%;
            height: 20px;
            background: linear-gradient(
                to bottom,
                rgba(255, 255, 255, 0.15) 0%,
                rgba(255, 255, 255, 0.08) 50%,
                transparent 100%
            );
            border-radius: 25px;
            opacity: 0.7;
            filter: blur(5px);
            pointer-events: none;
        }>
    <div class="page-wrapper">
        <!-- start preloader -->
       <!-- Place this         /* Glassmorphism enhancement on scroll */
        .bottom-nav-bar.scrolled .bottom-nav-container {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(300px) saturate(5) brightness(1.4);
            -webkit-backdrop-filter: blur(300px) saturate(5) brightness(1.4);
        } beginning of your body tag -->
<div id="preloader">
    <div class="loader-wrapper">
        <div class="loader-content">
            <img src="{{asset('logo.png')}}" alt="Taysan Logo" class="loader-logo">
            <div class="loader-line"></div>
        </div>
    </div>
</div>

<style>
#preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: white;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.5s ease-out;
}

.loader-wrapper {
    text-align: center;
}

.loader-logo {
    width: 120px;
    height: auto;
    margin-bottom: 20px;
    animation: fadeIn 1s ease-in;
}

.loader-line {
    width: 100px;
    height: 2px;
    background: linear-gradient(90deg, transparent, #9B59B6, transparent);
    margin: 20px auto;
    position: relative;
    overflow: hidden;
}

.loader-line::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, #fff, transparent);
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% {
        left: -100%;
    }
    100% {
        left: 100%;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hide preloader once page is loaded */
.preloader-fade {
    opacity: 0;
    pointer-events: none;
}
</style>

<script>
window.addEventListener('load', function() {
    const preloader = document.getElementById('preloader');
    preloader.classList.add('preloader-fade');
    
    // Remove preloader from DOM after animation
    setTimeout(() => {
        preloader.style.display = 'none';
    }, 500);
});
</script>
        <!-- end preloader -->
    @include('web.partials.navbar')

    <!-- all content for pages extensd here -->
       @yield('content')
    <!-- all content for pages extensd here -->

        <!-- start of wpo-site-footer-section -->
       @include('web.partials.footer')
        <!-- end of wpo-site-footer-section -->

        <!-- popup-quickview  -->
      @include('web.partials.quickview')
      @include('web.shop.partials.floating-cart')
        <!-- end of popup-quickview -->

        <!-- Modern Bottom Navigation Bar -->
        <nav class="bottom-nav-bar">
            <div class="bottom-nav-container">
                <a href="{{ route('web.view.index') }}" class="bottom-nav-item {{ Request::is('/') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="nav-glow"></div>
                </a>
                
                <a href="{{ route('web.view.about') }}" class="bottom-nav-item {{ Request::is('about') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="nav-glow"></div>
                </a>
                
                <a href="{{ route('web.view.shop') }}" class="bottom-nav-item {{ Request::is('shop*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="nav-glow"></div>
                </a>
                
                <a href="{{ route('web.chatbot') }}" class="bottom-nav-item {{ Request::is('dr-ai') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="nav-glow"></div>
                </a>
            </div>
            
            <!-- Mirror Reflection Effect -->
            <div class="bottom-nav-reflection"></div>
        </nav>

        <style>
        /* Bottom Navigation Bar Styles */
        .bottom-nav-bar {
            position: fixed;
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: calc(100% - 32px);
            max-width: 400px;
            pointer-events: none;
        }

        .bottom-nav-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(200px) saturate(3) brightness(1.2);
            -webkit-backdrop-filter: blur(200px) saturate(3) brightness(1.2);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 25px;
            padding: 12px 20px;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.15),
                0 2px 8px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
            position: relative;
            pointer-events: all;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .bottom-nav-container:hover {
            background: rgba(255, 255, 255, 0.98);
            transform: translateY(-2px);
            backdrop-filter: blur(250px) saturate(4) brightness(1.3);
            -webkit-backdrop-filter: blur(250px) saturate(4) brightness(1.3);
            box-shadow: 
                0 12px 40px rgba(0, 0, 0, 0.2),
                0 4px 12px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }

        .bottom-nav-item {
            position: relative;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border-radius: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .nav-icon {
            position: relative;
            z-index: 2;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-icon i {
            font-size: 20px;
            color: rgba(153, 119, 181, 0.9);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .nav-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: radial-gradient(circle, rgba(153, 119, 181, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1;
        }

        /* Hover Effects */
        .bottom-nav-item:hover {
            transform: translateY(-3px) scale(1.05);
            text-decoration: none;
        }

        .bottom-nav-item:hover .nav-icon i {
            color: #9977B5;
            transform: scale(1.1);
            text-shadow: 0 2px 4px rgba(153, 119, 181, 0.2);
        }

        .bottom-nav-item:hover .nav-glow {
            width: 45px;
            height: 45px;
        }

        /* Active State */
        .bottom-nav-item.active {
            background: rgba(153, 119, 181, 0.2);
            border: 1px solid rgba(153, 119, 181, 0.3);
        }

        .bottom-nav-item.active .nav-icon i {
            color: #9977B5;
            transform: scale(1.15);
            text-shadow: 0 2px 4px rgba(153, 119, 181, 0.3);
        }

        .bottom-nav-item.active .nav-glow {
            width: 40px;
            height: 40px;
            background: radial-gradient(circle, rgba(153, 119, 181, 0.4) 0%, transparent 70%);
        }

        /* Tap Effect for Mobile */
        .bottom-nav-item:active {
            transform: translateY(-1px) scale(0.95);
        }

        /* Mirror Reflection Effect */
        .bottom-nav-reflection {
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%) scaleY(-1);
            width: 100%;
            height: 20px;
            background: linear-gradient(
                to bottom,
                rgba(255, 255, 255, 0.1) 0%,
                rgba(255, 255, 255, 0.05) 50%,
                transparent 100%
            );
            border-radius: 25px;
            opacity: 0.6;
            filter: blur(3px);
            pointer-events: none;
        }

        /* Pulse Animation for Active Items */
        @keyframes navPulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(153, 119, 181, 0.4);
            }
            50% {
                box-shadow: 0 0 0 8px rgba(153, 119, 181, 0.1);
            }
        }

        .bottom-nav-item.active {
            animation: navPulse 2s infinite;
        }

        /* Floating Animation */
        @keyframes float {
            0%, 100% {
                transform: translateX(-50%) translateY(0px);
            }
            50% {
                transform: translateX(-50%) translateY(-2px);
            }
        }

        .bottom-nav-bar {
            animation: float 3s ease-in-out infinite;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .bottom-nav-bar {
                width: calc(100% - 16px);
                bottom: 4px;
            }
            
            .bottom-nav-container {
                padding: 10px 15px;
                border-radius: 20px;
            }
            
            .bottom-nav-item {
                width: 45px;
                height: 45px;
            }
            
            .nav-icon i {
                font-size: 18px;
            }
        }

        @media (max-width: 375px) {
            .bottom-nav-container {
                padding: 8px 12px;
            }
            
            .bottom-nav-item {
                width: 40px;
                height: 40px;
            }
            
            .nav-icon i {
                font-size: 16px;
            }
        }

        /* Hide on desktop screens where it's not needed */
        @media (min-width: 1200px) {
            .bottom-nav-bar {
                display: none;
            }
        }

        /* Ensure proper spacing from content */
        @media (max-width: 1199px) {
            body {
                padding-bottom: 90px;
            }
        }

        /* Animation for entrance */
        .bottom-nav-bar {
            opacity: 0;
            transform: translateX(-50%) translateY(100px);
            animation: slideInBottom 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.5s forwards, float 3s ease-in-out 1.3s infinite;
        }

        @keyframes slideInBottom {
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0px);
            }
        }

        /* Glassmorphism enhancement on scroll */
        .bottom-nav-bar.scrolled .bottom-nav-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(50px) saturate(5) brightness(1.4);
            -webkit-backdrop-filter: blur(50px) saturate(5) brightness(1.4);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.2),
                0 2px 8px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }
        </style>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bottomNav = document.querySelector('.bottom-nav-bar');
            
            // Add scroll effect for enhanced glassmorphism
            window.addEventListener('scroll', () => {
                if (window.scrollY > 100) {
                    bottomNav.classList.add('scrolled');
                } else {
                    bottomNav.classList.remove('scrolled');
                }
            });
            
            // Add touch feedback for mobile
            const navItems = document.querySelectorAll('.bottom-nav-item');
            navItems.forEach(item => {
                item.addEventListener('touchstart', () => {
                    item.style.transform = 'translateY(-1px) scale(0.95)';
                });
                
                item.addEventListener('touchend', () => {
                    setTimeout(() => {
                        item.style.transform = '';
                    }, 150);
                });
            });
        });
        </script>

    </div>
    <!-- end of page-wrapper -->

@include('web.partials.scripts')
@stack('scripts')

</body>

</html>