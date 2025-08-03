<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - Glowzel Beauty</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Open Sans', Arial, sans-serif;
            line-height: 1.6;
            color: #060530;
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
            width: 100px;
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
        
        .welcome-section {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .welcome-title {
            color: #060530;
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 12px;
            font-family: 'Lora', serif;
        }
        
        .welcome-text {
            color: #687693;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 18px;
        }
        
        .catchy-line {
            background: linear-gradient(135deg, #8D68AD, #A893C4);
            border-radius: 15px;
            padding: 25px 20px;
            margin: 25px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .catchy-line::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        
        .catchy-quote {
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
            font-family: 'Lora', serif;
            margin-bottom: 8px;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .catchy-subtext {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            font-weight: 500;
            position: relative;
            z-index: 2;
        }
        
        .highlight-box {
            background: linear-gradient(135deg, #f8f0ff, #e9ddf7);
            border: 1px solid #e1d3f0;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        
        .highlight-title {
            color: #8D68AD;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .verify-button {
            display: inline-block;
            background: linear-gradient(135deg, #8D68AD, #A893C4);
            color: white;
            text-decoration: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            margin: 15px 0;
            box-shadow: 0 8px 25px rgba(141, 104, 173, 0.3);
            transition: all 0.3s ease;
        }
        
        .verify-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(141, 104, 173, 0.4);
            color: white;
        }
        
        .security-info {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        
        .security-title {
            color: #c53030;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .security-text {
            color: #742a2a;
            font-size: 0.85rem;
            line-height: 1.5;
        }
        
        .manual-link {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            margin: 15px 0;
            word-break: break-all;
            font-size: 0.8rem;
            color: #4a5568;
        }
        
        .features-section {
            margin: 25px 0;
        }
        
        .features-title {
            color: #060530;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
            font-family: 'Lora', serif;
        }
        
        .benefits-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
            margin-top: 20px;
        }
        
        .benefit-card {
            background: white;
            border: 1px solid #e1d3f0;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(141, 104, 173, 0.1);
        }
        
        .benefit-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(141, 104, 173, 0.15);
            border-color: #8D68AD;
        }
        
        .benefit-icon-wrapper {
            flex-shrink: 0;
        }
        
        .benefit-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #8D68AD, #A893C4);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            box-shadow: 0 4px 15px rgba(141, 104, 173, 0.3);
        }
        
        .benefit-content {
            flex: 1;
        }
        
        .benefit-title {
            color: #060530;
            font-size: 1rem;
            font-weight: 600;
            margin: 0 0 8px 0;
            font-family: 'Lora', serif;
        }
        
        .benefit-description {
            color: #687693;
            font-size: 0.9rem;
            line-height: 1.5;
            margin: 0;
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
        
        .footer-text {
            color: #687693;
            font-size: 0.85rem;
            margin-bottom: 15px;
        }
        
        .social-links {
            margin: 15px 0;
        }
        
        .social-link {
            display: inline-block;
            margin: 0 8px;
            width: 35px;
            height: 35px;
            background: #8D68AD;
            color: white;
            border-radius: 50%;
            text-decoration: none;
            line-height: 35px;
            transition: all 0.3s ease;
        }
        
        .social-link:hover {
            background: #060530;
            transform: translateY(-2px);
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
            
            .catchy-line {
                padding: 20px 15px;
                margin: 20px 0;
            }
            
            .catchy-quote {
                font-size: 1.1rem;
            }
            
            .catchy-subtext {
                font-size: 0.85rem;
            }
            
            .verify-button {
                padding: 12px 25px;
                font-size: 0.95rem;
            }
            
            .benefit-card {
                padding: 15px;
                gap: 12px;
                flex-direction: column;
                text-align: center;
            }
            
            .benefit-icon {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }
            
            .benefit-title {
                font-size: 0.95rem;
            }
            
            .benefit-description {
                font-size: 0.85rem;
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
                <p class="brand-subtitle">Welcome to Natural Beauty</p>
            </div>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h2 class="welcome-title">Welcome to Your Beauty Journey! ✨</h2>
                <p class="welcome-text">
                    Hi <strong>{{ $user->name }}</strong>,<br><br>
                    Welcome to <strong>Glowzel Beauty</strong> - where your natural glow begins! 🌟
                </p>
                
                <!-- Catchy Line -->
                <div class="catchy-line">
                    <div class="catchy-quote">"Unleash Your Inner Radiance with Every Drop"</div>
                    <div class="catchy-subtext">Join thousands who've discovered the secret to naturally glowing skin</div>
                </div>
                
                <p class="welcome-text">
                    Thank you for joining our exclusive beauty community! We're absolutely thrilled to have you discover our premium collection of natural, handcrafted skincare products designed to help you glow from within.
                </p>
            </div>
            
            <!-- Verify Button Section -->
            <div class="highlight-box">
                <div class="highlight-title">🔐 Secure Email Verification</div>
                <p style="color: #687693; margin-bottom: 20px;">
                    To unlock your personalized beauty experience and start exploring our curated collections, please verify your email address by clicking the button below:
                </p>
                
                <a href="{{ $verificationUrl }}" class="verify-button">
                    ✅ Verify My Email Address
                </a>
                
                <p style="color: #687693; font-size: 0.9rem; margin-top: 15px;">
                    This will only take a moment and ensures the security of your account.
                </p>
            </div>
            
            <!-- Security Information -->
            <div class="security-info">
                <div class="security-title">
                    ⏰ Important Security Notice
                </div>
                <div class="security-text">
                    This verification link will expire in <strong>60 minutes</strong> for your security. If you need a new link, simply visit our website and request another verification email.
                </div>
            </div>
            
            <!-- Manual Link -->
            <p style="color: #687693; font-size: 0.9rem; margin-bottom: 10px;">
                <strong>Can't click the button?</strong> Copy and paste this link into your browser:
            </p>
            <div class="manual-link">{{ $verificationUrl }}</div>
            
            <!-- Quick Benefits Section -->
            {{-- <div class="features-section">
                <h3 class="features-title">Why Verify Your Email?</h3>
                <div class="benefits-grid">
                    <div class="benefit-card">
                        <div class="benefit-icon-wrapper">
                            <div class="benefit-icon">🔒</div>
                        </div>
                        <div class="benefit-content">
                            <h4 class="benefit-title">Account Security</h4>
                            <p class="benefit-description">Secure your account and protect your personal information with verified email authentication.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon-wrapper">
                            <div class="benefit-icon">📧</div>
                        </div>
                        <div class="benefit-content">
                            <h4 class="benefit-title">Stay Updated</h4>
                            <p class="benefit-description">Receive order updates, exclusive offers, and personalized beauty tips directly to your inbox.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon-wrapper">
                            <div class="benefit-icon">🎁</div>
                        </div>
                        <div class="benefit-content">
                            <h4 class="benefit-title">Exclusive Access</h4>
                            <p class="benefit-description">Unlock access to member-only products, special discounts, and early access to new launches.</p>
                        </div>
                    </div>
                </div>
            </div> --}}
            
            <!-- Welcome Message -->
            <div class="highlight-box" style="margin-top: 25px;">
                <p style="color: #060530; font-weight: 600; font-size: 1rem; margin-bottom: 12px;">
                    🌟 You're Now Part of Something Beautiful!
                </p>
                <p style="color: #687693; font-size: 0.9rem; margin: 0; line-height: 1.6;">
                    Join thousands of beauty enthusiasts who trust our natural, handcrafted skincare products for their daily glow-up routine. Get ready to discover the transformative power of premium, eco-friendly beauty that loves your skin as much as you do.
                </p>
            </div>
            
            <!-- Support Note -->
            <p style="color: #687693; font-size: 0.9rem; margin-top: 30px; text-align: center; font-style: italic;">
                Questions or need help? Our beauty experts are here to assist you at 
                <a href="mailto:support@glowzel.co" style="color: #8D68AD; text-decoration: none;">support@glowzel.co</a>
            </p>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-brand">Glowzel Beauty</div>
            <div class="footer-text">Natural Handcrafted Skincare • Est. 2024</div>
            
            <div class="social-links">
                <a href="#" class="social-link">📧</a>
                <a href="#" class="social-link">📱</a>
                <a href="#" class="social-link">🌐</a>
            </div>
            
            <div class="contact-info">
                <div class="contact-text">📧 info@glowzel.co</div>
                <div class="contact-text">🌐 www.glowzel.co</div>
                <div class="contact-text">📍 Founded by Muhammad Abdullah</div>
            </div>
            
            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e1d3f0;">
                <p style="color: #687693; font-size: 0.8rem;">
                    If you did not create an account with Glowzel Beauty, please ignore this email.<br>
                    This email was sent to {{ $user->email }} because you registered for a Glowzel Beauty account.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
