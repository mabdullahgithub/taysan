@extends('admin.layout.app')
@section('title', 'Create Thank You Cards')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap');
    
    :root {
        --primary-color: #8B7BA8;
        --primary-light: #A893C4;
        --primary-dark: #6B5B7D;
        --text-dark: #2D3748;
        --text-medium: #4A5568;
        --text-light: #718096;
        --border-light: #E2E8F0;
        --background: #F8F9FA;
        --white: #FFFFFF;
        --shadow: 0 4px 16px rgba(0,0,0,0.1);
        --shadow-hover: 0 8px 32px rgba(0,0,0,0.15);
    }

    .card-creator-container {
        background: var(--background);
        min-height: 100vh;
        padding: 2rem;
        font-family: 'Poppins', sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }

    .page-title {
        font-family: 'Comfortaa', cursive;
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 2;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-top: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .creator-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .form-card {
        background: var(--white);
        border-radius: 24px;
        padding: 2rem;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .form-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    .form-section-title {
        font-family: 'Comfortaa', cursive;
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 500;
        color: var(--text-medium);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--border-light);
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: var(--white);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(139, 123, 168, 0.1);
    }

    .form-select {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--border-light);
        border-radius: 12px;
        font-size: 0.95rem;
        background: var(--white);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .form-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(139, 123, 168, 0.1);
    }

    .card-type-selector {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .card-type-option {
        position: relative;
    }

    .card-type-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .card-type-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1.5rem 1rem;
        border: 2px solid var(--border-light);
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--white);
        text-align: center;
    }

    .card-type-option input[type="radio"]:checked + .card-type-label {
        border-color: var(--primary-color);
        background: rgba(139, 123, 168, 0.05);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 123, 168, 0.2);
    }

    .card-type-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: var(--primary-color);
    }

    .card-type-name {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .card-type-desc {
        font-size: 0.8rem;
        color: var(--text-light);
    }

    .color-selector {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
    }

    .color-option {
        position: relative;
    }

    .color-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .color-swatch {
        width: 100%;
        height: 3rem;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 3px solid transparent;
        position: relative;
    }

    .color-option input[type="radio"]:checked + .color-swatch {
        border-color: var(--text-dark);
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .color-swatch::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .color-option input[type="radio"]:checked + .color-swatch::after {
        opacity: 1;
    }

    .style-selector {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .style-option {
        position: relative;
    }

    .style-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .style-label {
        display: block;
        padding: 1rem;
        border: 2px solid var(--border-light);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        font-weight: 500;
    }

    .style-option input[type="radio"]:checked + .style-label {
        border-color: var(--primary-color);
        background: rgba(139, 123, 168, 0.05);
        color: var(--primary-color);
    }

    .preview-card {
        background: var(--white);
        border-radius: 24px;
        padding: 2rem;
        box-shadow: var(--shadow);
        position: sticky;
        top: 2rem;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .preview-placeholder {
        text-align: center;
        color: var(--text-light);
        font-style: italic;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 1rem 2rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
        box-shadow: 0 4px 12px rgba(139, 123, 168, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(139, 123, 168, 0.4);
    }

    .btn-secondary {
        background: var(--white);
        color: var(--text-dark);
        border: 2px solid var(--border-light);
    }

    .btn-secondary:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .file-upload {
        position: relative;
        display: inline-block;
        cursor: pointer;
        width: 100%;
    }

    .file-upload input[type="file"] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 1rem;
        border: 2px dashed var(--border-light);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-medium);
        text-align: center;
    }

    .file-upload:hover .file-upload-label {
        border-color: var(--primary-color);
        color: var(--primary-color);
        background: rgba(139, 123, 168, 0.05);
    }

    /* Color swatches */
    .color-purple { background: linear-gradient(135deg, #667eea, #764ba2); }
    .color-blue { background: linear-gradient(135deg, #4facfe, #00f2fe); }
    .color-green { background: linear-gradient(135deg, #43e97b, #38f9d7); }
    .color-pink { background: linear-gradient(135deg, #fa709a, #fee140); }
    .color-orange { background: linear-gradient(135deg, #fa8142, #ffd89b); }
    .color-red { background: linear-gradient(135deg, #ff6b6b, #feca57); }
    .color-teal { background: linear-gradient(135deg, #48cae4, #023e8a); }
    .color-indigo { background: linear-gradient(135deg, #667eea, #764ba2); }

    @media (max-width: 768px) {
        .creator-grid {
            grid-template-columns: 1fr;
        }
        
        .card-type-selector {
            grid-template-columns: 1fr;
        }
        
        .color-selector {
            grid-template-columns: repeat(3, 1fr);
        }
        
        .page-title {
            font-size: 2rem;
        }
    }
</style>

<div class="card-creator-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">✨ Create Beautiful Cards</h1>
        <p class="page-subtitle">Design stunning thank you cards, offers, and tickets for your customers</p>
    </div>

    <form action="{{ route('admin.thank-you-cards.preview') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="creator-grid">
            <!-- Form Section -->
            <div class="form-card">
                <h3 class="form-section-title">
                    <i class="fas fa-palette"></i>
                    Design Settings
                </h3>

                <!-- Card Type Selection -->
                <div class="form-group">
                    <label class="form-label">Card Type</label>
                    <div class="card-type-selector">
                        <div class="card-type-option">
                            <input type="radio" name="card_type" value="thank_you" id="type_thank_you" checked>
                            <label for="type_thank_you" class="card-type-label">
                                <div class="card-type-icon">💝</div>
                                <div class="card-type-name">Thank You</div>
                                <div class="card-type-desc">Express gratitude</div>
                            </label>
                        </div>
                        
                        <div class="card-type-option">
                            <input type="radio" name="card_type" value="offer" id="type_offer">
                            <label for="type_offer" class="card-type-label">
                                <div class="card-type-icon">🎯</div>
                                <div class="card-type-name">Offer</div>
                                <div class="card-type-desc">Special discounts</div>
                            </label>
                        </div>
                        
                        <div class="card-type-option">
                            <input type="radio" name="card_type" value="ticket" id="type_ticket">
                            <label for="type_ticket" class="card-type-label">
                                <div class="card-type-icon">🎫</div>
                                <div class="card-type-name">Ticket</div>
                                <div class="card-type-desc">Support tickets</div>
                            </label>
                        </div>
                        
                        <div class="card-type-option">
                            <input type="radio" name="card_type" value="custom" id="type_custom">
                            <label for="type_custom" class="card-type-label">
                                <div class="card-type-icon">✨</div>
                                <div class="card-type-name">Custom</div>
                                <div class="card-type-desc">Your design</div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Color Selection -->
                <div class="form-group">
                    <label class="form-label">Card Color</label>
                    <div class="color-selector">
                        <div class="color-option">
                            <input type="radio" name="card_color" value="purple" id="color_purple" checked>
                            <label for="color_purple" class="color-swatch color-purple"></label>
                        </div>
                        <div class="color-option">
                            <input type="radio" name="card_color" value="blue" id="color_blue">
                            <label for="color_blue" class="color-swatch color-blue"></label>
                        </div>
                        <div class="color-option">
                            <input type="radio" name="card_color" value="green" id="color_green">
                            <label for="color_green" class="color-swatch color-green"></label>
                        </div>
                        <div class="color-option">
                            <input type="radio" name="card_color" value="pink" id="color_pink">
                            <label for="color_pink" class="color-swatch color-pink"></label>
                        </div>
                        <div class="color-option">
                            <input type="radio" name="card_color" value="orange" id="color_orange">
                            <label for="color_orange" class="color-swatch color-orange"></label>
                        </div>
                        <div class="color-option">
                            <input type="radio" name="card_color" value="red" id="color_red">
                            <label for="color_red" class="color-swatch color-red"></label>
                        </div>
                        <div class="color-option">
                            <input type="radio" name="card_color" value="teal" id="color_teal">
                            <label for="color_teal" class="color-swatch color-teal"></label>
                        </div>
                        <div class="color-option">
                            <input type="radio" name="card_color" value="indigo" id="color_indigo">
                            <label for="color_indigo" class="color-swatch color-indigo"></label>
                        </div>
                    </div>
                </div>

                <!-- Style Selection -->
                <div class="form-group">
                    <label class="form-label">Card Style</label>
                    <div class="style-selector">
                        <div class="style-option">
                            <input type="radio" name="card_style" value="modern" id="style_modern" checked>
                            <label for="style_modern" class="style-label">Modern</label>
                        </div>
                        <div class="style-option">
                            <input type="radio" name="card_style" value="elegant" id="style_elegant">
                            <label for="style_elegant" class="style-label">Elegant</label>
                        </div>
                        <div class="style-option">
                            <input type="radio" name="card_style" value="playful" id="style_playful">
                            <label for="style_playful" class="style-label">Playful</label>
                        </div>
                        <div class="style-option">
                            <input type="radio" name="card_style" value="professional" id="style_professional">
                            <label for="style_professional" class="style-label">Professional</label>
                        </div>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-group">
                    <label class="form-label">Card Image (Optional)</label>
                    <div class="file-upload">
                        <input type="file" name="image" accept="image/*" id="card_image">
                        <label for="card_image" class="file-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Upload an image</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="form-card">
                <h3 class="form-section-title">
                    <i class="fas fa-edit"></i>
                    Content
                </h3>

                <!-- Basic Content -->
                <div class="form-group">
                    <label for="title" class="form-label">Card Title</label>
                    <input type="text" name="title" id="title" class="form-control" 
                           placeholder="e.g., Thank You!" 
                           value="{{ request('template_title') ?? old('title') }}" required>
                </div>

                <div class="form-group">
                    <label for="subtitle" class="form-label">Subtitle (Optional)</label>
                    <input type="text" name="subtitle" id="subtitle" class="form-control" 
                           placeholder="e.g., For being an amazing customer"
                           value="{{ old('subtitle') }}">
                </div>

                <div class="form-group">
                    <label for="customer_name" class="form-label">Customer Name (Optional)</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" 
                           placeholder="e.g., John Doe"
                           value="{{ old('customer_name') }}">
                </div>

                <div class="form-group">
                    <label for="message" class="form-label">Main Message</label>
                    <textarea name="message" id="message" class="form-control" rows="4" 
                              placeholder="Write your heartfelt message here..." required>{{ request('template_message') ?? old('message') }}</textarea>
                </div>

                <!-- Conditional Fields -->
                <div id="offer_fields" style="display: none;">
                    <div class="form-group">
                        <label for="offer_code" class="form-label">Offer Code</label>
                        <input type="text" name="offer_code" id="offer_code" class="form-control" placeholder="e.g., SAVE20">
                    </div>
                    
                    <div class="form-group">
                        <label for="offer_discount" class="form-label">Discount Amount</label>
                        <input type="text" name="offer_discount" id="offer_discount" class="form-control" placeholder="e.g., 20% OFF">
                    </div>
                </div>

                <div id="ticket_fields" style="display: none;">
                    <div class="form-group">
                        <label for="ticket_number" class="form-label">Ticket Number</label>
                        <input type="text" name="ticket_number" id="ticket_number" class="form-control" placeholder="e.g., TK-12345">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-eye"></i>
                        Preview Card
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Show/hide conditional fields based on card type
    document.querySelectorAll('input[name="card_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('offer_fields').style.display = 'none';
            document.getElementById('ticket_fields').style.display = 'none';
            
            if (this.value === 'offer') {
                document.getElementById('offer_fields').style.display = 'block';
            } else if (this.value === 'ticket') {
                document.getElementById('ticket_fields').style.display = 'block';
            }
        });
    });

    // File upload preview
    document.getElementById('card_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const label = document.querySelector('.file-upload-label span');
        
        if (file) {
            label.textContent = file.name;
        } else {
            label.textContent = 'Upload an image';
        }
    });

    // Handle template pre-selection
    document.addEventListener('DOMContentLoaded', function() {
        const templateType = '{{ request("template_type") }}';
        if (templateType) {
            // Pre-select the card type
            const cardTypeRadio = document.getElementById('type_' + templateType);
            if (cardTypeRadio) {
                cardTypeRadio.checked = true;
                cardTypeRadio.dispatchEvent(new Event('change'));
            }
        }
    });
</script>

@endsection
