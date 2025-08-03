@extends('web.layout.app')

@section('title', 'Reset Password - Glowzel')

@section('content')
<style>
    .reset-password-section {
        padding: 100px 0;
        background: linear-gradient(135deg, #f8f0ff 0%, #fff 100%);
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
    }
    
    .reset-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(141, 104, 173, 0.15);
        overflow: hidden;
        max-width: 500px;
        margin: 0 auto;
    }
    
    .reset-header {
        background: linear-gradient(135deg, #8D68AD, #A893C4);
        color: white;
        text-align: center;
        padding: 3rem 2rem;
        position: relative;
    }
    
    .reset-header::before {
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
    
    .reset-icon {
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
    
    .reset-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-family: 'Lora', serif;
    }
    
    .reset-subtitle {
        opacity: 0.95;
        font-size: 1rem;
        font-weight: 500;
    }
    
    .reset-body {
        padding: 3rem 2rem;
    }
    
    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }
    
    .form-label {
        display: block;
        color: #060530;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    
    .form-control {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #e1d3f0;
        border-radius: 15px;
        font-size: 1rem;
        color: #060530;
        background: white;
        transition: all 0.3s ease;
        padding-right: 50px;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #8D68AD;
        box-shadow: 0 0 0 3px rgba(141, 104, 173, 0.1);
        transform: translateY(-1px);
    }
    
    .form-control.error {
        border-color: #f56565;
        background: rgba(245, 101, 101, 0.03);
    }
    
    .password-toggle {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #8D68AD;
        cursor: pointer;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        z-index: 10;
        padding: 5px;
    }
    
    .password-toggle:hover {
        color: #060530;
    }
    
    .password-strength {
        margin-top: 0.5rem;
        padding: 10px 15px;
        border-radius: 10px;
        font-size: 0.85rem;
        display: none;
    }
    
    .password-strength.weak {
        background: rgba(245, 101, 101, 0.1);
        color: #e53e3e;
        border: 1px solid rgba(245, 101, 101, 0.2);
        display: block;
    }
    
    .password-strength.medium {
        background: rgba(251, 211, 141, 0.1);
        color: #d69e2e;
        border: 1px solid rgba(251, 211, 141, 0.2);
        display: block;
    }
    
    .password-strength.strong {
        background: rgba(72, 187, 120, 0.1);
        color: #38a169;
        border: 1px solid rgba(72, 187, 120, 0.2);
        display: block;
    }
    
    .password-requirements {
        margin-top: 1rem;
        padding: 15px;
        background: linear-gradient(135deg, #f8f0ff, #e9ddf7);
        border-radius: 12px;
        border: 1px solid #e1d3f0;
    }
    
    .password-requirements h6 {
        color: #060530;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .requirement {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
        color: #687693;
    }
    
    .requirement.met {
        color: #38a169;
    }
    
    .requirement-icon {
        width: 16px;
        text-align: center;
    }
    
    .email-display {
        background: linear-gradient(135deg, #f8f0ff, #e9ddf7);
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 2rem;
        border: 1px solid #e1d3f0;
        font-size: 0.9rem;
        color: #687693;
    }
    
    .email-value {
        font-weight: 600;
        color: #8D68AD;
    }
    
    .btn-reset {
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
        box-shadow: 0 8px 20px rgba(141, 104, 173, 0.3);
    }
    
    .btn-reset:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(141, 104, 173, 0.4);
    }
    
    .btn-reset:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    .alert {
        border-radius: 12px;
        border: none;
        margin-bottom: 2rem;
        padding: 1rem 1.5rem;
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
        margin-top: 1.5rem;
    }
    
    .back-link:hover {
        background: rgba(141, 104, 173, 0.1);
        color: #060530;
        text-decoration: none;
    }
    
    @media (max-width: 768px) {
        .reset-password-section {
            padding: 50px 0;
        }
        
        .reset-header {
            padding: 2rem 1.5rem;
        }
        
        .reset-title {
            font-size: 1.7rem;
        }
        
        .reset-body {
            padding: 2rem 1.5rem;
        }
        
        .form-control {
            padding: 12px 18px;
            padding-right: 45px;
        }
        
        .btn-reset {
            padding: 12px 30px;
            font-size: 0.95rem;
        }
    }
</style>

<section class="reset-password-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="reset-card">
                    <div class="reset-header">
                        <div class="reset-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <h1 class="reset-title">Set New Password</h1>
                        <p class="reset-subtitle">Create a strong password for your account</p>
                    </div>
                    
                    <div class="reset-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="email-display">
                            Resetting password for: <span class="email-value">{{ session('email') }}</span>
                        </div>
                        
                        <form method="POST" action="{{ route('password.new.update') }}" id="resetForm">
                            @csrf
                            <input type="hidden" name="email" value="{{ session('email') }}">
                            
                            <div class="form-group">
                                <label for="password" class="form-label">New Password</label>
                                <div style="position: relative;">
                                    <input type="password" 
                                           class="form-control @error('password') error @enderror" 
                                           id="password" 
                                           name="password" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="Enter your new password">
                                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="password-eye"></i>
                                    </button>
                                </div>
                                <div class="password-strength" id="passwordStrength"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <div style="position: relative;">
                                    <input type="password" 
                                           class="form-control @error('password_confirmation') error @enderror" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="Confirm your new password">
                                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye" id="password_confirmation-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="password-requirements">
                                <h6>Password Requirements:</h6>
                                <div class="requirement" id="length-req">
                                    <span class="requirement-icon"><i class="fas fa-times"></i></span>
                                    At least 8 characters
                                </div>
                                <div class="requirement" id="uppercase-req">
                                    <span class="requirement-icon"><i class="fas fa-times"></i></span>
                                    At least one uppercase letter
                                </div>
                                <div class="requirement" id="lowercase-req">
                                    <span class="requirement-icon"><i class="fas fa-times"></i></span>
                                    At least one lowercase letter
                                </div>
                                <div class="requirement" id="number-req">
                                    <span class="requirement-icon"><i class="fas fa-times"></i></span>
                                    At least one number
                                </div>
                                <div class="requirement" id="special-req">
                                    <span class="requirement-icon"><i class="fas fa-times"></i></span>
                                    At least one special character
                                </div>
                                <div class="requirement" id="match-req">
                                    <span class="requirement-icon"><i class="fas fa-times"></i></span>
                                    Passwords match
                                </div>
                            </div>
                            
                            <button type="submit" class="btn-reset" id="submitBtn" disabled>
                                <i class="fas fa-shield-alt me-2"></i>
                                Reset Password
                            </button>
                        </form>
                        
                        <div style="text-align: center;">
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
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password');
    const confirmField = document.getElementById('password_confirmation');
    const submitBtn = document.getElementById('submitBtn');
    
    // Password strength checking
    function checkPasswordStrength(password) {
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /\d/.test(password),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };
        
        const score = Object.values(requirements).filter(Boolean).length;
        
        // Update requirement indicators
        updateRequirement('length-req', requirements.length);
        updateRequirement('uppercase-req', requirements.uppercase);
        updateRequirement('lowercase-req', requirements.lowercase);
        updateRequirement('number-req', requirements.number);
        updateRequirement('special-req', requirements.special);
        
        // Show strength indicator
        const strengthEl = document.getElementById('passwordStrength');
        if (password.length === 0) {
            strengthEl.style.display = 'none';
        } else if (score < 3) {
            strengthEl.className = 'password-strength weak';
            strengthEl.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Weak password';
        } else if (score < 5) {
            strengthEl.className = 'password-strength medium';
            strengthEl.innerHTML = '<i class="fas fa-info-circle me-1"></i>Medium strength';
        } else {
            strengthEl.className = 'password-strength strong';
            strengthEl.innerHTML = '<i class="fas fa-check-circle me-1"></i>Strong password';
        }
        
        return score === 5;
    }
    
    function updateRequirement(id, met) {
        const req = document.getElementById(id);
        const icon = req.querySelector('.requirement-icon i');
        
        if (met) {
            req.classList.add('met');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-check');
        } else {
            req.classList.remove('met');
            icon.classList.remove('fa-check');
            icon.classList.add('fa-times');
        }
    }
    
    function checkPasswordMatch() {
        const password = passwordField.value;
        const confirm = confirmField.value;
        const match = password === confirm && confirm.length > 0;
        
        updateRequirement('match-req', match);
        
        return match;
    }
    
    function validateForm() {
        const password = passwordField.value;
        const isStrong = checkPasswordStrength(password);
        const isMatching = checkPasswordMatch();
        
        submitBtn.disabled = !(isStrong && isMatching);
    }
    
    passwordField.addEventListener('input', validateForm);
    confirmField.addEventListener('input', validateForm);
    
    // Initial validation
    validateForm();
});
</script>
@endsection
