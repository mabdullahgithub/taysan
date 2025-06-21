@extends('web.layout.app')
@section('content')

<style>
    /* Floating Cart Button Styles */
    .ts-floating-cart-btn {
        position: fixed;
        bottom: 30px;
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
        --primary-color: #8D68AD;
        --primary-light: #A67BC9;
        --primary-dark: #6B4E84;
        --text-color: #333;
        --border-color: #ddd;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --success-color: #28a745;
        --danger-color: #dc3545;
    }

    /* Banner Styles */
    .contact-page-banner {
        position: relative;
        padding: 120px 0 80px;
        background-color: #f5f5f5;
        margin-top: 130px;
        z-index: 1;
        min-height: 300px;
        display: flex;
        align-items: center;
    }

    .contact-banner-content {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        padding: 0 15px;
        position: relative;
        z-index: 2;
    }

    .contact-banner-title {
        font-size: 48px;
        color: #fff;
        margin-bottom: 15px;
        font-weight: 700;
        text-transform: capitalize;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .contact-banner-breadcrumb {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .contact-banner-breadcrumb li {
        color: #fff;
        font-size: 16px;
        position: relative;
    }

    .contact-banner-breadcrumb li a {
        color: #fff;
        text-decoration: none;
    }

    .contact-banner-breadcrumb li:not(:last-child)::after {
        content: "/";
        margin-left: 10px;
        color: #fff;
    }

    /* Contact Section */
    .contact-section {
        padding: 80px 0;
        background: #f9f9f9;
    }

    .office-info {
        background: white;
        border-radius: 15px;
        padding: 40px;
        margin-bottom: 50px;
        box-shadow: var(--shadow);
    }

    .office-info-item {
        text-align: center;
        padding: 30px 20px;
        margin-bottom: 30px;
        background: #fff;
        border-radius: 12px;
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        height: 100%;
    }

    .office-info-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(141, 104, 173, 0.15);
        border-color: var(--primary-color);
    }

    .office-info-icon {
        margin-bottom: 20px;
    }

    .office-info-icon .icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: white;
        font-size: 30px;
    }

    .office-info-text h2 {
        color: var(--primary-color);
        font-size: 22px;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .office-info-text p {
        color: var(--text-color);
        margin-bottom: 5px;
        font-size: 16px;
    }

    /* Contact Form */
    .contact-title {
        text-align: center;
        margin-bottom: 40px;
    }

    .contact-title h2 {
        font-size: 36px;
        color: var(--primary-color);
        margin-bottom: 15px;
        font-weight: 700;
    }

    .contact-title p {
        font-size: 16px;
        color: var(--text-color);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .contact-form-area {
        background: white;
        padding: 50px;
        border-radius: 15px;
        box-shadow: var(--shadow);
    }

    .contact-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    .contact-form .fullwidth {
        grid-column: 1 / -1;
    }

    .form-control {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: #fff;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(141, 104, 173, 0.1);
    }

    .form-control.is-invalid {
        border-color: var(--danger-color);
    }

    .invalid-feedback {
        color: var(--danger-color);
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }

    .submit-area {
        text-align: center;
        margin-top: 30px;
    }

    .theme-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
        padding: 15px 40px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .theme-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(141, 104, 173, 0.3);
    }

    .theme-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    /* Map Section */
    .contact-map-section {
        padding: 0;
        margin-top: 0;
    }

    .contact-map {
        height: 450px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--shadow);
        margin: 40px 0;
    }

    .contact-map iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }

    /* Alert Styles */
    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: none;
    }

    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        color: var(--success-color);
        border-left: 4px solid var(--success-color);
    }

    .alert-danger {
        background: rgba(220, 53, 69, 0.1);
        color: var(--danger-color);
        border-left: 4px solid var(--danger-color);
    }

    /* Loading Spinner */
    .spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
        margin-left: 10px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .contact-form {
            grid-template-columns: 1fr;
        }
        
        .contact-form-area {
            padding: 30px;
        }
        
        .office-info {
            padding: 30px 20px;
        }
    }

    @media (max-width: 768px) {
        .contact-page-banner {
            padding: 80px 0 60px;
            margin-top: 0px; /* Remove margin since navbar already has padding-top */
            min-height: 250px;
        }
        
        .contact-banner-title {
            font-size: 36px;
        }
        
        .contact-title h2 {
            font-size: 28px;
        }
        
        .office-info-item {
            margin-bottom: 20px;
        }
        
        .contact-form-area {
            padding: 25px 20px;
        }
        
        .contact-map {
            height: 300px;
            margin: 20px 0;
        }
    }

    @media (max-width: 480px) {
        .contact-banner-title {
            font-size: 28px;
        }
        
        .contact-title h2 {
            font-size: 24px;
        }
        
        .office-info {
            padding: 20px 15px;
        }
        
        .contact-form-area {
            padding: 20px 15px;
        }
    }
</style>

<!-- Contact Banner -->
@if(isset($contactBanner) && $contactBanner->image)
<section class="contact-page-banner" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('storage/'.$contactBanner->image) }}') no-repeat center center/cover;">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="contact-banner-content">
                    <h2 class="contact-banner-title">{{ $contactBanner->title ?? 'Contact Us' }}</h2>
                    <ol class="contact-banner-breadcrumb">
                        <li><a href="{{ url('/') }}">{{ $contactBanner->subtitle ?? 'Home' }}</a></li>
                        <li>Contact</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
@else
<section class="contact-page-banner" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-light));">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="contact-banner-content">
                    <h2 class="contact-banner-title">Contact Us</h2>
                    <ol class="contact-banner-breadcrumb">
                        <li><a href="/">Home</a></li>
                        <li>Contact</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col col-lg-10 offset-lg-1">
                
                <!-- Office Info -->
                <div class="office-info">
                    <div class="row">
                        <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                            <div class="office-info-item">
                                <div class="office-info-icon">
                                    <div class="icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                </div>
                                <div class="office-info-text">
                                    <h2>Our Address</h2>
                                    <p>Lahore, Pakistan</p>
                                    {{-- <p>Crawfordsville, IN 47933</p> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                            <div class="office-info-item">
                                <div class="office-info-icon">
                                    <div class="icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                                <div class="office-info-text">
                                    <h2>Email Us</h2>
                                    <p>info@taysan.com</p>
                                    {{-- <p>support@taysan.com</p> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                            <div class="office-info-item">
                                <div class="office-info-icon">
                                    <div class="icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                </div>
                                <div class="office-info-text">
                                    <h2>Call Now</h2>
                                    <p> +92 3117317930</p>
                                    {{-- <p>+1 800 123 654 987</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Title -->
                <div class="contact-title">
                    <h2>Have Any Question?</h2>
                    <p>We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> Please fix the following errors:
                        <ul style="margin: 10px 0 0 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Contact Form -->
                <div class="contact-form-area">
                    <form method="POST" action="{{ route('web.contact.submit') }}" class="contact-form" id="contactForm">
                        @csrf
                        <div>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   name="name" 
                                   id="name"
                                   placeholder="Your Name*" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   id="email"
                                   placeholder="Your Email*" 
                                   value="{{ old('email') }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div>
                            <input type="text" 
                                   class="form-control @error('address') is-invalid @enderror" 
                                   name="address" 
                                   id="address"
                                   placeholder="Your Address" 
                                   value="{{ old('address') }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div>
                            <select name="service" class="form-control @error('service') is-invalid @enderror">
                                <option value="">Select Service</option>
                                <option value="General Inquiry" {{ old('service') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                <option value="Product Support" {{ old('service') == 'Product Support' ? 'selected' : '' }}>Product Support</option>
                                <option value="Custom Order" {{ old('service') == 'Custom Order' ? 'selected' : '' }}>Custom Order</option>
                                {{-- <option value="Partnership" {{ old('service') == 'Partnership' ? 'selected' : '' }}>Partnership</option> --}}
                            </select>
                            @error('service')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="fullwidth">
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      name="message" 
                                      id="message"
                                      placeholder="Your Message*" 
                                      rows="6" 
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="submit-area fullwidth">
                            <button type="submit" class="theme-btn" id="submitBtn">
                                <span id="submitText">Send Message</span>
                                <span id="submitSpinner" style="display: none;">
                                    Sending <span class="spinner"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Map -->
<section class="contact-map-section">
    <div class="container">
        <div class="contact-map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.9147703055!2d-74.11976314309273!3d40.69740344223377!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2sbd!4v1547528325671"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');

    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitText.style.display = 'none';
        submitSpinner.style.display = 'inline';
    });
});
</script>

@endsection