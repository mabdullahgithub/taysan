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

    </div>
    <!-- end of page-wrapper -->

@include('web.partials.scripts')
@stack('scripts')

</body>

</html>