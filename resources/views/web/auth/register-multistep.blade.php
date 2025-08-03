<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Us - Glowzel</title>
    
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
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Form Styles */
        .form-step {
            display: none;
            opacity: 0;
            transform: translateX(30px);
            transition: all 0.4s ease;
        }

        .form-step.active {
            display: block;
            opacity: 1;
            transform: translateX(0);
        }

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

        /* Button Styles */
        .btn-navigation {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-primary, .btn-secondary {
            flex: 1;
            height: 55px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
                            <img src="{{ asset('logo.png') }}" alt="Glowzel" class="ts-logo__img">
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
                            <div class="step-connector"></div>
                            <div class="step-indicator" data-step="3"></div>
                            <div class="step-connector"></div>
                            <div class="step-indicator" data-step="4"></div>
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
                                        class="form-control @error('name') is-invalid @enderror" 
                                        placeholder="Full Name" 
                                        type="text" 
                                        name="name" 
                                        id="name"
                                        value="{{ old('name') }}" 
                                        required>
                                </div>

                                <div class="form-group">
                                    <input 
                                        class="form-control @error('email') is-invalid @enderror" 
                                        placeholder="Email Address" 
                                        type="email" 
                                        name="email" 
                                        id="email"
                                        value="{{ old('email') }}" 
                                        required>
                                </div>
                            </div>

                            <!-- Step 2: Security -->
                            <div class="form-step" data-step="2">
                                <div class="step-title">
                                    <i class="fas fa-lock me-2"></i>Security
                                </div>
                                
                                <div class="form-group">
                                    <div class="password-field">
                                        <input 
                                            class="form-control @error('password') is-invalid @enderror" 
                                            placeholder="Password" 
                                            type="password" 
                                            name="password" 
                                            id="password" 
                                            required>
                                        <button type="button" class="password-toggle" data-target="password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="password-field">
                                        <input 
                                            class="form-control" 
                                            placeholder="Confirm Password" 
                                            type="password" 
                                            name="password_confirmation" 
                                            id="password_confirmation" 
                                            required>
                                        <button type="button" class="password-toggle" data-target="password_confirmation">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Contact Information -->
                            <div class="form-step" data-step="3">
                                <div class="step-title">
                                    <i class="fas fa-phone me-2"></i>Contact Details
                                </div>
                                
                                <div class="form-group">
                                    <input 
                                        class="form-control" 
                                        placeholder="Phone Number (Optional)" 
                                        type="tel" 
                                        name="phone" 
                                        id="phone"
                                        value="{{ old('phone') }}">
                                </div>

                                <div class="form-group">
                                    <input 
                                        class="form-control" 
                                        placeholder="Address (Optional)" 
                                        type="text" 
                                        name="address" 
                                        id="address"
                                        value="{{ old('address') }}">
                                </div>
                            </div>

                            <!-- Step 4: Personal Details -->
                            <div class="form-step" data-step="4">
                                <div class="step-title">
                                    <i class="fas fa-heart me-2"></i>Personal Preferences
                                </div>
                                
                                <div class="form-group">
                                    <input 
                                        class="form-control" 
                                        placeholder="Date of Birth (Optional)" 
                                        type="date" 
                                        name="date_of_birth" 
                                        id="date_of_birth"
                                        value="{{ old('date_of_birth') }}">
                                </div>

                                <div class="form-group">
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="">Select Gender (Optional)</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            const totalSteps = 4;
            
            const steps = document.querySelectorAll('.form-step');
            const indicators = document.querySelectorAll('.step-indicator');
            const connectors = document.querySelectorAll('.step-connector');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');

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

            // Step navigation
            function showStep(step) {
                // Hide all steps
                steps.forEach(s => {
                    s.classList.remove('active');
                });
                
                // Show current step
                const currentStepElement = document.querySelector(`[data-step="${step}"]`);
                if (currentStepElement) {
                    currentStepElement.classList.add('active');
                }
                
                // Update indicators
                indicators.forEach((indicator, index) => {
                    const stepNumber = index + 1;
                    indicator.classList.remove('active', 'completed');
                    
                    if (stepNumber < step) {
                        indicator.classList.add('completed');
                    } else if (stepNumber === step) {
                        indicator.classList.add('active');
                    }
                });
                
                // Update connectors
                connectors.forEach((connector, index) => {
                    connector.classList.remove('completed');
                    if (index + 1 < step) {
                        connector.classList.add('completed');
                    }
                });
                
                // Update button visibility
                prevBtn.style.display = step === 1 ? 'none' : 'block';
                nextBtn.style.display = step === totalSteps ? 'none' : 'block';
                submitBtn.style.display = step === totalSteps ? 'block' : 'none';
            }

            // Validate current step
            function validateStep(step) {
                const currentStepElement = document.querySelector(`[data-step="${step}"]`);
                const inputs = currentStepElement.querySelectorAll('input[required], select[required]');
                
                let isValid = true;
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.style.borderColor = '#ff6b6b';
                        isValid = false;
                    } else {
                        input.style.borderColor = '#e8ecf0';
                    }
                });
                
                // Special validation for password confirmation
                if (step === 2) {
                    const password = document.getElementById('password').value;
                    const confirmation = document.getElementById('password_confirmation').value;
                    
                    if (password !== confirmation) {
                        document.getElementById('password_confirmation').style.borderColor = '#ff6b6b';
                        isValid = false;
                    }
                }
                
                return isValid;
            }

            // Next button click
            nextBtn.addEventListener('click', function() {
                if (validateStep(currentStep)) {
                    if (currentStep < totalSteps) {
                        currentStep++;
                        showStep(currentStep);
                    }
                }
            });

            // Previous button click
            prevBtn.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            // Form submission with loading state
            document.getElementById('registerForm').addEventListener('submit', function() {
                if (validateStep(currentStep)) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating Account...';
                    submitBtn.disabled = true;
                    submitBtn.classList.add('loading');
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (currentStep < totalSteps && validateStep(currentStep)) {
                        nextBtn.click();
                    } else if (currentStep === totalSteps) {
                        submitBtn.click();
                    }
                }
            });

            // Initialize
            showStep(currentStep);
        });
    </script>
</body>
</html>
