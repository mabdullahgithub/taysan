@extends('admin.layout.app')
@section('title', 'Manage Banners')

@section('content')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary-color: #8B7BA8;
        --primary-light: #A893C4;
        --primary-lighter: #C4B5D8;
        --primary-lightest: #E9E3F0;
        --primary-dark: #6B5B7D;
        --background: #F8F9FA;
        --white: #FFFFFF;
        --text-dark: #2D3748;
        --text-medium: #4A5568;
        --text-light: #718096;
        --border-light: #E2E8F0;
        --success: #48BB78;
        --warning: #ED8936;
        --danger: #F56565;
        --info: #4299E1;
    }

    .settings-container {
        background-color: var(--background);
        min-height: 100vh;
        padding: 2rem 1rem;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        color: var(--white);
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(139, 123, 168, 0.2);
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        opacity: 0.85;
        font-size: 1rem;
        margin: 0;
    }

    .size-recommendation {
        background: rgba(255, 255, 255, 0.15);
        padding: 1rem;
        border-radius: 12px;
        margin-top: 1rem;
    }

    .banner-card {
        background: var(--white);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 2px 10px rgba(139, 123, 168, 0.08);
        margin-bottom: 2rem;
        transition: all 0.2s ease;
    }

    .banner-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(139, 123, 168, 0.15);
    }

    .banner-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-light);
    }

    .banner-header h5 {
        margin: 0;
        color: var(--text-dark);
        font-weight: 600;
    }

    .banner-header i {
        color: var(--primary-color);
    }

    .banner-preview {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-light);
    }

    .banner-preview img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-medium);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: var(--primary-color);
    }

    .form-control {
        border: 1px solid var(--border-light);
        border-radius: 8px;
        padding: 0.75rem;
        transition: border-color 0.2s ease;
        font-size: 0.9rem;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(139, 123, 168, 0.1);
    }

    /* Override Bootstrap default focus styles */
    .form-control:focus {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 0.2rem rgba(139, 123, 168, 0.25) !important;
    }

    /* Button styles */
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .btn-secondary {
        background-color: var(--text-light);
        border-color: var(--text-light);
    }

    .btn-secondary:hover, .btn-secondary:focus, .btn-secondary:active {
        background-color: var(--text-medium);
        border-color: var(--text-medium);
    }

    .custom-file {
        position: relative;
        margin-bottom: 1rem;
    }

    .custom-file-input {
        position: relative;
        z-index: 2;
        width: 100%;
        height: calc(2.25rem + 2px);
        margin: 0;
        opacity: 0;
    }

    .custom-file-label {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1;
        height: calc(2.25rem + 2px);
        padding: 0.75rem;
        line-height: 1.5;
        color: var(--text-medium);
        background-color: var(--white);
        border: 1px solid var(--border-light);
        border-radius: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .custom-file-label:hover {
        border-color: var(--primary-color);
        background-color: rgba(139, 123, 168, 0.05);
    }

    .custom-file-label::after {
        content: "Choose file";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        display: block;
        height: calc(2.25rem);
        padding: 0.75rem 1rem;
        line-height: 1.5;
        color: var(--white);
        background-color: var(--primary-color);
        border-left: 1px solid var(--primary-color);
        border-radius: 0 8px 8px 0;
        transition: background-color 0.2s ease;
    }

    .custom-file-input:hover + .custom-file-label::after {
        background-color: var(--primary-dark);
    }

    .file-hint {
        color: var(--text-light);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .alert {
        padding: 1rem;
        margin-bottom: 1.5rem;
        border: 1px solid transparent;
        border-radius: 0.5rem;
        position: relative;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert ul {
        margin-bottom: 0;
        padding-left: 1.5rem;
    }

    .alert .close {
        position: absolute;
        top: 0.5rem;
        right: 0.75rem;
        padding: 0;
        background: none;
        border: none;
        font-size: 1.25rem;
        cursor: pointer;
        opacity: 0.5;
    }

    .alert .close:hover {
        opacity: 1;
    }

    .btn-primary-custom {
        background: var(--primary-color);
        border: 1px solid var(--primary-color);
        color: var(--white);
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 1rem;
    }

    .btn-primary-custom:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        color: var(--white);
        transform: translateY(-1px);
        text-decoration: none;
    }

    .alert-custom {
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: rgba(72, 187, 120, 0.1);
        color: var(--success);
        border-left: 4px solid var(--success);
    }

    .alert-danger {
        background: rgba(245, 101, 101, 0.1);
        color: var(--danger);
        border-left: 4px solid var(--danger);
    }

    .form-actions {
        background: var(--white);
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(139, 123, 168, 0.08);
        text-align: center;
        margin-top: 2rem;
    }

    /* Banner Cards Grid Styles */
    .banners-grid {
        margin-bottom: 3rem;
        padding: 0 1rem;
    }

    .banner-card-small {
        background: var(--white);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(139, 123, 168, 0.12);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        height: 220px;
        margin-bottom: 1.5rem;
    }

    .banner-card-small:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(139, 123, 168, 0.25);
    }

    .banner-card-image {
        height: 120px;
        overflow: hidden;
        position: relative;
        background: var(--primary-lightest);
    }

    .banner-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .banner-card-small:hover .banner-card-image img {
        transform: scale(1.05);
    }

    .no-image {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary-lightest), var(--primary-lighter));
        color: var(--primary-color);
        font-size: 2rem;
    }

    .banner-card-content {
        padding: 1.25rem;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: var(--white);
        border-top: 1px solid var(--border-light);
    }

    .banner-card-content h6 {
        margin: 0 0 0.5rem 0;
        color: var(--text-dark);
        font-weight: 600;
        font-size: 0.95rem;
    }

    .banner-card-content p {
        margin: 0;
        color: var(--text-light);
        font-size: 0.85rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .banner-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(139, 123, 168, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        color: var(--white);
        font-size: 1.5rem;
    }

    .banner-card-small:hover .banner-card-overlay {
        opacity: 1;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: var(--white);
        border-radius: 16px 16px 0 0;
        border-bottom: none;
        padding: 2rem;
    }

    .modal-title {
        font-weight: 600;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--border-light);
        gap: 1rem;
    }

    .banner-modal-preview {
        background: var(--primary-lightest);
        border-radius: 12px;
        margin-bottom: 2rem;
        overflow: hidden;
        border: 2px dashed var(--primary-lighter);
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .banner-modal-preview img {
        width: 100%;
        height: auto;
        max-height: 300px;
        object-fit: contain;
    }

    .banner-modal-preview .no-preview {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .banner-modal-preview .no-preview i {
        font-size: 3rem;
        opacity: 0.6;
    }

    .row.g-3 {
        margin-top: 1rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-medium);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .modal-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        border-top: 1px solid var(--border-light);
        padding: 1.5rem;
    }

    .banner-modal-preview {
        width: 100%;
        height: 200px;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        border: 2px dashed var(--border-light);
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-lightest);
    }

    .banner-modal-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .banner-modal-preview .no-preview {
        color: var(--text-light);
        text-align: center;
    }

    .banner-modal-preview .no-preview i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    /* Categories Table Styles */
    .table {
        margin-bottom: 0;
        color: var(--text-dark);
    }

    .table th {
        border-top: none;
        border-bottom: 2px solid var(--border-light);
        font-weight: 600;
        color: var(--text-dark);
        background-color: var(--primary-lightest);
        padding: 1rem 0.75rem;
    }

    .table td {
        padding: 1rem 0.75rem;
        border-top: 1px solid var(--border-light);
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: var(--primary-lightest);
    }

    .badge {
        padding: 0.5rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 20px;
    }

    .badge-info {
        color: #0c5460;
        background-color: #bee5eb;
    }

    .btn-group .btn {
        margin-right: 0.25rem;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
    }

    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-primary:hover {
        color: var(--white);
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-danger {
        color: var(--danger);
        border-color: var(--danger);
    }

    .btn-outline-danger:hover {
        color: var(--white);
        background-color: var(--danger);
        border-color: var(--danger);
    }

    .btn-outline-secondary {
        color: var(--text-light);
        border-color: var(--border-light);
    }

    /* Form Styles */
    .form-control {
        border: 1px solid var(--border-light);
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(139, 123, 168, 0.25);
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .settings-container {
            padding: 1rem 0.5rem;
        }
        
        .page-header {
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .page-title {
            font-size: 1.5rem;
            justify-content: center;
        }
        
        .banner-card {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .banner-preview img {
            height: 150px;
        }

        .banners-grid {
            padding: 0 0.5rem;
        }

        .banner-card-small {
            height: 200px;
            margin-bottom: 1rem;
        }

        .modal-header {
            padding: 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .settings-container {
            padding: 0.5rem;
        }

        .page-header {
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .banner-card {
            padding: 1rem;
        }

        .banners-grid {
            padding: 0;
        }

        .banner-card-small {
            height: 180px;
        }

        .banner-card-content {
            padding: 0.75rem;
        }

        .modal-dialog {
            margin: 0.5rem;
        }

        /* Categories table responsive */
        .table-responsive {
            font-size: 0.875rem;
        }

        .table th,
        .table td {
            padding: 0.5rem;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .btn-group .btn {
            margin-right: 0;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
    }
</style>

<div class="settings-container">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="page-title">
                        <i class="fas fa-images"></i>
                        Manage Banners
                    </h1>
                    <p class="page-subtitle">Configure banner images and text for the website</p>
                </div>
                <div class="col-md-4">
                    <div class="size-recommendation">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-ruler-combined mr-2"></i>
                            <div>
                                <small class="d-block font-weight-bold">Recommended Dimensions</small>
                                <span class="d-block">1920 x 600 pixels</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                <h6><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h6>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <h6><i class="fas fa-exclamation-triangle"></i> Upload Errors:</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <div class="mt-2">
                    <small><strong>Tip:</strong> If you're getting file size errors, please compress your images to under 8MB before uploading.</small>
                </div>
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Banner Cards Grid -->
        <div class="container-fluid">
            <div class="banners-grid">
                <div class="row g-3">
                    <!-- Home Banner Card -->
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="banner-card-small" data-toggle="modal" data-target="#homeBannerModal">
                            <div class="banner-card-image">
                                @if($homeBanner && $homeBanner->image)
                                    <img src="{{ asset('storage/'.$homeBanner->image) }}" alt="Home Banner">
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-home"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="banner-card-content">
                                <h6>Home Banner</h6>
                                <p>{{ $homeBanner->title ?? 'No title set' }}</p>
                            </div>
                            <div class="banner-card-overlay">
                                <i class="fas fa-edit"></i>
                            </div>
                        </div>
                    </div>

                <!-- Shop Banner Card -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="banner-card-small" data-toggle="modal" data-target="#shopBannerModal">
                        <div class="banner-card-image">
                            @if($shopBanner && $shopBanner->image)
                                <img src="{{ asset('storage/'.$shopBanner->image) }}" alt="Shop Banner">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                            @endif
                        </div>
                        <div class="banner-card-content">
                            <h6>Shop Banner</h6>
                            <p>{{ $shopBanner->title ?? 'No title set' }}</p>
                        </div>
                        <div class="banner-card-overlay">
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>
                </div>

                <!-- About Banner Card -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="banner-card-small" data-toggle="modal" data-target="#aboutBannerModal">
                        <div class="banner-card-image">
                            @if($aboutBanner && $aboutBanner->image)
                                <img src="{{ asset('storage/'.$aboutBanner->image) }}" alt="About Banner">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                            @endif
                        </div>
                        <div class="banner-card-content">
                            <h6>About Banner</h6>
                            <p>{{ $aboutBanner->title ?? 'No title set' }}</p>
                        </div>
                        <div class="banner-card-overlay">
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>
                </div>

                <!-- Contact Banner Card -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="banner-card-small" data-toggle="modal" data-target="#contactBannerModal">
                        <div class="banner-card-image">
                            @if($contactBanner && $contactBanner->image)
                                <img src="{{ asset('storage/'.$contactBanner->image) }}" alt="Contact Banner">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-phone"></i>
                                </div>
                            @endif
                        </div>
                        <div class="banner-card-content">
                            <h6>Contact Banner</h6>
                            <p>{{ $contactBanner->title ?? 'No title set' }}</p>
                        </div>
                        <div class="banner-card-overlay">
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>
                </div>

                <!-- Checkout Banner Card -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="banner-card-small" data-toggle="modal" data-target="#checkoutBannerModal">
                        <div class="banner-card-image">
                            @if($checkoutBanner && $checkoutBanner->image)
                                <img src="{{ asset('storage/'.$checkoutBanner->image) }}" alt="Checkout Banner">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            @endif
                        </div>
                        <div class="banner-card-content">
                            <h6>Checkout Banner</h6>
                            <p>{{ $checkoutBanner->title ?? 'No title set' }}</p>
                        </div>
                        <div class="banner-card-overlay">
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>
                </div>

                <!-- Weekend Sale GIF Card -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="banner-card-small" data-toggle="modal" data-target="#weekendSaleGifModal">
                        <div class="banner-card-image">
                            @if($weekendSaleGif && $weekendSaleGif->image)
                                <img src="{{ asset('storage/'.$weekendSaleGif->image) }}" alt="Weekend Sale GIF">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-percentage"></i>
                                </div>
                            @endif
                        </div>
                        <div class="banner-card-content">
                            <h6>Weekend Sale GIF</h6>
                            <p>{{ $weekendSaleGif->title ?? 'No title set' }}</p>
                        </div>
                        <div class="banner-card-overlay">
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Banner Modals -->

        <!-- Home Banner Modal -->
        <div class="modal fade" id="homeBannerModal" tabindex="-1" aria-labelledby="homeBannerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="homeBannerModalLabel">
                            <i class="fas fa-home"></i>
                            Home Page Banner
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('settings.update.banners') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="banner-modal-preview" id="homeBannerPreview">
                                @if($homeBanner && $homeBanner->image)
                                    <img src="{{ asset('storage/'.$homeBanner->image) }}" alt="Home Banner">
                                @else
                                    <div class="no-preview">
                                        <i class="fas fa-home"></i>
                                        <div>No image uploaded</div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">
                                        <i class="fas fa-upload"></i>
                                        Banner Image
                                    </label>
                                    <input type="file" class="form-control" name="home_banner" accept="image/*" onchange="previewImage(this, 'homeBannerPreview')">
                                    <small class="text-muted">Supports: JPEG, PNG, JPG, GIF | Max size: 8MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-heading"></i>
                                        Title
                                    </label>
                                    <input type="text" class="form-control" name="home_title" value="{{ $homeBanner->title ?? '' }}" placeholder="Enter banner title">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-text-width"></i>
                                        Subtitle
                                    </label>
                                    <input type="text" class="form-control" name="home_subtitle" value="{{ $homeBanner->subtitle ?? '' }}" placeholder="Enter banner subtitle">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Update Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Shop Banner Modal -->
        <div class="modal fade" id="shopBannerModal" tabindex="-1" aria-labelledby="shopBannerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shopBannerModalLabel">
                            <i class="fas fa-shopping-bag"></i>
                            Shop Page Banner
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('settings.update.banners') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="banner-modal-preview" id="shopBannerPreview">
                                @if($shopBanner && $shopBanner->image)
                                    <img src="{{ asset('storage/'.$shopBanner->image) }}" alt="Shop Banner">
                                @else
                                    <div class="no-preview">
                                        <i class="fas fa-shopping-bag"></i>
                                        <div>No image uploaded</div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">
                                        <i class="fas fa-upload"></i>
                                        Banner Image
                                    </label>
                                    <input type="file" class="form-control" name="shop_banner" accept="image/*" onchange="previewImage(this, 'shopBannerPreview')">
                                    <small class="text-muted">Supports: JPEG, PNG, JPG, GIF | Max size: 8MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-heading"></i>
                                        Title
                                    </label>
                                    <input type="text" class="form-control" name="shop_title" value="{{ $shopBanner->title ?? '' }}" placeholder="Enter banner title">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-text-width"></i>
                                        Subtitle
                                    </label>
                                    <input type="text" class="form-control" name="shop_subtitle" value="{{ $shopBanner->subtitle ?? '' }}" placeholder="Enter banner subtitle">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Update Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- About Banner Modal -->
        <div class="modal fade" id="aboutBannerModal" tabindex="-1" aria-labelledby="aboutBannerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="aboutBannerModalLabel">
                            <i class="fas fa-info-circle"></i>
                            About Page Banner
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('settings.update.banners') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="banner-modal-preview" id="aboutBannerPreview">
                                @if($aboutBanner && $aboutBanner->image)
                                    <img src="{{ asset('storage/'.$aboutBanner->image) }}" alt="About Banner">
                                @else
                                    <div class="no-preview">
                                        <i class="fas fa-info-circle"></i>
                                        <div>No image uploaded</div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">
                                        <i class="fas fa-upload"></i>
                                        Banner Image
                                    </label>
                                    <input type="file" class="form-control" name="about_banner" accept="image/*" onchange="previewImage(this, 'aboutBannerPreview')">
                                    <small class="text-muted">Supports: JPEG, PNG, JPG, GIF | Max size: 8MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-heading"></i>
                                        Title
                                    </label>
                                    <input type="text" class="form-control" name="about_title" value="{{ $aboutBanner->title ?? '' }}" placeholder="Enter banner title">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-text-width"></i>
                                        Subtitle
                                    </label>
                                    <input type="text" class="form-control" name="about_subtitle" value="{{ $aboutBanner->subtitle ?? '' }}" placeholder="Enter banner subtitle">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Update Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Banner Modal -->
        <div class="modal fade" id="contactBannerModal" tabindex="-1" aria-labelledby="contactBannerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contactBannerModalLabel">
                            <i class="fas fa-phone"></i>
                            Contact Page Banner
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('settings.update.banners') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="banner-modal-preview" id="contactBannerPreview">
                                @if($contactBanner && $contactBanner->image)
                                    <img src="{{ asset('storage/'.$contactBanner->image) }}" alt="Contact Banner">
                                @else
                                    <div class="no-preview">
                                        <i class="fas fa-phone"></i>
                                        <div>No image uploaded</div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">
                                        <i class="fas fa-upload"></i>
                                        Banner Image
                                    </label>
                                    <input type="file" class="form-control" name="contact_banner" accept="image/*" onchange="previewImage(this, 'contactBannerPreview')">
                                    <small class="text-muted">Supports: JPEG, PNG, JPG, GIF | Max size: 8MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-heading"></i>
                                        Title
                                    </label>
                                    <input type="text" class="form-control" name="contact_title" value="{{ $contactBanner->title ?? '' }}" placeholder="Enter banner title">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-text-width"></i>
                                        Subtitle
                                    </label>
                                    <input type="text" class="form-control" name="contact_subtitle" value="{{ $contactBanner->subtitle ?? '' }}" placeholder="Enter banner subtitle">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Update Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Checkout Banner Modal -->
        <div class="modal fade" id="checkoutBannerModal" tabindex="-1" aria-labelledby="checkoutBannerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="checkoutBannerModalLabel">
                            <i class="fas fa-shopping-cart"></i>
                            Checkout Page Banner
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('settings.update.banners') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="banner-modal-preview" id="checkoutBannerPreview">
                                @if($checkoutBanner && $checkoutBanner->image)
                                    <img src="{{ asset('storage/'.$checkoutBanner->image) }}" alt="Checkout Banner">
                                @else
                                    <div class="no-preview">
                                        <i class="fas fa-shopping-cart"></i>
                                        <div>No image uploaded</div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">
                                        <i class="fas fa-upload"></i>
                                        Banner Image
                                    </label>
                                    <input type="file" class="form-control" name="checkout_banner" accept="image/*" onchange="previewImage(this, 'checkoutBannerPreview')">
                                    <small class="text-muted">Supports: JPEG, PNG, JPG, GIF | Max size: 8MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-heading"></i>
                                        Title
                                    </label>
                                    <input type="text" class="form-control" name="checkout_title" value="{{ $checkoutBanner->title ?? '' }}" placeholder="Enter banner title">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-text-width"></i>
                                        Subtitle
                                    </label>
                                    <input type="text" class="form-control" name="checkout_subtitle" value="{{ $checkoutBanner->subtitle ?? '' }}" placeholder="Enter banner subtitle">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Update Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mid Photo Banner Modal -->
        <div class="modal fade" id="midPhotoBannerModal" tabindex="-1" aria-labelledby="midPhotoBannerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="midPhotoBannerModalLabel">
                            <i class="fas fa-image"></i>
                            Mid Photo Banner
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('settings.update.banners') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="banner-modal-preview" id="midPhotoBannerPreview">
                                @if($midPhotoBanner && $midPhotoBanner->image)
                                    <img src="{{ asset('storage/'.$midPhotoBanner->image) }}" alt="Mid Photo Banner">
                                @else
                                    <div class="no-preview">
                                        <i class="fas fa-image"></i>
                                        <div>No image uploaded</div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">
                                        <i class="fas fa-upload"></i>
                                        Banner Image
                                    </label>
                                    <input type="file" class="form-control" name="mid_photo" accept="image/*" onchange="previewImage(this, 'midPhotoBannerPreview')">
                                    <small class="text-muted">Supports: JPEG, PNG, JPG, GIF | Max size: 8MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-heading"></i>
                                        Title
                                    </label>
                                    <input type="text" class="form-control" name="mid_title" value="{{ $midPhotoBanner->title ?? '' }}" placeholder="Enter banner title">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-text-width"></i>
                                        Subtitle
                                    </label>
                                    <input type="text" class="form-control" name="mid_subtitle" value="{{ $midPhotoBanner->subtitle ?? '' }}" placeholder="Enter banner subtitle">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Update Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Left Image Banner Modal -->
        <div class="modal fade" id="leftImageBannerModal" tabindex="-1" aria-labelledby="leftImageBannerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="leftImageBannerModalLabel">
                            <i class="fas fa-arrow-left"></i>
                            Left Image Banner
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('settings.update.banners') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="banner-modal-preview" id="leftImageBannerPreview">
                                @if($leftImageBanner && $leftImageBanner->image)
                                    <img src="{{ asset('storage/'.$leftImageBanner->image) }}" alt="Left Image Banner">
                                @else
                                    <div class="no-preview">
                                        <i class="fas fa-arrow-left"></i>
                                        <div>No image uploaded</div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">
                                        <i class="fas fa-upload"></i>
                                        Banner Image
                                    </label>
                                    <input type="file" class="form-control" name="left_image" accept="image/*" onchange="previewImage(this, 'leftImageBannerPreview')">
                                    <small class="text-muted">Supports: JPEG, PNG, JPG, GIF | Max size: 8MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-heading"></i>
                                        Title
                                    </label>
                                    <input type="text" class="form-control" name="left_title" value="{{ $leftImageBanner->title ?? '' }}" placeholder="Enter banner title">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-text-width"></i>
                                        Subtitle
                                    </label>
                                    <input type="text" class="form-control" name="left_subtitle" value="{{ $leftImageBanner->subtitle ?? '' }}" placeholder="Enter banner subtitle">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Update Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Image Banner Modal -->
        <div class="modal fade" id="rightImageBannerModal" tabindex="-1" aria-labelledby="rightImageBannerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rightImageBannerModalLabel">
                            <i class="fas fa-arrow-right"></i>
                            Right Image Banner
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('settings.update.banners') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="banner-modal-preview" id="rightImageBannerPreview">
                                @if($rightImageBanner && $rightImageBanner->image)
                                    <img src="{{ asset('storage/'.$rightImageBanner->image) }}" alt="Right Image Banner">
                                @else
                                    <div class="no-preview">
                                        <i class="fas fa-arrow-right"></i>
                                        <div>No image uploaded</div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">
                                        <i class="fas fa-upload"></i>
                                        Banner Image
                                    </label>
                                    <input type="file" class="form-control" name="right_image" accept="image/*" onchange="previewImage(this, 'rightImageBannerPreview')">
                                    <small class="text-muted">Supports: JPEG, PNG, JPG, GIF | Max size: 8MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-heading"></i>
                                        Title
                                    </label>
                                    <input type="text" class="form-control" name="right_title" value="{{ $rightImageBanner->title ?? '' }}" placeholder="Enter banner title">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-text-width"></i>
                                        Subtitle
                                    </label>
                                    <input type="text" class="form-control" name="right_subtitle" value="{{ $rightImageBanner->subtitle ?? '' }}" placeholder="Enter banner subtitle">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Update Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Weekend Sale GIF Modal -->
        <div class="modal fade" id="weekendSaleGifModal" tabindex="-1" aria-labelledby="weekendSaleGifModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="weekendSaleGifModalLabel">
                            <i class="fas fa-percentage"></i>
                            Weekend Sale GIF
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('settings.update.banners') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="banner-modal-preview" id="weekendSaleGifPreview">
                                @if($weekendSaleGif && $weekendSaleGif->image)
                                    <img src="{{ asset('storage/'.$weekendSaleGif->image) }}" alt="Weekend Sale GIF">
                                @else
                                    <div class="no-preview">
                                        <i class="fas fa-percentage"></i>
                                        <div>No GIF uploaded</div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">
                                        <i class="fas fa-upload"></i>
                                        Weekend Sale GIF
                                    </label>
                                    <input type="file" class="form-control" name="weekend_sale_gif" accept="image/*" onchange="previewImage(this, 'weekendSaleGifPreview')">
                                    <small class="text-muted">Supports: JPEG, PNG, JPG, GIF | Max size: 8MB | Recommended: GIF format for animations</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-heading"></i>
                                        Title
                                    </label>
                                    <input type="text" class="form-control" name="weekend_sale_title" value="{{ $weekendSaleGif->title ?? '' }}" placeholder="Enter GIF title">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-text-width"></i>
                                        Subtitle
                                    </label>
                                    <input type="text" class="form-control" name="weekend_sale_subtitle" value="{{ $weekendSaleGif->subtitle ?? '' }}" placeholder="Enter GIF subtitle">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Update GIF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Categories Management Section -->
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-tags"></i>
                    Categories Management
                </h1>
                <p class="page-subtitle">Manage product categories for your store</p>
            </div>

            <!-- Add New Category Card -->
            <div class="banner-card mb-4">
                <div class="banner-header">
                    <i class="fas fa-plus"></i>
                    <h5>Add New Category</h5>
                </div>

                <form action="{{ route('settings.categories.store') }}" method="POST" id="addCategoryForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">
                                <i class="fas fa-tag"></i>
                                Category Name
                            </label>
                            <input type="text" class="form-control" name="name" placeholder="Enter category name" required>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-plus"></i>
                                Add Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Categories List Card -->
            <div class="banner-card">
                <div class="banner-header">
                    <i class="fas fa-list"></i>
                    <h5>Existing Categories</h5>
                </div>

                @if($categories && $categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="40%">Category Name</th>
                                    <th width="20%">Products Count</th>
                                    <th width="20%">Created</th>
                                    <th width="10%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $index => $category)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $category->name }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $category->products->count() }} products
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $category->created_at->format('M d, Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        data-toggle="modal" 
                                                        data-target="#editCategoryModal{{ $category->id }}"
                                                        title="Edit Category">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                @if($category->products->count() == 0)
                                                    <form action="{{ route('settings.categories.destroy', $category) }}" 
                                                          method="POST" 
                                                          style="display: inline-block;"
                                                          onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                title="Delete Category">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                            disabled
                                                            title="Cannot delete category with products">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-tags text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                        <h5 class="text-muted mt-3">No Categories Found</h5>
                        <p class="text-muted">Start by adding your first product category above.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Edit Category Modals -->
        @if($categories && $categories->count() > 0)
            @foreach($categories as $category)
                <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">
                                    <i class="fas fa-edit"></i>
                                    Edit Category
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('settings.categories.update', $category) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-tag"></i>
                                            Category Name
                                        </label>
                                        <input type="text" class="form-control" name="name" value="{{ $category->name }}" required>
                                    </div>
                                    
                                    @if($category->products->count() > 0)
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i>
                                            This category has {{ $category->products->count() }} product(s) associated with it.
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i>
                                        Update Category
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <!-- General Settings Section -->
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-cog"></i>
                    General Settings
                </h1>
                <p class="page-subtitle">Manage site logo, meta tags, and footer content</p>
            </div>

            <form action="{{ route('settings.update.general') }}" method="POST" enctype="multipart/form-data" id="generalSettingsForm">
                @csrf
                @method('PUT')

                <!-- Site Settings Card -->
                <div class="banner-card">
                    <div class="banner-header">
                        <i class="fas fa-globe"></i>
                        <h5>Site Settings</h5>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Site Title</label>
                            <input type="text" class="form-control" name="site_title" value="{{ $site_title }}" placeholder="Your Site Title">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Site Author</label>
                            <input type="text" class="form-control" name="site_author" value="{{ $site_author }}" placeholder="Author Name">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Site Description (Meta Description)</label>
                            <textarea class="form-control" name="site_description" rows="3" placeholder="Brief description of your site">{{ $site_description }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Site Keywords (Meta Keywords)</label>
                            <input type="text" class="form-control" name="site_keywords" value="{{ $site_keywords }}" placeholder="keyword1, keyword2, keyword3">
                        </div>
                        <div class="col-12">
                            <label class="form-label">
                                <i class="fas fa-bullhorn"></i>
                                Marquee Text (Announcement Bar)
                            </label>
                            <input type="text" class="form-control" name="marquee_text" value="{{ $marquee_text }}" placeholder="Enter announcement text for marquee">
                            <small class="text-muted">This text will appear as a scrolling announcement on your website</small>
                        </div>
                    </div>
                </div>

                <!-- Shipping Settings Card -->
                <div class="banner-card">
                    <div class="banner-header">
                        <i class="fas fa-shipping-fast"></i>
                        <h5>Shipping Settings</h5>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-money-bill-wave"></i>
                                Shipping Charges (PKR)
                            </label>
                            <input type="number" class="form-control" name="shipping_charges" value="{{ $shipping_charges }}" placeholder="150.00" step="0.01" min="0">
                            <small class="text-muted">Default shipping cost for all orders</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-gift"></i>
                                Free Shipping Threshold (PKR)
                            </label>
                            <input type="number" class="form-control" name="free_shipping_threshold" value="{{ $free_shipping_threshold }}" placeholder="5000.00" step="0.01" min="0">
                            <small class="text-muted">Orders above this amount get free shipping</small>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>How it works:</strong> 
                                Orders below PKR {{ number_format($free_shipping_threshold ?? 5000, 0) }} will be charged PKR {{ number_format($shipping_charges ?? 150, 0) }} for shipping. 
                                Orders equal to or above the threshold get free shipping automatically.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logo Settings Card -->
                <div class="banner-card">
                    <div class="banner-header">
                        <i class="fas fa-image"></i>
                        <h5>Logo Settings</h5>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Site Logo</label>
                            <input type="file" class="form-control" name="logo" accept="image/*">
                            <small class="text-muted">Recommended: PNG format, 200x60px, up to 8MB</small>
                        </div>
                        <div class="col-md-6">
                            @if($logo)
                            <div class="banner-preview">
                                <img src="{{ asset('storage/' . $logo) }}" alt="Current Logo" style="max-height: 60px; width: auto;">
                            </div>
                            @else
                            <div class="banner-preview" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; height: 60px; border: 1px dashed #ddd;">
                                <span class="text-muted">Current Logo: Default</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- CEO Image Settings Card -->
                <div class="banner-card">
                    <div class="banner-header">
                        <i class="fas fa-user-tie"></i>
                        <h5>CEO Image Settings</h5>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">CEO/Founder Photo</label>
                            <input type="file" class="form-control" name="ceo_image" accept="image/*" id="ceoImageInput">
                            <small class="text-muted">Recommended: Square format (1:1 ratio), 300x300px, up to 8MB</small>
                        </div>
                        <div class="col-md-6">
                            @if($ceo_image)
                            <div class="banner-preview">
                                <img src="{{ asset('storage/' . $ceo_image) }}" alt="Current CEO Image" id="ceoImagePreview" style="max-height: 100px; width: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary-lighter);">
                            </div>
                            @else
                            <div class="banner-preview" id="ceoImagePreview" style="background: var(--primary-lightest); display: flex; align-items: center; justify-content: center; height: 100px; width: 100px; border: 2px dashed var(--primary-lighter); border-radius: 50%; margin: auto;">
                                <i class="fas fa-user" style="font-size: 2rem; color: var(--primary-color);"></i>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Footer Settings Card -->
                <div class="banner-card">
                    <div class="banner-header">
                        <i class="fas fa-align-left"></i>
                        <h5>Footer Settings</h5>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Company Description</label>
                            <textarea class="form-control" name="footer_company_description" rows="3" placeholder="Your company description">{{ $footer_company_description }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Founder Name</label>
                            <input type="text" class="form-control" name="footer_founder_name" value="{{ $footer_founder_name }}" placeholder="Founder Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Founder Title</label>
                            <input type="text" class="form-control" name="footer_founder_title" value="{{ $footer_founder_title }}" placeholder="Founder & CEO">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="footer_address" value="{{ $footer_address }}" placeholder="Company Address">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="footer_phone" value="{{ $footer_phone }}" placeholder="+92 311 5904288">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="footer_email" value="{{ $footer_email }}" placeholder="info@company.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">WhatsApp Link</label>
                            <input type="url" class="form-control" name="footer_whatsapp" value="{{ $footer_whatsapp }}" placeholder="https://wa.me/923115904288">
                        </div>
                    </div>
                </div>

                <!-- Social Media Settings Card -->
                <div class="banner-card">
                    <div class="banner-header">
                        <i class="fab fa-facebook"></i>
                        <h5>Social Media Links</h5>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Facebook URL</label>
                            <input type="url" class="form-control" name="footer_facebook" value="{{ $footer_facebook }}" placeholder="https://facebook.com/yourpage">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Instagram URL</label>
                            <input type="url" class="form-control" name="footer_instagram" value="{{ $footer_instagram }}" placeholder="https://instagram.com/yourpage">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Twitter URL</label>
                            <input type="url" class="form-control" name="footer_twitter" value="{{ $footer_twitter }}" placeholder="https://twitter.com/yourpage">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Copyright Text</label>
                            <input type="text" class="form-control" name="footer_copyright" value="{{ $footer_copyright }}" placeholder="Copyright text">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="banner-card">
                    <div class="text-center">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-save"></i>
                            Update General Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add JavaScript for enhanced UX -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Custom file input handler with size validation
    const fileInputs = document.querySelectorAll('.custom-file-input');
    
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            const file = this.files[0];
            const label = this.nextElementSibling;
            const maxSize = 8 * 1024 * 1024; // 8MB in bytes
            
            if (file) {
                // Check file size
                if (file.size > maxSize) {
                    alert(`File size (${(file.size / 1024 / 1024).toFixed(2)}MB) exceeds the maximum allowed size of 8MB. Please choose a smaller image or compress it.`);
                    this.value = ''; // Clear the input
                    label.textContent = 'Choose file';
                    label.classList.remove('selected');
                    return;
                }
                
                // Update label with filename
                label.textContent = file.name;
                label.classList.add('selected');
                
                // Show file size info
                const sizeInfo = `(${(file.size / 1024 / 1024).toFixed(2)}MB)`;
                label.textContent = `${file.name} ${sizeInfo}`;
            } else {
                label.textContent = 'Choose file';
                label.classList.remove('selected');
            }
        });
    });
    
    // Form submission validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const fileInputs = this.querySelectorAll('.custom-file-input');
            const maxSize = 8 * 1024 * 1024; // 8MB in bytes
            let hasLargeFiles = false;
            
            fileInputs.forEach(function(input) {
                if (input.files[0] && input.files[0].size > maxSize) {
                    hasLargeFiles = true;
                }
            });
            
            if (hasLargeFiles) {
                e.preventDefault();
                alert('One or more files exceed the 8MB size limit. Please compress your images before uploading.');
                return false;
            }
        });
    }

    // Add file validation for general settings form
    const generalForm = document.getElementById('generalSettingsForm');
    if (generalForm) {
        generalForm.addEventListener('submit', function(e) {
            const logoInput = document.querySelector('input[name="logo"]');
            
            if (logoInput.files.length > 0) {
                const file = logoInput.files[0];
                const maxSize = 8 * 1024 * 1024; // 8MB
                
                if (file.size > maxSize) {
                    e.preventDefault();
                    alert('Logo file is too large. Please choose a file smaller than 8MB.');
                    return false;
                }
                
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];
                if (!allowedTypes.includes(file.type)) {
                    e.preventDefault();
                    alert('Invalid file type. Please choose a JPEG, PNG, JPG, GIF, or SVG file.');
                    return false;
                }
            }
        });
    }

    // Preview logo before upload
    const logoInput = document.querySelector('input[name="logo"]');
    if (logoInput) {
        logoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.querySelector('.banner-preview img');
                    if (preview) {
                        preview.src = e.target.result;
                        preview.style.maxHeight = '60px';
                        preview.style.width = 'auto';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Preview CEO image before upload
    const ceoImageInput = document.getElementById('ceoImageInput');
    if (ceoImageInput) {
        ceoImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('ceoImagePreview');
                    if (preview) {
                        preview.innerHTML = `<img src="${e.target.result}" alt="CEO Image Preview" style="max-height: 100px; width: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary-lighter);">`;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Image preview functionality for banner modals
    window.previewImage = function(input, previewId) {
        const preview = document.getElementById(previewId);
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    };
});
</script>

@endsection