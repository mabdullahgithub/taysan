<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP - Glowzel Beauty</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&family=Mulish:wght@400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Mulish', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f0ff;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(141, 104, 173, 0.15);
        }
        
        .email-header {
            background: linear-gradient(135deg, #8D68AD 0%, #A893C4 100%);
            padding: 30px 25px;
            text-align: center;
            position: relative;
        }
        
        .email-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('{{ asset("logo.png") }}') center center no-repeat;
            background-size: 60px;
            opacity: 0.1;
        }
        
        .logo-container {
            position: relative;
            z-index: 2;
        }
        
        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 15px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            padding: 8px;
            backdrop-filter: blur(10px);
        }
        
        .brand-title {
            color: white;
            font-size: 1.9rem;
            font-weight: 700;
            margin-bottom: 8px;
            font-family: 'Lora', serif;
        }
        
        .brand-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            font-weight: 500;
        }
        
        .email-body {
            padding: 30px 25px;
        }
        
        .greeting-section {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .greeting-title {
            color: #060530;
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 12px;
            font-family: 'Lora', serif;
        }
        
        .greeting-text {
            color: #687693;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 18px;
        }
        
        .otp-section {
            background: linear-gradient(135deg, #f8f0ff, #e9ddf7);
            border: 2px solid #8D68AD;
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        
        .otp-label {
            color: #8D68AD;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .otp-code {
            font-size: 2.5rem;
            font-weight: 700;
            color: #060530;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            background: white;
            border: 2px dashed #8D68AD;
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            box-shadow: 0 4px 15px rgba(141, 104, 173, 0.2);
        }
        
        .otp-note {
            color: #687693;
            font-size: 0.9rem;
            margin-top: 15px;
            font-style: italic;
        }
        
        .security-info {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 10px;
            padding: 18px;
            margin: 20px 0;
        }
        
        .security-title {
            color: #c53030;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .security-text {
            color: #742a2a;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        .instructions {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .instructions-title {
            color: #0369a1;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 12px;
            font-family: 'Lora', serif;
        }
        
        .instructions-list {
            color: #0c4a6e;
            font-size: 0.9rem;
            line-height: 1.6;
        }
        
        .instructions-list ol {
            padding-left: 20px;
            margin: 0;
        }
        
        .instructions-list li {
            margin-bottom: 8px;
        }
        
        .footer-note {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e1d3f0;
        }
        
        .footer-text {
            color: #687693;
            font-size: 0.85rem;
            margin: 5px 0;
        }
        
        .email-footer {
            background: #f8f0ff;
            padding: 25px;
            text-align: center;
            border-top: 1px solid #e1d3f0;
        }
        
        .footer-brand {
            color: #8D68AD;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 8px;
            font-family: 'Lora', serif;
        }
        
        .footer-subtitle {
            color: #687693;
            font-size: 0.85rem;
            margin-bottom: 15px;
        }
        
        .contact-info {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e1d3f0;
        }
        
        .contact-text {
            color: #687693;
            font-size: 0.8rem;
            margin: 3px 0;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 5px;
                border-radius: 12px;
            }
            
            .email-header {
                padding: 25px 20px;
            }
            
            .brand-title {
                font-size: 1.6rem;
            }
            
            .email-body {
                padding: 25px 20px;
            }
            
            .otp-code {
                font-size: 2rem;
                letter-spacing: 6px;
                padding: 15px;
            }
            
            .otp-section {
                padding: 20px;
            }
            
            .email-footer {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="logo-container">
                <img src="{{ asset('logo.png') }}" alt="Glowzel Beauty" class="logo">
                <h1 class="brand-title">Glowzel Beauty</h1>
                <p class="brand-subtitle">Secure Password Reset</p>
            </div>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <!-- Greeting Section -->
            <div class="greeting-section">
                <h2 class="greeting-title">Password Reset Request 🔐</h2>
                <p class="greeting-text">
                    Hi <strong>{{ $userName }}</strong>,<br><br>
                    We received a request to reset your password for your Glowzel Beauty account. To proceed with resetting your password, please use the verification code below.
                </p>
            </div>
            
            <!-- OTP Section -->
            <div class="otp-section">
                <div class="otp-label">🔢 Your Verification Code</div>
                <div class="otp-code">{{ $otp }}</div>
                <p class="otp-note">This code will expire in 10 minutes for your security.</p>
            </div>
            
            <!-- Instructions -->
            <div class="instructions">
                <h3 class="instructions-title">How to Reset Your Password:</h3>
                <div class="instructions-list">
                    <ol>
                        <li>Go to the password reset page on our website</li>
                        <li>Enter your email address: <strong>{{ $email }}</strong></li>
                        <li>Enter the verification code: <strong>{{ $otp }}</strong></li>
                        <li>Create a new secure password</li>
                        <li>Confirm your new password and submit</li>
                    </ol>
                </div>
            </div>
            
            <!-- Security Information -->
            <div class="security-info">
                <div class="security-title">
                    🛡️ Important Security Notice
                </div>
                <div class="security-text">
                    <strong>This code expires in 10 minutes.</strong> If you didn't request a password reset, please ignore this email and your account will remain secure. For your safety, never share this code with anyone.
                </div>
            </div>
            
            <!-- Footer Note -->
            <div class="footer-note">
                <p class="footer-text">
                    If you're having trouble resetting your password, contact our support team at 
                    <a href="mailto:support@glowzel.co" style="color: #8D68AD; text-decoration: none;">support@glowzel.co</a>
                </p>
                <p class="footer-text">
                    This email was sent to <strong>{{ $email }}</strong> because a password reset was requested for your Glowzel Beauty account.
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-brand">Glowzel Beauty</div>
            <div class="footer-subtitle">Natural Handcrafted Skincare • Secure & Trusted</div>
            
            <div class="contact-info">
                <div class="contact-text">📧 info@glowzel.co</div>
                <div class="contact-text">🌐 www.glowzel.co</div>
                <div class="contact-text">📍 Founded by Muhammad Abdullah</div>
            </div>
        </div>
    </div>
</body>
</html>
