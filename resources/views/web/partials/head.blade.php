<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="{{ \App\Models\Setting::get('site_author', 'Glowzel Beauty') }}">
    <meta name="description" content="{{ \App\Models\Setting::get('site_description', 'Your trusted destination for natural beauty products. We specialize in handcrafted soaps and organic skincare made with love and pure ingredients.') }}">
    <meta name="keywords" content="{{ \App\Models\Setting::get('site_keywords', 'natural soap, handcrafted skincare, organic beauty products, Glowzel Beauty') }}">
    @php
        $logo = \App\Models\Setting::get('logo');
        $logoUrl = $logo ? asset('storage/' . $logo) : asset('logo.png');
    @endphp
    <link rel="shortcut icon" type="image/png" href="{{ $logoUrl }}">
    <title>{{ \App\Models\Setting::get('site_title', 'Glowzel Beauty - Natural Handcrafted Soaps & Skincare') }}</title>
    <link href="{{ asset('assets/css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/flaticon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/owl.theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/swiper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/owl.transitions.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/odometer-theme-default.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/sass/style.css') }}" rel="stylesheet">
    <!-- Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
    <!-- In app.blade.php, add this before the closing </head> tag -->
<script src="{{ asset('js/cart-manager.js') }}" defer></script>
</head>

