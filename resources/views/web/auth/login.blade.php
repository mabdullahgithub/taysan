<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Glowzel</title>
    
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
            max-width: 1200px;
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
            height: 80px;
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

        .auth-form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-form-header h1 {
            color: var(--ts-black);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .auth-form-header p {
            color: var(--ts-gray);
            font-size: 1rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            height: 55px;
            border: 2px solid #e8ecf0;
            border-radius: 12px;
            padding: 0 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafbfc;
        }

        .form-control:focus {
            border-color: var(--ts-primary);
            box-shadow: 0 0 0 3px rgba(141, 104, 173, 0.1);
            background: var(--ts-white);
        }

        .form-control::placeholder {
            color: #a8b2b8;
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

        .form-check {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-check-input {
            margin-top: 0;
            transform: scale(1.1);
        }

        .form-check-label {
            color: var(--ts-gray);
            font-size: 0.95rem;
            margin: 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--ts-primary) 0%, var(--ts-primary-dark) 100%);
            border: none;
            border-radius: 12px;
            height: 55px;
            font-size: 1.1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--ts-shadow-hover);
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
                font-size: 2rem;
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
                font-size: 1.8rem;
            }

            .form-control,
            .btn-primary {
                height: 50px;
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
                            <img src="{{ asset('logo.png') }}" alt="Glowzel" class="ts-logo__img">
                        </a>

                        <!-- Welcome Text -->
                        <div class="welcome-text">
                            <h2>Welcome Back!</h2>
                            <p>Sign in to your account and continue your beauty journey with exclusive member benefits and personalized recommendations.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Panel -->
                <div class="col-lg-6">
                    <div class="auth-right">
                        <div class="auth-form-header">
                            <h1>Sign In</h1>
                            <p>Enter your credentials to access your account</p>
                        </div>

                        <form action="{{ route('web.user.login') }}" method="POST" id="loginForm">
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
                                    required>
                            </div>

                            <!-- Password Field -->
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <div class="password-field">
                                    <input 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        placeholder="Enter your password" 
                                        type="password" 
                                        name="password" 
                                        id="password" 
                                        required>
                                    <button type="button" class="password-toggle" data-target="password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-block" id="loginBtn">
                                Sign In
                            </button>

                            <!-- Auth Links -->
                            <div class="auth-links">
                                <p class="mb-2">
                                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                                </p>
                                <p class="mb-0">
                                    Don't have an account? <a href="{{ route('web.user.register.form') }}">Sign up</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
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
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Signing In...';
                submitBtn.disabled = true;
                submitBtn.classList.add('loading');
            });
        });
    </script>
</body>
</html>
