<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Taysan & Co</title>
    
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
            max-width: 500px;
            margin: 2rem;
        }

        .auth-card {
            background: var(--ts-white);
            border-radius: 20px;
            box-shadow: var(--ts-shadow);
            overflow: hidden;
            padding: 40px 30px;
        }

        .auth-form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-form-header .icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--ts-primary-light), var(--ts-primary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: var(--ts-white);
        }

        .auth-form-header h1 {
            color: var(--ts-black);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .auth-form-header p {
            color: var(--ts-gray);
            font-size: 1rem;
            line-height: 1.6;
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
        @media (max-width: 575.98px) {
            .auth-container {
                margin: 1rem;
            }

            .auth-card {
                border-radius: 15px;
                padding: 30px 20px;
            }

            .auth-form-header h1 {
                font-size: 1.6rem;
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
            <div class="auth-form-header">
                <div class="icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h1>Reset Password</h1>
                <p>Enter your new password to complete the reset process.</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" id="resetForm">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
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
                @if (session('status'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
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
                        value="{{ old('email', request()->email) }}" 
                        required>
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password" class="sr-only">New Password</label>
                    <div class="password-field">
                        <input 
                            class="form-control @error('password') is-invalid @enderror" 
                            placeholder="Enter your new password" 
                            type="password" 
                            name="password" 
                            id="password" 
                            required>
                        <button type="button" class="password-toggle" data-target="password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div class="form-group">
                    <label for="password_confirmation" class="sr-only">Confirm Password</label>
                    <div class="password-field">
                        <input 
                            class="form-control" 
                            placeholder="Confirm your new password" 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            required>
                        <button type="button" class="password-toggle" data-target="password_confirmation">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-block" id="resetBtn">
                    Reset Password
                </button>

                <!-- Auth Links -->
                <div class="auth-links">
                    <p class="mb-0">
                        <a href="{{ route('web.user.login.form') }}"><i class="fas fa-arrow-left me-1"></i>Back to Sign In</a>
                    </p>
                </div>
            </form>
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
            document.getElementById('resetForm').addEventListener('submit', function() {
                const submitBtn = document.getElementById('resetBtn');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Resetting...';
                submitBtn.disabled = true;
                submitBtn.classList.add('loading');
            });
        });
    </script>
</body>
</html>
