<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Taysan & Co</title>
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
            padding: 60px 40px;
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
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 500px;
        }

        .login-form-header {
            text-align: center;
            margin-bottom: 50px;
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
            margin-bottom: 30px;
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

        .alert ul {
            margin: 0;
            padding-left: 20px;
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

        /* Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .login-container {
                padding: 20px;
            }

            .login-card {
                border-radius: 18px;
                max-width: 540px;
            }

            .login-left {
                min-height: 350px;
                padding: 40px 30px;
            }

            .login-right {
                padding: 40px 30px;
                min-height: auto;
            }

            .welcome-text h2 {
                font-size: 1.8rem;
            }

            .welcome-text p {
                font-size: 1rem;
                max-width: 100%;
            }

            .login-form-header h1 {
                font-size: 1.7rem;
            }

            .ts-logo__img {
                max-width: 120px;
            }

            .form-control {
                padding: 14px 18px;
                border-radius: 14px;
            }

            .btn-login {
                padding: 14px 25px;
                border-radius: 14px;
            }
        }

        /* Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .login-container {
                padding: 30px;
            }

            .login-card {
                max-width: 720px;
            }

            .login-left {
                min-height: 400px;
                padding: 50px 35px;
            }

            .login-right {
                padding: 50px 35px;
                min-height: 400px;
            }

            .welcome-text h2 {
                font-size: 2rem;
            }

            .welcome-text p {
                font-size: 1.05rem;
                max-width: 300px;
            }

            .login-form-header h1 {
                font-size: 1.9rem;
            }

            .ts-logo__img {
                max-width: 140px;
            }

            .form-control {
                padding: 16px 20px;
            }

            .btn-login {
                padding: 16px 30px;
            }
        }

        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) and (max-width: 1199.98px) {
            .login-container {
                padding: 40px;
            }

            .login-card {
                max-width: 900px;
            }

            .login-left {
                min-height: 500px;
                padding: 60px 40px;
            }

            .login-right {
                padding: 60px 45px;
                min-height: 500px;
            }

            .welcome-text h2 {
                font-size: 2.4rem;
            }

            .welcome-text p {
                font-size: 1.1rem;
                max-width: 320px;
            }

            .login-form-header h1 {
                font-size: 2.2rem;
            }

            .ts-logo__img {
                max-width: 160px;
            }
        }

        /* Extra large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) {
            .login-container {
                padding: 50px;
            }

            .login-card {
                max-width: 1000px;
            }

            .login-left {
                min-height: 500px;
                padding: 60px 40px;
            }

            .login-right {
                padding: 60px 50px;
                min-height: 500px;
            }

            .welcome-text h2 {
                font-size: 2.8rem;
            }

            .welcome-text p {
                font-size: 1.2rem;
                max-width: 350px;
            }

            .login-form-header h1 {
                font-size: 2.5rem;
            }

            .ts-logo__img {
                max-width: 180px;
            }
        }

        /* Ultra-wide screens */
        @media (min-width: 1400px) {
            .login-container {
                padding: 60px;
            }

            .login-card {
                max-width: 1100px;
            }
        }

        /* Landscape orientation adjustments */
        @media (max-height: 600px) and (orientation: landscape) {
            .login-container {
                padding: 20px;
            }

            .login-left {
                min-height: auto;
                padding: 30px 25px;
            }

            .login-right {
                padding: 30px 25px;
                min-height: auto;
            }

            .welcome-text h2 {
                font-size: 1.8rem;
                margin-bottom: 10px;
            }

            .welcome-text p {
                font-size: 0.95rem;
            }

            .login-form-header {
                margin-bottom: 25px;
            }

            .login-form-header h1 {
                font-size: 1.6rem;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .ts-logo__img {
                max-width: 120px;
            }
        }

        /* Loading Animation */
        .btn-login.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        /* Focus styles for accessibility */
        .form-control:focus,
        .btn-login:focus,
        .password-toggle:focus {
            outline: none;
        }

        /* Enhanced hover effects */
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 35px 100px rgba(0, 0, 0, 0.2),
                0 15px 50px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
            transition: all 0.4s ease;
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
                                <i class="fas fa-circle"></i>
                            </div>
                            <div class="floating-element">
                                <i class="fas fa-square"></i>
                            </div>
                            <div class="floating-element">
                                <i class="fas fa-triangle-up"></i>
                            </div>
                        </div>

                        <!-- Logo -->
                        <a href="#" class="ts-logo">
                            <img src="logo.png" alt="Taysan & Co" class="ts-logo__img">
                        </a>

                        <!-- Welcome Text -->
                        <div class="welcome-text">
                            <h2>Welcome Back!</h2>
                            <p>We're excited to see you again. Sign in to access your dashboard and manage your business with confidence and ease.</p>
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

                        <form  action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <!-- Error Messages -->
                            <div class="alert alert-danger" style="display: none;" id="errorAlert">
                                <ul id="errorList"></ul>
                            </div>

                            <!-- Email Field -->
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input 
                                    class="form-control" 
                                    placeholder="Enter your email address" 
                                    type="email" 
                                    name="email" 
                                    id="email"
                                    required
                                >
                            </div>

                            <!-- Password Field -->
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <div class="input-group">
                                    <input 
                                        class="form-control" 
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

                            <!-- Submit Button -->
                            <button class="btn btn-login" type="submit" id="loginBtn">
                                Sign In to Dashboard
                            </button>
                        </form>
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

 
 

        // Add smooth scroll behavior for better UX
        document.documentElement.style.scrollBehavior = 'smooth';

        // Prevent form submission on Enter key for better UX
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.tagName !== 'BUTTON') {
                e.preventDefault();
                const form = document.getElementById('loginForm');
                form.dispatchEvent(new Event('submit'));
            }
        });
    </script>
</body>
</html>