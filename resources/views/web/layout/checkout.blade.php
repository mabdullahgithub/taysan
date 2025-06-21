<!DOCTYPE html>
<html lang="en">

@include('web.partials.head')
<!-- Required CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<body>
@include('toast')
    <!-- start page-wrapper -->
    <div class="page-wrapper">
        <!-- start preloader -->
       <!-- Place this at the beginning of your body tag -->
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
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #8D68AD 0%, #B591D1 50%, #8D68AD 100%);
    border-radius: 2px;
    margin: 0 auto;
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
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent);
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { left: -100%; }
    100% { left: 100%; }
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

/* Back button styles */
.checkout-back-button {
    position: fixed;
    top: 60px;
    left: 20px;
    z-index: 1000;
    background: #8D68AD;
    color: white;
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 18px;
    box-shadow: 0 4px 12px rgba(141, 104, 173, 0.3);
    transition: all 0.3s ease;
}

/* Announcement Bar Styles */
.ts-announce {
    background: #8D68AD;
    padding: 8px 0;
    text-align: center;
    overflow: hidden;
    white-space: nowrap;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1041;
}

.marquee-content {
    display: inline-block;
    animation: marquee 30s linear infinite;
    font-size: 14px;
    font-weight: 500;
    color: #FFFFFF;
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

.checkout-back-button:hover {
    background: #7a5a96;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(141, 104, 173, 0.4);
}

.checkout-back-button:active {
    transform: translateY(0);
}

@media (max-width: 768px) {
    .checkout-back-button {
        top: 55px;
        left: 15px;
        width: 45px;
        height: 45px;
        font-size: 16px;
    }
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

    <!-- Announcement Bar -->
    <div class="ts-announce">
        <div class="container-fluid">
            <div class="marquee-content">
                ✨ Embrace Natural Beauty • Handcrafted Luxury Soaps • Pure, Organic Skincare • Premium Quality You Can Feel • Eco-Friendly & Kind to Skin • Free Shipping on $50+ Orders!
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <button class="checkout-back-button" onclick="goBack()" title="Go Back">
        <i class="fas fa-arrow-left"></i>
    </button>

    <!-- all content for pages extensd here -->
       @yield('content')
    <!-- all content for pages extensd here -->

        <!-- start of wpo-site-footer-section -->
       @include('web.partials.footer')
        <!-- end of wpo-site-footer-section -->

        <!-- popup-quickview  -->
      @include('web.partials.quickview')
      {{-- @include('web.shop.partials.floating-cart') --}}
        <!-- end of popup-quickview -->

    </div>
    <!-- end of page-wrapper -->

@include('web.partials.scripts')

<script>
function goBack() {
    // Try to go back in history, if no history go to shop page
    if (window.history.length > 1) {
        window.history.back();
    } else {
        window.location.href = "{{ route('web.view.shop') }}";
    }
}
</script>

@stack('scripts')

</body>

</html>
