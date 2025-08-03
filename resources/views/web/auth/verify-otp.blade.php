@extends('web.layout.app')

@section('title', 'Verify OTP - Glowzel')

@section('content')
<style>
    .otp-verification-section {
        padding: 100px 0;
        background: linear-gradient(135deg, #f8f0ff 0%, #fff 100%);
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
    }
    
    .otp-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(141, 104, 173, 0.15);
        overflow: hidden;
        max-width: 500px;
        margin: 0 auto;
    }
    
    .otp-header {
        background: linear-gradient(135deg, #8D68AD, #A893C4);
        color: white;
        text-align: center;
        padding: 3rem 2rem;
        position: relative;
    }
    
    .otp-header::before {
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
    
    .otp-icon {
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
    
    .otp-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-family: 'Lora', serif;
    }
    
    .otp-subtitle {
        opacity: 0.95;
        font-size: 1rem;
        font-weight: 500;
    }
    
    .otp-body {
        padding: 3rem 2rem;
    }
    
    .otp-form-group {
        margin-bottom: 2rem;
    }
    
    .otp-label {
        display: block;
        color: #060530;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    
    .otp-input-group {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        margin-bottom: 1rem;
    }
    
    .otp-input {
        width: 50px;
        height: 60px;
        border: 2px solid #e1d3f0;
        border-radius: 10px;
        text-align: center;
        font-size: 1.5rem;
        font-weight: 700;
        color: #060530;
        background: white;
        transition: all 0.3s ease;
    }
    
    .otp-input:focus {
        outline: none;
        border-color: #8D68AD;
        box-shadow: 0 0 0 3px rgba(141, 104, 173, 0.1);
        transform: scale(1.05);
    }
    
    .otp-input.filled {
        background: linear-gradient(135deg, #f8f0ff, #e9ddf7);
        border-color: #8D68AD;
    }
    
    .email-display {
        background: linear-gradient(135deg, #f8f0ff, #e9ddf7);
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 1.5rem;
        border: 1px solid #e1d3f0;
        font-size: 0.9rem;
        color: #687693;
    }
    
    .email-value {
        font-weight: 600;
        color: #8D68AD;
    }
    
    .action-buttons {
        text-align: center;
    }
    
    .btn-verify {
        background: linear-gradient(135deg, #8D68AD, #A893C4);
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        margin-bottom: 1rem;
        box-shadow: 0 8px 20px rgba(141, 104, 173, 0.3);
    }
    
    .btn-verify:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(141, 104, 173, 0.4);
    }
    
    .btn-verify:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    .resend-section {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e1d3f0;
    }
    
    .resend-text {
        color: #687693;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .btn-resend {
        background: none;
        border: 2px solid #8D68AD;
        color: #8D68AD;
        padding: 10px 25px;
        border-radius: 25px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }
    
    .btn-resend:hover {
        background: #8D68AD;
        color: white;
        transform: translateY(-1px);
    }
    
    .countdown {
        color: #f56565;
        font-weight: 600;
        font-size: 0.9rem;
        margin-top: 0.5rem;
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
    
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #8D68AD;
        text-decoration: none;
        font-weight: 500;
        padding: 10px 20px;
        border-radius: 25px;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }
    
    .back-link:hover {
        background: rgba(141, 104, 173, 0.1);
        color: #060530;
        text-decoration: none;
    }
    
    @media (max-width: 768px) {
        .otp-verification-section {
            padding: 50px 0;
        }
        
        .otp-header {
            padding: 2rem 1.5rem;
        }
        
        .otp-title {
            font-size: 1.7rem;
        }
        
        .otp-body {
            padding: 2rem 1.5rem;
        }
        
        .otp-input {
            width: 45px;
            height: 55px;
            font-size: 1.3rem;
        }
        
        .btn-verify {
            padding: 12px 30px;
            font-size: 0.95rem;
        }
    }
</style>

<section class="otp-verification-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="otp-card">
                    <div class="otp-header">
                        <div class="otp-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h1 class="otp-title">Verify Your Code</h1>
                        <p class="otp-subtitle">Enter the 6-digit code sent to your email</p>
                    </div>
                    
                    <div class="otp-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
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
                        
                        <div class="email-display">
                            Code sent to: <span class="email-value">{{ session('email') }}</span>
                        </div>
                        
                        <form method="POST" action="{{ route('password.otp.verify') }}" id="otpForm">
                            @csrf
                            <input type="hidden" name="email" value="{{ session('email') }}">
                            
                            <div class="otp-form-group">
                                <label class="otp-label">Verification Code</label>
                                <div class="otp-input-group">
                                    <input type="text" class="otp-input" maxlength="1" id="otp1" name="otp1" required>
                                    <input type="text" class="otp-input" maxlength="1" id="otp2" name="otp2" required>
                                    <input type="text" class="otp-input" maxlength="1" id="otp3" name="otp3" required>
                                    <input type="text" class="otp-input" maxlength="1" id="otp4" name="otp4" required>
                                    <input type="text" class="otp-input" maxlength="1" id="otp5" name="otp5" required>
                                    <input type="text" class="otp-input" maxlength="1" id="otp6" name="otp6" required>
                                </div>
                                <input type="hidden" name="otp" id="otpFull">
                            </div>
                            
                            <div class="action-buttons">
                                <button type="submit" class="btn-verify" id="verifyBtn" disabled>
                                    <i class="fas fa-check me-2"></i>
                                    Verify Code
                                </button>
                            </div>
                        </form>
                        
                        <div class="resend-section">
                            <p class="resend-text">Didn't receive the code?</p>
                            
                            <form method="POST" action="{{ route('password.otp.resend') }}" id="resendForm" style="display: none;">
                                @csrf
                                <input type="hidden" name="email" value="{{ session('email') }}">
                                <button type="submit" class="btn-resend">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Resend Code
                                </button>
                            </form>
                            
                            <div class="countdown" id="countdown">
                                You can resend in <span id="timer">60</span> seconds
                            </div>
                            
                            <a href="{{ route('password.request') }}" class="back-link">
                                <i class="fas fa-arrow-left"></i>
                                Back to Forgot Password
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
    const otpInputs = document.querySelectorAll('.otp-input');
    const otpFull = document.getElementById('otpFull');
    const verifyBtn = document.getElementById('verifyBtn');
    const resendForm = document.getElementById('resendForm');
    const countdown = document.getElementById('countdown');
    const timer = document.getElementById('timer');
    
    // OTP input handling
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            const value = e.target.value;
            
            // Only allow numbers
            if (!/^\d$/.test(value) && value !== '') {
                e.target.value = '';
                return;
            }
            
            if (value) {
                input.classList.add('filled');
                // Move to next input
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            } else {
                input.classList.remove('filled');
            }
            
            updateOtpFull();
        });
        
        input.addEventListener('keydown', function(e) {
            // Handle backspace
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                otpInputs[index - 1].focus();
                otpInputs[index - 1].value = '';
                otpInputs[index - 1].classList.remove('filled');
                updateOtpFull();
            }
            
            // Handle arrow keys
            if (e.key === 'ArrowLeft' && index > 0) {
                otpInputs[index - 1].focus();
            }
            if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });
        
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const digits = paste.replace(/\D/g, '').slice(0, 6);
            
            digits.split('').forEach((digit, i) => {
                if (otpInputs[i]) {
                    otpInputs[i].value = digit;
                    otpInputs[i].classList.add('filled');
                }
            });
            
            updateOtpFull();
            
            if (digits.length === 6) {
                otpInputs[5].focus();
            }
        });
    });
    
    function updateOtpFull() {
        const otp = Array.from(otpInputs).map(input => input.value).join('');
        otpFull.value = otp;
        verifyBtn.disabled = otp.length !== 6;
    }
    
    // Countdown timer
    let timeLeft = 60;
    
    function updateCountdown() {
        timer.textContent = timeLeft;
        
        if (timeLeft <= 0) {
            countdown.style.display = 'none';
            resendForm.style.display = 'block';
        } else {
            timeLeft--;
            setTimeout(updateCountdown, 1000);
        }
    }
    
    updateCountdown();
    
    // Auto-focus first input
    otpInputs[0].focus();
});
</script>
@endsection
