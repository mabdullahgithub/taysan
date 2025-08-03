@extends('web.layout.app')

@section('title', 'Verify Your Email - Glowzel')

@section('content')
<style>
    .verify-email-section {
        padding: 100px 0;
        background: linear-gradient(135deg, #f8f0ff 0%, #fff 100%);
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
    }
    
    .verify-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(141, 104, 173, 0.15);
        overflow: hidden;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .verify-header {
        background: linear-gradient(135deg, #8D68AD, #A893C4);
        color: white;
        text-align: center;
        padding: 3rem 2rem;
        position: relative;
    }
    
    .verify-header::before {
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
    
    .verify-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }
    
    .verify-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-family: 'Lora', serif;
    }
    
    .verify-subtitle {
        opacity: 0.95;
        font-size: 1.1rem;
        font-weight: 500;
    }
    
    .verify-body {
        padding: 3rem 2rem;
    }
    
    .welcome-message {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .user-greeting {
        font-size: 1.3rem;
        color: #060530;
        font-weight: 600;
        margin-bottom: 1rem;
        font-family: 'Lora', serif;
    }
    
    .verify-message {
        color: #687693;
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 2rem;
    }
    
    .email-display {
        background: linear-gradient(135deg, #f8f0ff, #e9ddf7);
        padding: 1.5rem;
        border-radius: 15px;
        text-align: center;
        margin-bottom: 2rem;
        border: 1px solid #e1d3f0;
    }
    
    .email-label {
        font-size: 0.9rem;
        color: #8D68AD;
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .email-value {
        font-size: 1.1rem;
        color: #060530;
        font-weight: 600;
        word-break: break-all;
    }
    
    .action-buttons {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .btn-resend {
        background: linear-gradient(135deg, #8D68AD, #A893C4);
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        box-shadow: 0 8px 20px rgba(141, 104, 173, 0.3);
    }
    
    .btn-resend:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(141, 104, 173, 0.4);
        color: white;
    }
    
    .btn-resend:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: 0 8px 20px rgba(141, 104, 173, 0.2);
    }
    
    .secondary-actions {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
    }
    
    .secondary-link {
        color: #8D68AD;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 10px 20px;
        border-radius: 25px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .secondary-link:hover {
        color: #060530;
        background: #f8f0ff;
        border-color: #e1d3f0;
        text-decoration: none;
    }
    
    .alert {
        border-radius: 12px;
        border: none;
        margin-bottom: 2rem;
        padding: 1rem 1.5rem;
    }
    
    .alert-success {
        background: linear-gradient(135deg, rgba(72, 187, 120, 0.1), rgba(72, 187, 120, 0.05));
        color: #38a169;
        border: 1px solid rgba(72, 187, 120, 0.2);
    }
    
    .alert-danger {
        background: linear-gradient(135deg, rgba(245, 101, 101, 0.1), rgba(245, 101, 101, 0.05));
        color: #e53e3e;
        border: 1px solid rgba(245, 101, 101, 0.2);
    }
    
    .countdown-container {
        margin-top: 1rem;
        padding: 1rem;
        background: #f8f0ff;
        border-radius: 10px;
        text-align: center;
        display: none;
    }
    
    .countdown-text {
        color: #8D68AD;
        font-weight: 500;
        font-size: 0.95rem;
    }
    
    .countdown-timer {
        color: #060530;
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    @media (max-width: 768px) {
        .verify-email-section {
            padding: 50px 0;
        }
        
        .verify-header {
            padding: 2rem 1.5rem;
        }
        
        .verify-title {
            font-size: 1.8rem;
        }
        
        .verify-body {
            padding: 2rem 1.5rem;
        }
        
        .secondary-actions {
            flex-direction: column;
            gap: 1rem;
        }
        
        .btn-resend {
            padding: 12px 30px;
            font-size: 0.95rem;
        }
    }
</style>

<section class="verify-email-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="verify-card">
                    <div class="verify-header">
                        <div class="verify-icon">
                            <i class="fas fa-envelope-check"></i>
                        </div>
                        <h1 class="verify-title">Email Verification</h1>
                        <p class="verify-subtitle">We've sent you a secure verification link</p>
                    </div>
                    
                    <div class="verify-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('status') }}
                            </div>
                        @endif
                        
                        @if (session('error'))
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="welcome-message">
                            @auth
                                <h2 class="user-greeting">
                                    <i class="fas fa-sparkles me-2" style="color: #A893C4;"></i>
                                    Welcome, {{ auth()->user()->name }}!
                                </h2>
                            @endauth
                            
                            <p class="verify-message">
                                <strong>Thank you for joining Glowzel Beauty!</strong> We're excited to have you discover our premium natural skincare products. To complete your registration and unlock your personalized beauty journey, please verify your email address.
                            </p>
                        </div>
                        
                        <div class="email-display">
                            <div class="email-label">Verification Email Sent To</div>
                            <div class="email-value">
                                <i class="fas fa-envelope me-2" style="color: #8D68AD;"></i>
                                {{ session('email', auth()->user()?->email ?? 'your email') }}
                            </div>
                        </div>
                        
                        <div class="verify-message">
                            <p><strong>Haven't received the email yet?</strong> Please check your spam or junk folder. If you still can't find it, click the button below to resend the verification link.</p>
                        </div>
                        
                        <div class="action-buttons">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                @if (!auth()->check() && session('email'))
                                    <input type="hidden" name="email" value="{{ session('email') }}">
                                @endif
                                <button type="submit" class="btn-resend" id="resendBtn">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Resend Verification Email
                                </button>
                            </form>
                            
                            <div class="countdown-container" id="countdownContainer">
                                <div class="countdown-text">
                                    You can resend the email in <span class="countdown-timer" id="timer">60</span> seconds
                                </div>
                            </div>
                        </div>
                        
                        <div class="secondary-actions">
                            <a href="{{ route('web.view.index') }}" class="secondary-link">
                                <i class="fas fa-home"></i>
                                Continue to Website
                            </a>
                            <a href="{{ route('web.user.login.form') }}" class="secondary-link">
                                <i class="fas fa-sign-in-alt"></i>
                                Back to Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const resendBtn = document.getElementById('resendBtn');
    const countdownContainer = document.getElementById('countdownContainer');
    const timer = document.getElementById('timer');
    let timeLeft = 0;
    
    // Check if we should start countdown (if form was just submitted)
    @if(session('status'))
        startCountdown();
    @endif
    
    resendBtn.addEventListener('click', function() {
        // Only start countdown if the form submission is successful
        setTimeout(() => {
            if (!document.querySelector('.alert-danger')) {
                startCountdown();
            }
        }, 100);
    });
    
    function startCountdown() {
        timeLeft = 60;
        resendBtn.disabled = true;
        countdownContainer.style.display = 'block';
        
        const countdownInterval = setInterval(function() {
            timeLeft--;
            timer.textContent = timeLeft;
            
            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                resendBtn.disabled = false;
                countdownContainer.style.display = 'none';
            }
        }, 1000);
    }
});
</script>
@endsection
