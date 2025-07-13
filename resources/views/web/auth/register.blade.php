<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Us - Taysan & Co</title>
    
    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* CSS Variables */
        :root {
            --ts-primary: #8D68AD;
            --ts-primary-light: #A587C1;
            --ts-primary-dark: #735891;
            --ts-white: #ffffff;
            --ts-black: #333333;
            --ts-gray: #666666;
            --ts-light-gray: #f5f5f5;
            --ts-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            --ts-shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            overflow-x: hidden;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--ts-primary) 0%, var(--ts-primary-dark) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .animated-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, 
                rgba(255, 255, 255, 0.1) 0%, 
                transparent 50%, 
                rgba(255, 255, 255, 0.05) 100%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Main Container */
        .auth-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 900px;
            margin: 2rem;
        }

        .auth-card {
            background: var(--ts-white);
            border-radius: 20px;
            box-shadow: var(--ts-shadow);
            overflow: hidden;
            min-height: 600px;
        }

        /* Left Panel */
        .auth-left {
            background: linear-gradient(135deg, var(--ts-primary-light) 0%, var(--ts-primary) 50%, var(--ts-primary-dark) 100%);
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: var(--ts-white);
            position: relative;
            min-height: 600px;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="10" cy="50" r="1" fill="white" opacity="0.1"/><circle cx="90" cy="30" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .ts-logo {
            position: relative;
            z-index: 2;
            margin-bottom: 30px;
            text-decoration: none;
        }

        .ts-logo__img {
            height: 60px;
            width: auto;
            filter: brightness(0) invert(1);
        }

        .welcome-text {
            position: relative;
            z-index: 2;
        }

        .welcome-text h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .welcome-text p {
            font-size: 1rem;
            line-height: 1.6;
            opacity: 0.9;
            max-width: 350px;
        }

        /* Right Panel */
        .auth-right {
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 600px;
        }

        /* Multi-Step Progress */
        .step-progress {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            gap: 10px;
        }

        .step-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #e8ecf0;
            transition: all 0.3s ease;
            position: relative;
        }

        .step-indicator.active {
            background: var(--ts-primary);
            transform: scale(1.2);
        }

        .step-indicator.completed {
            background: #51cf66;
        }

        .step-connector {
            width: 30px;
            height: 2px;
            background: #e8ecf0;
            transition: all 0.3s ease;
        }

        .step-connector.completed {
            background: #51cf66;
        }

        .auth-form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-form-header h1 {
            color: var(--ts-black);
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .auth-form-header p {
            color: var(--ts-gray);
            font-size: 1rem;
        }

        .step-title {
            color: var(--ts-primary);
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 15px;
            text-align: center;
        }

        /* Form Styles */
        .form-step {
            display: none !important;
            opacity: 0;
            transform: translateX(30px);
            transition: all 0.4s ease;
        }

        .form-step.active {
            display: block !important;
            opacity: 1 !important;
            transform: translateX(0) !important;
        }

        /* Ensure first step is always visible by default on page load */
        .form-step[data-step="1"].active {
            display: block !important;
            opacity: 1 !important;
            transform: translateX(0) !important;
        }

        /* Fallback: Show first step even without active class */
        .form-step[data-step="1"]:first-of-type {
            display: block !important;
            opacity: 1 !important;
            transform: translateX(0) !important;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            height: 45px;
            border: 2px solid #e8ecf0;
            border-radius: 10px;
            padding: 0 15px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: #fafbfc;
        }

        .form-control-sm {
            height: 40px;
            padding: 0 12px;
            font-size: 0.85rem;
        }

        .form-control:focus {
            border-color: var(--ts-primary);
            box-shadow: 0 0 0 3px rgba(141, 104, 173, 0.1);
            background: var(--ts-white);
        }

        .form-control::placeholder {
            color: #a8b2b8;
        }

        .form-control select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
        }

        /* Custom Checkbox Styles */
        .custom-control {
            position: relative;
            display: block;
            min-height: 1.5rem;
            padding-left: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .custom-control-input {
            position: absolute;
            left: 0;
            z-index: -1;
            width: 1rem;
            height: 1.25rem;
            opacity: 0;
        }

        .custom-control-label {
            position: relative;
            margin-bottom: 0;
            color: var(--ts-gray);
            font-size: 0.9rem;
            line-height: 1.5;
            cursor: pointer;
        }

        .custom-control-label::before {
            position: absolute;
            top: 0.25rem;
            left: -1.5rem;
            display: block;
            width: 1rem;
            height: 1rem;
            background-color: #fff;
            border: 2px solid #e8ecf0;
            border-radius: 0.25rem;
            content: "";
            transition: all 0.3s ease;
        }

        .custom-control-input:checked ~ .custom-control-label::before {
            color: #fff;
            border-color: var(--ts-primary);
            background-color: var(--ts-primary);
        }

        .custom-control-input:checked ~ .custom-control-label::after {
            position: absolute;
            top: 0.25rem;
            left: -1.5rem;
            display: block;
            width: 1rem;
            height: 1rem;
            content: "";
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3e%3cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M5 13l4 4L19 7'%3e%3c/path%3e%3c/svg%3e");
            background-size: 0.75rem;
            background-position: center;
            background-repeat: no-repeat;
        }

        .custom-control-label a {
            color: var(--ts-primary);
            text-decoration: none;
            font-weight: 500;
        }

        .custom-control-label a:hover {
            color: var(--ts-primary-dark);
            text-decoration: underline;
        }

        .password-field {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--ts-gray);
            cursor: pointer;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--ts-primary);
        }

        /* Password Strength Styles */
        .password-strength {
            margin-top: 8px;
        }

        .strength-meter {
            height: 4px;
            background-color: #e0e0e0;
            border-radius: 2px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease, background-color 0.3s ease;
            border-radius: 2px;
        }

        .strength-bar.weak {
            background-color: #dc3545;
            width: 25%;
        }

        .strength-bar.fair {
            background-color: #fd7e14;
            width: 50%;
        }

        .strength-bar.good {
            background-color: #ffc107;
            width: 75%;
        }

        .strength-bar.strong {
            background-color: #28a745;
            width: 100%;
        }

        .strength-text {
            font-weight: 500;
            margin-top: 4px;
        }

        .strength-text.weak {
            color: #dc3545;
        }

        .strength-text.fair {
            color: #fd7e14;
        }

        .strength-text.good {
            color: #ffc107;
        }

        .strength-text.strong {
            color: #28a745;
        }

        .password-requirements {
            margin-top: 8px;
        }

        .requirement {
            font-size: 0.75rem;
            margin-bottom: 2px;
            transition: color 0.3s ease;
        }

        .requirement.met i {
            color: #28a745 !important;
        }

        .requirement.met i:before {
            content: "\f00c";
        }

        .password-toggle:hover {
            color: var(--ts-primary);
        }

        /* Button Styles */
        .btn-navigation {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-primary, .btn-secondary {
            flex: 1;
            height: 42px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--ts-primary) 0%, var(--ts-primary-dark) 100%);
            color: var(--ts-white);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--ts-shadow-hover);
        }

        .btn-primary:disabled {
            background: #cccccc !important;
            cursor: not-allowed !important;
            transform: none !important;
            box-shadow: none !important;
            opacity: 0.5 !important;
            pointer-events: auto; /* Allow clicks for feedback */
        }

        /* Shake animation for invalid form submission */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .btn-secondary {
            background: #f8f9fa;
            color: var(--ts-gray);
            border: 2px solid #e8ecf0;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            color: var(--ts-black);
        }

        .btn-primary.loading {
            pointer-events: none;
        }

        .auth-links {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e8ecf0;
        }

        .auth-links a {
            color: var(--ts-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .auth-links a:hover {
            color: var(--ts-primary-dark);
            text-decoration: none;
        }

        /* Alert Styles */
        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
        }

        .alert-success {
            background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 991.98px) {
            .auth-left {
                min-height: 300px;
                padding: 30px 20px;
            }

            .auth-right {
                padding: 30px 20px;
            }

            .welcome-text h2 {
                font-size: 1.6rem;
                margin-bottom: 15px;
            }

            .welcome-text p {
                font-size: 0.9rem;
                max-width: 100%;
                line-height: 1.5;
            }

            .auth-form-header h1 {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 575.98px) {
            .auth-container {
                margin: 1rem;
            }

            .auth-card {
                border-radius: 15px;
            }

            .auth-left,
            .auth-right {
                padding: 20px 15px;
            }

            .welcome-text h2 {
                font-size: 1.4rem;
            }

            .auth-form-header h1 {
                font-size: 1.6rem;
            }

            .form-control,
            .btn-primary,
            .btn-secondary {
                height: 50px;
            }

            .btn-navigation {
                flex-direction: column;
            }

            .step-progress {
                gap: 5px;
            }

            .step-connector {
                width: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg"></div>

    <!-- Main Container -->
    <div class="auth-container">
        <div class="auth-card">
            <div class="row no-gutters h-100">
                <!-- Left Panel -->
                <div class="col-lg-6">
                    <div class="auth-left">
                        <!-- Logo -->
                        <a href="{{ route('web.view.index') }}" class="ts-logo">
                            <img src="{{ asset('logo.png') }}" alt="Taysan & Co" class="ts-logo__img">
                        </a>

                        <!-- Welcome Text -->
                        <div class="welcome-text">
                            <h2>Join Our Beauty Community!</h2>
                            <p>Create your account and unlock exclusive access to premium beauty products, personalized recommendations, and member-only benefits.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Panel -->
                <div class="col-lg-6">
                    <div class="auth-right">
                        <!-- Step Progress -->
                        <div class="step-progress">
                            <div class="step-indicator active" data-step="1"></div>
                            <div class="step-connector"></div>
                            <div class="step-indicator" data-step="2"></div>
                        </div>

                        <div class="auth-form-header">
                            <h1>Create Account</h1>
                            <p>Join thousands of beauty enthusiasts</p>
                        </div>

                        <form action="{{ route('web.user.register') }}" method="POST" id="registerForm">
                            @csrf
                            
                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0 list-unstyled">
                                        @foreach ($errors->all() as $error)
                                            <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Success Messages -->
                            @if (session('success'))
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                </div>
                            @endif

                            <!-- Step 1: Basic Information -->
                            <div class="form-step active" data-step="1">
                                <div class="step-title">
                                    <i class="fas fa-user me-2"></i>Basic Information
                                </div>
                                
                                <div class="form-group">
                                    <input 
                                        class="form-control form-control-sm @error('name') is-invalid @enderror" 
                                        placeholder="Full Name" 
                                        type="text" 
                                        name="name" 
                                        id="name"
                                        value="{{ old('name') }}" 
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input 
                                        class="form-control form-control-sm @error('email') is-invalid @enderror" 
                                        placeholder="Email Address (Gmail recommended)" 
                                        type="email" 
                                        name="email" 
                                        id="email"
                                        value="{{ old('email') }}" 
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="password-field">
                                        <input 
                                            class="form-control form-control-sm @error('password') is-invalid @enderror" 
                                            placeholder="Password (8+ characters)" 
                                            type="password" 
                                            name="password" 
                                            id="password" 
                                            required
                                            oninput="checkPasswordStrength()">
                                        <span class="password-toggle small" onclick="togglePassword('password')">
                                            <i class="fas fa-eye" id="password-icon"></i>
                                        </span>
                                    </div>
                                    
                                    <!-- Password Strength Indicator -->
                                    <div class="password-strength mt-2" id="passwordStrength" style="display: none;">
                                        <div class="strength-meter">
                                            <div class="strength-bar" id="strengthBar"></div>
                                        </div>
                                        <div class="strength-text small mt-1" id="strengthText"></div>
                                        <div class="password-requirements small mt-1">
                                            <div class="requirement" id="req-length">
                                                <i class="fas fa-times text-danger"></i> At least 8 characters
                                            </div>
                                            <div class="requirement" id="req-uppercase">
                                                <i class="fas fa-times text-danger"></i> One uppercase letter
                                            </div>
                                            <div class="requirement" id="req-lowercase">
                                                <i class="fas fa-times text-danger"></i> One lowercase letter
                                            </div>
                                            <div class="requirement" id="req-number">
                                                <i class="fas fa-times text-danger"></i> One number
                                            </div>
                                            <div class="requirement" id="req-special">
                                                <i class="fas fa-times text-danger"></i> One special character
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @error('password')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input 
                                        class="form-control form-control-sm" 
                                        placeholder="Confirm Password" 
                                        type="password" 
                                        name="password_confirmation" 
                                        id="password_confirmation" 
                                        required>
                                    <div class="invalid-feedback small" id="password-match-error" style="display: none;">
                                        Passwords do not match
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Personal Details -->
                            <div class="form-step" data-step="2">
                                <div class="step-title">
                                    <i class="fas fa-id-card me-2"></i>Personal Details
                                </div>
                                
                                <div class="form-group">
                                    <input 
                                        class="form-control form-control-sm @error('phone') is-invalid @enderror" 
                                        placeholder="Phone Number" 
                                        type="tel" 
                                        name="phone" 
                                        id="phone"
                                        value="{{ old('phone') }}" 
                                        required>
                                    @error('phone')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <select 
                                        class="form-control form-control-sm @error('gender') is-invalid @enderror" 
                                        name="gender" 
                                        id="gender" 
                                        required>
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input 
                                        class="form-control form-control-sm @error('date_of_birth') is-invalid @enderror" 
                                        placeholder="Date of Birth" 
                                        type="date" 
                                        name="date_of_birth" 
                                        id="date_of_birth"
                                        value="{{ old('date_of_birth') }}" 
                                        max="{{ date('Y-m-d', strtotime('-13 years')) }}"
                                        required>
                                    @error('date_of_birth')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            name="terms" 
                                            id="terms" 
                                            value="1" 
                                            required 
                                            {{ old('terms') ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="terms">
                                            I agree to the <a href="#" target="_blank">Terms & Conditions</a>
                                        </label>
                                    </div>
                                    @error('terms')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="btn-navigation">
                                <button type="button" class="btn-secondary" id="prevBtn" style="display: none;">
                                    <i class="fas fa-arrow-left me-2"></i>Previous
                                </button>
                                <button type="button" class="btn-primary" id="nextBtn">
                                    Next<i class="fas fa-arrow-right ms-2"></i>
                                </button>
                                <button type="submit" class="btn-primary" id="submitBtn" style="display: none;">
                                    <i class="fas fa-user-plus me-2"></i>Create Account
                                </button>
                            </div>

                            <!-- Auth Links -->
                            <div class="auth-links">
                                <p class="mb-0">
                                    Already have an account? <a href="{{ route('web.user.login.form') }}">Sign in</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== REGISTRATION FORM SCRIPT LOADED ===');
            
            let currentStep = 1;
            const totalSteps = 2;
            
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const form = document.getElementById('registerForm');
            
            if (!nextBtn) {
                console.error('Next button not found!');
                return;
            }
            
            console.log('Form elements found, initializing...');
            
            // Define all functions first
            function showStep(step) {
                console.log('=== SHOWING STEP ===', step);
                
                // Get all form steps
                const allSteps = document.querySelectorAll('.form-step');
                console.log('Found', allSteps.length, 'form steps');
                
                // Hide all steps first
                allSteps.forEach(function(stepEl, index) {
                    const stepNumber = stepEl.getAttribute('data-step');
                    console.log('Processing step element', index, 'with data-step:', stepNumber);
                    
                    stepEl.style.display = 'none';
                    stepEl.classList.remove('active');
                    console.log('Hidden step', stepNumber);
                });
                
                // Find and show target step
                const targetStep = document.querySelector('.form-step[data-step="' + step + '"]');
                console.log('Target step element:', targetStep);
                
                if (targetStep) {
                    targetStep.style.display = 'block';
                    targetStep.style.opacity = '1';
                    targetStep.style.transform = 'translateX(0)';
                    targetStep.classList.add('active');
                    console.log('✓ Step', step, 'is now visible and active');
                } else {
                    console.error('✗ Could not find step element for step:', step);
                    console.log('Available steps:', Array.from(document.querySelectorAll('.form-step')).map(el => el.getAttribute('data-step')));
                }
                
                // Update step indicators
                const indicators = document.querySelectorAll('.step-indicator');
                console.log('Found', indicators.length, 'step indicators');
                
                indicators.forEach(function(indicator, index) {
                    indicator.classList.remove('active', 'completed');
                    const stepNum = index + 1;
                    if (stepNum < step) {
                        indicator.classList.add('completed');
                    } else if (stepNum === step) {
                        indicator.classList.add('active');
                    }
                });
                
                // Update button visibility
                if (prevBtn) {
                    prevBtn.style.display = step === 1 ? 'none' : 'block';
                }
                
                console.log('=== STEP SHOWING COMPLETE ===');
            }
            
            function updateButtonText() {
                if (currentStep === totalSteps) {
                    nextBtn.innerHTML = '<i class="fas fa-user-plus me-2"></i>Create Account';
                } else {
                    nextBtn.innerHTML = 'Next<i class="fas fa-arrow-right ms-2"></i>';
                }
                console.log('Button text updated for step', currentStep, ':', nextBtn.innerHTML);
            }
            
            // Validation function
            function validateCurrentStep() {
                let isValid = true;
                
                if (currentStep === 1) {
                    // Validate Step 1: Basic Information
                    const name = document.getElementById('name');
                    const email = document.getElementById('email');
                    const password = document.getElementById('password');
                    const passwordConfirmation = document.getElementById('password_confirmation');
                    
                    isValid = validateField(name, 'Full name is required') && isValid;
                    isValid = validateField(email, 'Email address is required') && isValid;
                    isValid = validateField(password, 'Password is required') && isValid;
                    isValid = validateField(passwordConfirmation, 'Password confirmation is required') && isValid;
                    
                    // Check password match
                    if (password && passwordConfirmation && password.value !== passwordConfirmation.value) {
                        showFieldError(passwordConfirmation, 'Passwords do not match');
                        isValid = false;
                    }
                    
                } else if (currentStep === 2) {
                    // Validate Step 2: Personal Details
                    const phone = document.getElementById('phone');
                    const gender = document.getElementById('gender');
                    const dateOfBirth = document.getElementById('date_of_birth');
                    const terms = document.getElementById('terms');
                    
                    isValid = validateField(phone, 'Phone number is required') && isValid;
                    isValid = validateField(gender, 'Please select your gender') && isValid;
                    isValid = validateField(dateOfBirth, 'Date of birth is required') && isValid;
                    
                    // Check terms checkbox
                    if (!terms || !terms.checked) {
                        showFieldError(terms, 'You must accept the Terms of Service and Privacy Policy');
                        isValid = false;
                    } else {
                        clearFieldError(terms);
                    }
                }
                
                return isValid;
            }
            
            // Helper function to validate individual fields
            function validateField(field, errorMessage) {
                if (!field || !field.value.trim()) {
                    showFieldError(field, errorMessage);
                    return false;
                } else {
                    clearFieldError(field);
                    return true;
                }
            }
            
            // Show field error
            function showFieldError(field, message) {
                if (!field) return;
                
                field.classList.add('is-invalid');
                
                // Find or create error message element
                let errorElement = field.parentNode.querySelector('.invalid-feedback');
                if (!errorElement) {
                    errorElement = document.createElement('div');
                    errorElement.className = 'invalid-feedback';
                    field.parentNode.appendChild(errorElement);
                }
                
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }
            
            // Clear field error
            function clearFieldError(field) {
                if (!field) return;
                
                field.classList.remove('is-invalid');
                const errorElement = field.parentNode.querySelector('.invalid-feedback');
                if (errorElement) {
                    errorElement.style.display = 'none';
                }
            }
            
            // Now initialize the form
            console.log('Initializing with step:', currentStep);
            
            // Update button text and show current step
            updateButtonText();
            showStep(currentStep);
            
            // Add click handler for next button
            nextBtn.onclick = function(e) {
                e.preventDefault();
                console.log('Button clicked! Current step:', currentStep);
                
                // Validate current step before proceeding
                if (!validateCurrentStep()) {
                    console.log('Validation failed, staying on step', currentStep);
                    return; // Stop if validation fails
                }
                
                if (currentStep < totalSteps) {
                    // Move to next step
                    currentStep++;
                    console.log('Moving to step:', currentStep);
                    showStep(currentStep);
                    updateButtonText();
                } else {
                    // Submit form
                    console.log('Submitting form...');
                    if (form) {
                        form.submit();
                    }
                }
            };
            
            // Previous button handler
            if (prevBtn) {
                prevBtn.onclick = function(e) {
                    e.preventDefault();
                    if (currentStep > 1) {
                        currentStep--;
                        showStep(currentStep);
                        updateButtonText();
                    }
                };
            }
            
            // Clear all errors when user starts typing
            document.querySelectorAll('input, select').forEach(input => {
                input.addEventListener('input', function() {
                    clearFieldError(this);
                });
            });
            
            console.log('Registration form initialized successfully!');
        });
    </script>
</body>
</html>
