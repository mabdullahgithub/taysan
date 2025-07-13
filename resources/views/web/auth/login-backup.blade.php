<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Taysan & Co</title>
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
            min-height: 500px;
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
        }

        .login-right {
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 500px;
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

        .form-group {
            margin-bottom: 20px;
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
            margin-bottom: 15px;
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .form-check-label {
            color: var(--ts-gray);
            font-size: 0.95rem;
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
            transition: all 0.3s ease;
        }

        .auth-links a:hover {
            color: var(--ts-primary-dark);
            text-decoration: underline;
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

    <!-- Login Container -->
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
                            <h2>Welcome Back!</h2>
                            <p>Sign in to your account and continue your beauty journey with exclusive member benefits and personalized recommendations.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="col-lg-6">
                    <div class="login-right">
                        <div class="login-form-header">
                            <h1>Sign In</h1>
                            <p>Enter your credentials to access your account</p>
                        </div>

                        <form action="{{ route('web.user.login') }}" method="POST" id="loginForm">
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

                            <!-- Email Field -->
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="Enter your email address" 
                                    type="email" 
                                    name="email" 
                                    id="email"
                                    value="{{ old('email') }}"
                                    required
                                >
                            </div>

                            <!-- Password Field -->
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <div class="input-group">
                                    <input 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        placeholder="Enter your password" 
                                        type="password" 
                                        name="password" 
                                        id="password"
                                        required
                                    >
                                    <button type="button" class="password-toggle" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="passwordIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button class="btn btn-login" type="submit" id="loginBtn">
                                Sign In to Your Account
                            </button>
                        </form>

                        <!-- Auth Links -->
                        <div class="auth-links">
                            <p class="mb-2">
                                <a href="#" class="text-muted">Forgot your password?</a>
                            </p>
                            <p class="mb-0">
                                Don't have an account? 
                                <a href="{{ route('web.user.register.form') }}">Join us today</a>
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
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            
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
        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('loginBtn');
            submitBtn.innerHTML = 'Signing In...';
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');
        });

        // Add smooth scroll behavior for better UX
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>
</html>
<div class="auth-container">
    <div class="auth-wrapper auth-wrapper--login">
        <!-- Login Form -->
        <div class="auth-form-container">
            <div class="auth-form">
                <div class="auth-form__header">
                    <div class="logo">
                        <i class="fas fa-sparkles"></i>
                    </div>
                    <h2>Welcome Back</h2>
                    <p>Sign in to your account to continue your beauty journey</p>
                </div>

                @if (session('error'))
                    <div class="alert alert--error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert--success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('web.user.login') }}" method="POST" class="auth-form__form">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" 
                                   class="form-input @error('email') error @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Enter your email address"
                                   required>
                        </div>
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                            <div class="password-input">
                                <input type="password" 
                                       class="form-input @error('password') error @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Enter your password"
                                       required>
                                <button type="button" class="password-toggle" data-target="password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-options">
                        <div class="form-checkbox">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="#" class="link forgot-password">Forgot Password?</a>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn--primary btn--large">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Sign In</span>
                        </button>
                    </div>
                </form>

                <div class="auth-divider">
                    <span>or</span>
                </div>

                <div class="social-login">
                    <button type="button" class="btn btn--social btn--google">
                        <i class="fab fa-google"></i>
                        <span>Continue with Google</span>
                    </button>
                    <button type="button" class="btn btn--social btn--facebook">
                        <i class="fab fa-facebook-f"></i>
                        <span>Continue with Facebook</span>
                    </button>
                </div>

                <div class="auth-form__footer">
                    <p>Don't have an account? 
                        <a href="{{ route('web.user.register.form') }}" class="link">Join us today</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="auth-features">
            <div class="auth-features__content">
                <h3>Why Join Our Community?</h3>
                <div class="features-list">
                    <div class="feature-card">
                        <div class="feature-card__icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="feature-card__content">
                            <h4>Exclusive Discounts</h4>
                            <p>Get up to 30% off on premium beauty products and early access to sales.</p>
                        </div>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-card__icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="feature-card__content">
                            <h4>Personalized Experience</h4>
                            <p>Receive customized product recommendations based on your preferences.</p>
                        </div>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-card__icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="feature-card__content">
                            <h4>Loyalty Rewards</h4>
                            <p>Earn points with every purchase and redeem them for amazing rewards.</p>
                        </div>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-card__icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div class="feature-card__content">
                            <h4>Priority Shipping</h4>
                            <p>Enjoy faster delivery times and free shipping on orders over $50.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Auth Container Styles for Login */
.auth-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-wrapper--login {
    display: grid;
    grid-template-columns: 1fr 1fr;
    max-width: 1200px;
    width: 100%;
    min-height: 100vh;
    background: white;
    overflow: hidden;
}

/* Form Container for Login */
.auth-form-container {
    padding: 60px 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-form {
    width: 100%;
    max-width: 400px;
}

.auth-form__header {
    text-align: center;
    margin-bottom: 2rem;
}

.logo {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #9977B5 0%, #667eea 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}

.logo i {
    font-size: 1.5rem;
    color: white;
}

.auth-form__header h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 0.5rem;
}

.auth-form__header p {
    color: #666;
    font-size: 1rem;
    margin-bottom: 0;
}

/* Alerts */
.alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.alert--error {
    background: #fee;
    color: #c33;
    border: 1px solid #fcc;
}

.alert--success {
    background: #efe;
    color: #363;
    border: 1px solid #cfc;
}

/* Form Elements for Login */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 500;
    color: #333;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.input-icon {
    position: relative;
}

.input-icon > i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
    z-index: 1;
}

.input-icon .form-input {
    padding-left: 48px;
}

.form-input {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #fff;
}

.form-input:focus {
    outline: none;
    border-color: #9977B5;
    box-shadow: 0 0 0 3px rgba(153, 119, 181, 0.1);
}

.form-input.error {
    border-color: #e74c3c;
}

.form-error {
    display: block;
    color: #e74c3c;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

/* Password Input for Login */
.password-input {
    position: relative;
    width: 100%;
}

.input-icon .password-input .form-input {
    padding-left: 48px;
    padding-right: 48px;
}

.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
    padding: 4px;
    z-index: 2;
}

/* Form Options */
.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.form-checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-checkbox input[type="checkbox"] {
    transform: scale(1.1);
}

.form-checkbox label {
    font-size: 0.9rem;
    color: #666;
    margin: 0;
}

.forgot-password {
    font-size: 0.9rem;
}

/* Buttons for Login */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn--primary {
    background: linear-gradient(135deg, #9977B5 0%, #667eea 100%);
    color: white;
}

.btn--primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(153, 119, 181, 0.3);
}

.btn--large {
    padding: 16px 32px;
    font-size: 1.1rem;
    width: 100%;
}

.btn--social {
    background: white;
    border: 2px solid #e1e5e9;
    color: #333;
    width: 100%;
    margin-bottom: 0.75rem;
}

.btn--social:hover {
    border-color: #9977B5;
    transform: translateY(-1px);
}

.btn--google:hover {
    border-color: #db4437;
    color: #db4437;
}

.btn--facebook:hover {
    border-color: #3b5998;
    color: #3b5998;
}

/* Auth Divider */
.auth-divider {
    text-align: center;
    margin: 2rem 0;
    position: relative;
}

.auth-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e1e5e9;
}

.auth-divider span {
    background: white;
    padding: 0 1rem;
    color: #999;
    font-size: 0.9rem;
    position: relative;
    z-index: 1;
}

/* Social Login */
.social-login {
    margin-bottom: 2rem;
}

/* Footer */
.auth-form__footer {
    text-align: center;
    padding-top: 2rem;
    border-top: 1px solid #e1e5e9;
}

.link {
    color: #9977B5;
    text-decoration: none;
    font-weight: 500;
}

.link:hover {
    text-decoration: underline;
}

/* Features Section */
.auth-features {
    background: linear-gradient(135deg, #9977B5 0%, #667eea 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 40px;
    color: white;
    position: relative;
}

.auth-features::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="white" opacity="0.1"/><circle cx="80" cy="40" r="1" fill="white" opacity="0.05"/><circle cx="40" cy="80" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}

.auth-features__content {
    position: relative;
    z-index: 1;
    max-width: 400px;
}

.auth-features__content h3 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 2rem;
    text-align: center;
}

.features-list {
    display: grid;
    gap: 1.5rem;
}

.feature-card {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.feature-card__icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.feature-card__icon i {
    font-size: 1.2rem;
    color: #FFD700;
}

.feature-card__content h4 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.feature-card__content p {
    font-size: 0.9rem;
    opacity: 0.9;
    line-height: 1.4;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .auth-wrapper--login {
        grid-template-columns: 1fr;
    }
    
    .auth-features {
        order: -1;
        padding: 40px 20px;
    }
    
    .auth-features__content h3 {
        font-size: 1.5rem;
    }
    
    .features-list {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .auth-form-container {
        padding: 40px 20px;
    }
}

@media (max-width: 768px) {
    .features-list {
        grid-template-columns: 1fr;
    }
    
    .form-options {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .auth-form-container {
        padding: 30px 20px;
    }
    
    .auth-features {
        padding: 30px 20px;
    }
}

@media (max-width: 480px) {
    .feature-card {
        gap: 0.75rem;
    }
    
    .feature-card__icon {
        width: 40px;
        height: 40px;
    }
    
    .feature-card__icon i {
        font-size: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    document.querySelectorAll('.password-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('loginBtn');
            submitBtn.innerHTML = 'Signing In...';
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');
        });

        // Add smooth scroll behavior for better UX
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>
</html>
