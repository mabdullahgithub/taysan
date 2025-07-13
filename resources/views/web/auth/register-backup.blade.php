<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Us - Taysan & Co</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --ts-primary: #8D68AD;
            --ts-primary-light: #A587C1;
            --ts-primary-dark: #735891;
            --ts-white: #ffffff;
            --ts-black: #333333;
            --ts-gray: #666666;
            --ts-light-gray: #f5f5f5;
        }

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
            flex-direction: column;
        }

        /* Enhanced Animated Background */
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
            background: 
                radial-gradient(circle at 20% 80%, rgba(255,255,255,0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255,255,255,0.08) 0%, transparent 50%);
            animation: float 25s ease-in-out infinite;
        }

        .animated-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.02) 50%, transparent 70%),
                linear-gradient(-45deg, transparent 30%, rgba(255,255,255,0.02) 50%, transparent 70%);
            animation: shimmer 15s ease-in-out infinite alternate;
        }

        @keyframes float {
            0%, 100% { transform: rotate(0deg) translateY(0px); }
            33% { transform: rotate(120deg) translateY(-15px); }
            66% { transform: rotate(240deg) translateY(-10px); }
        }

        @keyframes shimmer {
            0% { opacity: 0.3; }
            100% { opacity: 0.6; }
        }

        .login-container {
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            min-height: 100vh;
        }

        .login-card {
            background: var(--ts-white);
            border-radius: 24px;
            box-shadow: 
                0 25px 80px rgba(0, 0, 0, 0.15),
                0 10px 40px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            overflow: hidden;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            width: 100%;
            max-width: 1000px;
            transform: translateZ(0);
            margin: 0 auto;
        }

        .login-left {
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

        .login-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.4;
        }

        .ts-logo {
            position: relative;
            z-index: 2;
            margin-bottom: 40px;
        }

        .ts-logo__img {
            max-width: 180px;
            height: auto;
            filter: brightness(0) invert(1);
            transition: all 0.4s ease;
            transform: scale(1);
        }

        .ts-logo:hover .ts-logo__img {
            transform: scale(1.08);
            filter: brightness(0) invert(1) drop-shadow(0 0 20px rgba(255,255,255,0.3));
        }

        .welcome-text {
            position: relative;
            z-index: 2;
        }

        .welcome-text h2 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 4px 8px rgba(0,0,0,0.2);
            line-height: 1.2;
        }

        .welcome-text p {
            font-size: 1.2rem;
            opacity: 0.95;
            line-height: 1.7;
            max-width: 320px;
            margin-bottom: 30px;
        }

        .benefits-list {
            position: relative;
            z-index: 2;
            text-align: left;
            max-width: 300px;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .benefit-item i {
            color: #FFD700;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .login-right {
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .login-form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-form-header h1 {
            color: var(--ts-black);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .login-form-header p {
            color: var(--ts-gray);
            font-size: 1.1rem;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .form-section-title {
            color: var(--ts-primary);
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .form-section-title i {
            margin-right: 8px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .form-control {
            border: 2px solid #e8ecf0;
            border-radius: 16px;
            padding: 18px 24px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: var(--ts-light-gray);
            height: auto;
        }

        .form-control:focus {
            border-color: var(--ts-primary);
            box-shadow: 0 0 0 0.25rem rgba(141, 104, 173, 0.25);
            background: var(--ts-white);
            transform: translateY(-2px);
        }

        .input-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--ts-gray);
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s ease;
            z-index: 3;
            padding: 8px;
            border-radius: 50%;
        }

        .password-toggle:hover {
            color: var(--ts-primary);
            background: rgba(141, 104, 173, 0.1);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--ts-primary) 0%, var(--ts-primary-dark) 100%);
            border: none;
            border-radius: 16px;
            padding: 18px 40px;
            font-size: 17px;
            font-weight: 600;
            color: var(--ts-white);
            width: 100%;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(141, 104, 173, 0.3);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(141, 104, 173, 0.5);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .alert {
            border-radius: 16px;
            border: none;
            padding: 18px 24px;
            margin-bottom: 30px;
        }

        .alert-danger {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .alert-success {
            background: linear-gradient(135deg, #51cf66, #40c057);
            color: white;
            box-shadow: 0 4px 15px rgba(81, 207, 102, 0.3);
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .form-check {
            margin-bottom: 25px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .form-check-input {
            margin-top: 0.3rem;
            transform: scale(1.2);
        }

        .form-check-label {
            color: var(--ts-gray);
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .form-check-label a {
            color: var(--ts-primary);
            text-decoration: none;
        }

        .form-check-label a:hover {
            text-decoration: underline;
        }

        .auth-links {
            text-align: center;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e8ecf0;
        }

        .auth-links a {
            color: var(--ts-primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .auth-links a:hover {
            color: var(--ts-primary-dark);
            text-decoration: underline;
        }

        .optional-section {
            background: #f8f9ff;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            border: 2px dashed #e0e6ff;
        }

        .optional-section .form-section-title {
            color: var(--ts-gray);
            margin-bottom: 15px;
        }

        /* Enhanced Floating Elements */
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .floating-element {
            position: absolute;
            opacity: 0.15;
            animation: float-element 25s linear infinite;
        }

        .floating-element:nth-child(1) {
            top: 15%;
            left: 15%;
            animation-delay: 0s;
            font-size: 35px;
        }

        .floating-element:nth-child(2) {
            top: 65%;
            right: 15%;
            animation-delay: 8s;
            font-size: 28px;
        }

        .floating-element:nth-child(3) {
            bottom: 25%;
            left: 25%;
            animation-delay: 16s;
            font-size: 22px;
        }

        @keyframes float-element {
            0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
            25% { transform: translateY(-15px) rotate(90deg) scale(1.1); }
            50% { transform: translateY(-25px) rotate(180deg) scale(0.9); }
            75% { transform: translateY(-15px) rotate(270deg) scale(1.1); }
        }

        /* Responsive Design - Mobile First Approach */
        
        /* Extra Small devices (portrait phones, less than 576px) */
        @media (max-width: 575.98px) {
            .login-container {
                padding: 15px;
                min-height: 100vh;
            }

            .login-card {
                border-radius: 16px;
                max-width: 100%;
            }

            .login-left {
                min-height: 300px;
                padding: 30px 20px;
            }

            .login-right {
                padding: 30px 20px;
                min-height: auto;
                max-height: none;
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

            .login-form-header h1 {
                font-size: 1.5rem;
            }

            .login-form-header p {
                font-size: 0.95rem;
            }

            .login-form-header {
                margin-bottom: 30px;
            }

            .ts-logo__img {
                max-width: 100px;
            }

            .form-control {
                padding: 12px 16px;
                font-size: 15px;
                border-radius: 12px;
            }

            .btn-login {
                padding: 12px 20px;
                font-size: 15px;
                border-radius: 12px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .password-toggle {
                right: 12px;
                font-size: 16px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .form-row .form-group {
                margin-bottom: 20px;
            }

            .benefits-list {
                max-width: 100%;
            }

            .benefit-item {
                font-size: 0.9rem;
            }
        }

        /* Medium and larger devices */
        @media (min-width: 768px) {
            .login-card:hover {
                transform: translateY(-5px);
                box-shadow: 
                    0 35px 100px rgba(0, 0, 0, 0.2),
                    0 15px 50px rgba(0, 0, 0, 0.15),
                    inset 0 1px 0 rgba(255, 255, 255, 0.9);
                transition: all 0.4s ease;
            }
        }
    </style>
</head>
<body>
    <!-- Enhanced Animated Background -->
    <div class="animated-bg"></div>

    <!-- Register Container -->
    <div class="login-container">
        <div class="login-card">
            <div class="row no-gutters">
                <!-- Left Side -->
                <div class="col-lg-6">
                    <div class="login-left">
                        <!-- Enhanced Floating Elements -->
                        <div class="floating-elements">
                            <div class="floating-element">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="floating-element">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="floating-element">
                                <i class="fas fa-sparkles"></i>
                            </div>
                        </div>

                        <!-- Logo -->
                        <a href="{{ route('web.view.index') }}" class="ts-logo">
                            <img src="{{ asset('logo.png') }}" alt="Taysan & Co" class="ts-logo__img">
                        </a>

                        <!-- Welcome Text -->
                        <div class="welcome-text">
                            <h2>Join Our Beauty Community</h2>
                            <p>Become a member and unlock exclusive benefits, special offers, and personalized beauty recommendations.</p>
                        </div>

                        <!-- Benefits List -->
                        <div class="benefits-list">
                            <div class="benefit-item">
                                <i class="fas fa-percentage"></i>
                                <span>Exclusive Member Discounts</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-heart"></i>
                                <span>Personalized Recommendations</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-gift"></i>
                                <span>Birthday Surprises</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-shipping-fast"></i>
                                <span>Priority Shipping</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="col-lg-6">
                    <div class="login-right">
                        <div class="login-form-header">
                            <h1>Create Account</h1>
                            <p>Start your beauty journey with us</p>
                        </div>

                        <form action="{{ route('web.user.register') }}" method="POST" id="registerForm">
                            @csrf
                            
                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Success Messages -->
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <!-- Basic Information Section -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="fas fa-user"></i>
                                    Basic Information
                                </div>

                                <!-- Name Field -->
                                <div class="form-group">
                                    <input 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        placeholder="Full Name *" 
                                        type="text" 
                                        name="name" 
                                        id="name"
                                        value="{{ old('name') }}"
                                        required
                                    >
                                </div>

                                <!-- Email Field -->
                                <div class="form-group">
                                    <input 
                                        class="form-control @error('email') is-invalid @enderror" 
                                        placeholder="Email Address *" 
                                        type="email" 
                                        name="email" 
                                        id="email"
                                        value="{{ old('email') }}"
                                        required
                                    >
                                </div>

                                <!-- Phone Field -->
                                <div class="form-group">
                                    <input 
                                        class="form-control @error('phone') is-invalid @enderror" 
                                        placeholder="Phone Number" 
                                        type="tel" 
                                        name="phone" 
                                        id="phone"
                                        value="{{ old('phone') }}"
                                    >
                                </div>

                                <!-- Password Fields -->
                                <div class="form-row">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input 
                                                class="form-control @error('password') is-invalid @enderror" 
                                                placeholder="Password *" 
                                                type="password" 
                                                name="password" 
                                                id="password"
                                                required
                                            >
                                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                                <i class="fas fa-eye" id="passwordIcon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input 
                                                class="form-control" 
                                                placeholder="Confirm Password *" 
                                                type="password" 
                                                name="password_confirmation" 
                                                id="password_confirmation"
                                                required
                                            >
                                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                                <i class="fas fa-eye" id="password_confirmationIcon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Optional Information Section -->
                            <div class="optional-section">
                                <div class="form-section-title">
                                    <i class="fas fa-info-circle"></i>
                                    Additional Information (Optional)
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <input 
                                            class="form-control @error('date_of_birth') is-invalid @enderror" 
                                            type="date" 
                                            name="date_of_birth" 
                                            id="date_of_birth"
                                            value="{{ old('date_of_birth') }}"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control @error('gender') is-invalid @enderror" 
                                                name="gender" 
                                                id="gender">
                                            <option value="">Select Gender</option>
                                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              name="address" 
                                              id="address"
                                              rows="2" 
                                              placeholder="Address">{{ old('address') }}</textarea>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <input 
                                            class="form-control @error('city') is-invalid @enderror" 
                                            placeholder="City" 
                                            type="text" 
                                            name="city" 
                                            id="city"
                                            value="{{ old('city') }}"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <input 
                                            class="form-control @error('postal_code') is-invalid @enderror" 
                                            placeholder="Postal Code" 
                                            type="text" 
                                            name="postal_code" 
                                            id="postal_code"
                                            value="{{ old('postal_code') }}"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <input 
                                            class="form-control @error('country') is-invalid @enderror" 
                                            placeholder="Country" 
                                            type="text" 
                                            name="country" 
                                            id="country"
                                            value="{{ old('country') }}"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" target="_blank">Terms of Service</a> and <a href="#" target="_blank">Privacy Policy</a>
                                </label>
                            </div>

                            <!-- Newsletter Subscription -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="newsletter">
                                <label class="form-check-label" for="newsletter">
                                    Subscribe to our newsletter for beauty tips and exclusive offers
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button class="btn btn-login" type="submit" id="registerBtn">
                                Create My Account
                            </button>
                        </form>

                        <!-- Auth Links -->
                        <div class="auth-links">
                            <p class="mb-0">
                                Already have an account? 
                                <a href="{{ route('web.user.login.form') }}">Sign in here</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"></script>
    <script>
        // Initialize Feather Icons
        feather.replace();

        // Password Toggle Function
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(inputId + 'Icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Form submission with loading state
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }
            
            const terms = document.getElementById('terms').checked;
            if (!terms) {
                e.preventDefault();
                alert('Please accept the terms and conditions to continue.');
                return false;
            }

            const submitBtn = document.getElementById('registerBtn');
            submitBtn.innerHTML = 'Creating Account...';
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');
        });

        // Real-time password confirmation
        const confirmPassword = document.getElementById('password_confirmation');
        const password = document.getElementById('password');
        
        confirmPassword.addEventListener('input', function() {
            if (this.value && password.value && this.value !== password.value) {
                this.style.borderColor = '#ff6b6b';
            } else {
                this.style.borderColor = '#e8ecf0';
            }
        });

        // Add smooth scroll behavior for better UX
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>
</html>
