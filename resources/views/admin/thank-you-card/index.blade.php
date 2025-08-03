@extends('admin.layout.app')
@section('title', 'Thank You Card Generator')

@section('content')

<style>
    :root {
        --primary-color: #8B7BA8;
        --primary-light: #A893C4;
        --primary-lighter: #C4B5D8;
        --primary-lightest: #E9E3F0;
        --primary-dark: #6B5B7D;
        --background: #F8F9FA;
        --white: #FFFFFF;
        --text-dark: #2D3748;
        --text-medium: #4A5568;
        --text-light: #718096;
        --border-light: #E2E8F0;
        --success: #48BB78;
        --warning: #ED8936;
        --danger: #F56565;
        --info: #4299E1;
        --shadow: 0 2px 8px rgba(0,0,0,0.1);
        --gradient-elegant: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-modern: linear-gradient(135deg, #ff9a9e 0%, #fecfef 50%, #fecfef 100%);
        --gradient-floral: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --gradient-minimal: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .thank-you-container {
        background: var(--background);
        min-height: 100vh;
        padding: 2rem;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: var(--white);
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        opacity: 0.9;
        margin: 0;
        font-size: 1rem;
    }

    .main-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .form-card {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .card-header {
        background: var(--primary-lightest);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-light);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-light);
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.2s ease;
        background: var(--white);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(139, 123, 168, 0.1);
    }

    .form-control.textarea {
        min-height: 120px;
        resize: vertical;
        font-family: inherit;
    }

    .style-selector {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .style-option {
        position: relative;
    }

    .style-option input[type="radio"] {
        display: none;
    }

    .style-card {
        display: block;
        padding: 1rem;
        border: 2px solid var(--border-light);
        border-radius: 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: var(--white);
        text-decoration: none;
        color: var(--text-dark);
    }

    .style-option input[type="radio"]:checked + .style-card {
        border-color: var(--primary-color);
        background: var(--primary-lightest);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 123, 168, 0.2);
    }

    .style-preview {
        width: 100%;
        height: 80px;
        border-radius: 8px;
        margin-bottom: 0.75rem;
        position: relative;
        overflow: hidden;
    }

    .style-elegant {
        background: var(--gradient-elegant);
    }

    .style-modern {
        background: var(--gradient-modern);
    }

    .style-floral {
        background: var(--gradient-floral);
    }

    .style-minimal {
        background: linear-gradient(135deg, #f7f8fc 0%, #ddd6fe 100%);
    }

    .style-name {
        font-weight: 600;
        font-size: 0.875rem;
        color: var(--text-dark);
    }

    .generate-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: var(--white);
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        width: 100%;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .generate-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(139, 123, 168, 0.3);
        background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
    }

    .preview-card {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
        height: fit-content;
        position: sticky;
        top: 2rem;
    }

    .preview-content {
        padding: 2rem;
        text-align: center;
        min-height: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f7f8fc 0%, #ddd6fe 100%);
        position: relative;
    }

    .preview-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="%23ffffff" opacity="0.3"/><circle cx="80" cy="20" r="2" fill="%23ffffff" opacity="0.3"/><circle cx="20" cy="80" r="2" fill="%23ffffff" opacity="0.3"/><circle cx="80" cy="80" r="2" fill="%23ffffff" opacity="0.3"/></svg>');
        opacity: 0.1;
    }

    .preview-logo {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
    }

    .preview-message {
        font-size: 1.125rem;
        color: var(--text-dark);
        line-height: 1.6;
        font-style: italic;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .preview-name {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
    }

    .preview-signature {
        font-size: 1rem;
        color: var(--text-medium);
        position: relative;
        z-index: 1;
    }

    .help-text {
        background: var(--info);
        color: var(--white);
        padding: 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .thank-you-container {
            padding: 1rem;
        }
        
        .main-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .style-selector {
            grid-template-columns: 1fr;
        }
        
        .preview-card {
            position: static;
        }
    }
</style>

<div class="thank-you-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-heart"></i>
            Thank You Card Generator
        </h1>
        <p class="page-subtitle">Create beautiful and personalized thank you cards for your customers</p>
    </div>

    <!-- Main Content -->
    <div class="main-grid">
        <!-- Form Card -->
        <div class="form-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    Card Details
                </h3>
            </div>
            <div class="card-body">
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    Create personalized thank you cards that will make your customers feel special and appreciated!
                </div>

                <form action="{{ route('admin.thank-you-card.generate') }}" method="POST" target="_blank">
                    @csrf
                    
                    <div class="form-group">
                        <label for="customer_name" class="form-label">Customer Name</label>
                        <input type="text" 
                               id="customer_name" 
                               name="customer_name" 
                               class="form-control" 
                               placeholder="Enter customer's name"
                               value="{{ old('customer_name') }}" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label">Thank You Message</label>
                        <textarea id="message" 
                                  name="message" 
                                  class="form-control textarea" 
                                  placeholder="Write your heartfelt thank you message..."
                                  required>{{ old('message', 'Thank you for choosing us! Your trust and support mean the world to us. We are committed to providing you with the best service and look forward to serving you again.') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Card Style</label>
                        <div class="style-selector">
                            <div class="style-option">
                                <input type="radio" id="elegant" name="card_style" value="elegant" checked>
                                <label for="elegant" class="style-card">
                                    <div class="style-preview style-elegant"></div>
                                    <div class="style-name">Elegant</div>
                                </label>
                            </div>
                            <div class="style-option">
                                <input type="radio" id="modern" name="card_style" value="modern">
                                <label for="modern" class="style-card">
                                    <div class="style-preview style-modern"></div>
                                    <div class="style-name">Modern</div>
                                </label>
                            </div>
                            <div class="style-option">
                                <input type="radio" id="floral" name="card_style" value="floral">
                                <label for="floral" class="style-card">
                                    <div class="style-preview style-floral"></div>
                                    <div class="style-name">Floral</div>
                                </label>
                            </div>
                            <div class="style-option">
                                <input type="radio" id="minimal" name="card_style" value="minimal">
                                <label for="minimal" class="style-card">
                                    <div class="style-preview style-minimal"></div>
                                    <div class="style-name">Minimal</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="signature" class="form-label">Signature (Optional)</label>
                        <input type="text" 
                               id="signature" 
                               name="signature" 
                               class="form-control" 
                               placeholder="e.g., Glowzel Team, John Doe, etc."
                               value="{{ old('signature', 'Glowzel Team') }}">
                    </div>

                    <button type="submit" class="generate-btn">
                        <i class="fas fa-magic"></i>
                        Generate Thank You Card
                    </button>
                </form>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="preview-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-eye"></i>
                    Live Preview
                </h3>
            </div>
            <div class="preview-content" id="preview-content">
                <div class="preview-logo">GLOWZEL</div>
                <div class="preview-message" id="preview-message">
                    Thank you for choosing us! Your trust and support mean the world to us. We are committed to providing you with the best service and look forward to serving you again.
                </div>
                <div class="preview-name" id="preview-name">Dear Valued Customer</div>
                <div class="preview-signature" id="preview-signature">— Glowzel Team</div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const customerNameInput = document.getElementById('customer_name');
    const messageInput = document.getElementById('message');
    const signatureInput = document.getElementById('signature');
    const styleInputs = document.querySelectorAll('input[name="card_style"]');
    
    const previewName = document.getElementById('preview-name');
    const previewMessage = document.getElementById('preview-message');
    const previewSignature = document.getElementById('preview-signature');
    const previewContent = document.getElementById('preview-content');

    // Update preview name
    customerNameInput.addEventListener('input', function() {
        const name = this.value.trim();
        previewName.textContent = name ? `Dear ${name}` : 'Dear Valued Customer';
    });

    // Update preview message
    messageInput.addEventListener('input', function() {
        previewMessage.textContent = this.value || 'Thank you for choosing us! Your trust and support mean the world to us.';
    });

    // Update preview signature
    signatureInput.addEventListener('input', function() {
        const signature = this.value.trim();
        previewSignature.textContent = signature ? `— ${signature}` : '— Glowzel Team';
    });

    // Update preview style
    styleInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked) {
                const style = this.value;
                previewContent.className = 'preview-content';
                
                switch(style) {
                    case 'elegant':
                        previewContent.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                        previewContent.style.color = '#ffffff';
                        break;
                    case 'modern':
                        previewContent.style.background = 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 50%, #fecfef 100%)';
                        previewContent.style.color = '#2D3748';
                        break;
                    case 'floral':
                        previewContent.style.background = 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)';
                        previewContent.style.color = '#2D3748';
                        break;
                    case 'minimal':
                        previewContent.style.background = 'linear-gradient(135deg, #f7f8fc 0%, #ddd6fe 100%)';
                        previewContent.style.color = '#2D3748';
                        break;
                }
            }
        });
    });
});
</script>

@endsection
