@extends('admin.layout.app')
@section('title', 'Preview Card')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&family=Dancing+Script:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap');
    
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

    .preview-container {
        background: var(--background);
        min-height: 100vh;
        padding: 2rem;
        font-family: 'Poppins', sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
        text-align: center;
    }

    .page-title {
        font-family: 'Comfortaa', cursive;
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .page-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        margin-top: 0.5rem;
    }

    .preview-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
        align-items: start;
    }

    .preview-section {
        background: var(--white);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: var(--shadow);
        text-align: center;
    }

    .preview-title {
        font-family: 'Comfortaa', cursive;
        font-size: 1.5rem;
        color: var(--text-dark);
        margin-bottom: 2rem;
    }

    /* Mini Card Preview Styles */
    .mini-card-container {
        perspective: 1000px;
        margin: 0 auto 2rem;
        display: inline-block;
    }

    .mini-card {
        width: 320px;
        height: 224px;
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        position: relative;
        overflow: hidden;
        transform-style: preserve-3d;
        transition: transform 0.4s ease;
    }

    .mini-card:hover {
        transform: rotateY(5deg) rotateX(5deg) scale(1.02);
    }

    /* Card Color Backgrounds */
    .card-purple .mini-card-header { background: linear-gradient(135deg, #667eea, #764ba2); }
    .card-blue .mini-card-header { background: linear-gradient(135deg, #4facfe, #00f2fe); }
    .card-green .mini-card-header { background: linear-gradient(135deg, #43e97b, #38f9d7); }
    .card-pink .mini-card-header { background: linear-gradient(135deg, #fa709a, #fee140); }
    .card-orange .mini-card-header { background: linear-gradient(135deg, #fa8142, #ffd89b); }
    .card-red .mini-card-header { background: linear-gradient(135deg, #ff6b6b, #feca57); }
    .card-teal .mini-card-header { background: linear-gradient(135deg, #48cae4, #023e8a); }
    .card-indigo .mini-card-header { background: linear-gradient(135deg, #667eea, #764ba2); }

    .mini-card-header {
        height: 96px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        overflow: hidden;
    }

    .mini-card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: shimmer 8s linear infinite;
    }

    @keyframes shimmer {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .mini-card-image {
        position: absolute;
        top: 8px;
        right: 12px;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.3);
        z-index: 2;
    }

    .mini-card-center-image {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255,255,255,0.4);
        margin-bottom: 0.5rem;
        z-index: 2;
        position: relative;
        box-shadow: 0 3px 9px rgba(0,0,0,0.2);
    }

    .mini-company-logo {
        position: absolute;
        bottom: 8px;
        left: 12px;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        object-fit: contain;
        background: rgba(255,255,255,0.9);
        padding: 3px;
        border: 2px solid rgba(255,255,255,0.3);
        z-index: 2;
    }

    .mini-card-icon {
        font-size: 2rem;
        margin-bottom: 0.3rem;
        z-index: 2;
        position: relative;
    }

    .mini-card-title {
        font-family: 'Comfortaa', cursive;
        font-size: 1.2rem;
        font-weight: 700;
        text-align: center;
        z-index: 2;
        position: relative;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .mini-card-subtitle {
        font-size: 0.7rem;
        opacity: 0.9;
        text-align: center;
        margin-top: 0.2rem;
        z-index: 2;
        position: relative;
    }

    .mini-card-body {
        padding: 1rem;
        height: 128px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .mini-customer-name {
        font-family: 'Dancing Script', cursive;
        font-size: 1rem;
        font-weight: 600;
        color: #2d3748;
        text-align: center;
        margin-bottom: 0.3rem;
    }

    .mini-card-message {
        font-size: 0.7rem;
        line-height: 1.4;
        color: #4a5568;
        text-align: center;
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 0.5rem;
    }

    .mini-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.5rem;
        font-size: 0.7rem;
    }

    .mini-offer-code {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.6rem;
        letter-spacing: 0.5px;
    }

    .mini-ticket-number {
        background: #f7fafc;
        color: #2d3748;
        padding: 0.2rem 0.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.6rem;
        border: 1px solid #e2e8f0;
    }

    .mini-card-signature {
        font-family: 'Dancing Script', cursive;
        font-size: 0.7rem;
        color: #718096;
        font-style: italic;
    }

    .card-details {
        background: var(--white);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: var(--shadow);
        position: sticky;
        top: 2rem;
    }

    .details-title {
        font-family: 'Comfortaa', cursive;
        font-size: 1.3rem;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-light);
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 500;
        color: var(--text-medium);
    }

    .detail-value {
        font-weight: 600;
        color: var(--text-dark);
        text-align: right;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        justify-content: center;
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

    .btn-success {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
        box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(72, 187, 120, 0.4);
    }

    @media (max-width: 768px) {
        .preview-grid {
            grid-template-columns: 1fr;
        }
        
        .mini-card {
            width: 280px;
            height: 196px;
        }
        
        .page-title {
            font-size: 1.8rem;
        }
    }
</style>

<div class="preview-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">✨ Card Preview</h1>
        <p class="page-subtitle">Your beautiful card is ready! Review and print when you're happy with it.</p>
    </div>

    <div class="preview-grid">
        <!-- Card Preview -->
        <div class="preview-section">
            <h2 class="preview-title">💳 Card Preview</h2>
            
            <div class="mini-card-container">
                <div class="mini-card card-{{ $cardData['card_color'] ?? 'purple' }}">
                    <!-- Card Header -->
                    <div class="mini-card-header">
                        <!-- Company Logo -->
                        <img src="{{ asset('logo.png') }}" alt="Glowzel Logo" class="mini-company-logo">

                        <div style="text-align: center;">
                            @if(isset($cardData['image_path']) && $cardData['image_path'])
                                <!-- Show uploaded image in center -->
                                <img src="{{ asset('storage/' . $cardData['image_path']) }}" alt="Card Image" class="mini-card-center-image">
                            @else
                                <!-- Show emoji icon if no image uploaded -->
                                @if($cardData['card_type'] === 'thank_you')
                                    <div class="mini-card-icon">💝</div>
                                @elseif($cardData['card_type'] === 'offer')
                                    <div class="mini-card-icon">🎯</div>
                                @elseif($cardData['card_type'] === 'ticket')
                                    <div class="mini-card-icon">🎫</div>
                                @else
                                    <div class="mini-card-icon">✨</div>
                                @endif
                            @endif

                            <h1 class="mini-card-title">{{ $cardData['title'] ?? 'Beautiful Card' }}</h1>
                            @if(isset($cardData['subtitle']) && $cardData['subtitle'])
                                <p class="mini-card-subtitle">{{ $cardData['subtitle'] }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="mini-card-body">
                        @if(isset($cardData['customer_name']) && $cardData['customer_name'])
                            <div class="mini-customer-name">Dear {{ $cardData['customer_name'] }},</div>
                        @endif

                        <div class="mini-card-message">
                            {{ Str::limit($cardData['message'] ?? 'Thank you for being amazing!', 80) }}
                        </div>

                        <div class="mini-card-footer">
                            <div>
                                @if($cardData['card_type'] === 'offer' && isset($cardData['offer_code']) && $cardData['offer_code'])
                                    <div class="mini-offer-code">
                                        {{ $cardData['offer_code'] }}
                                        @if(isset($cardData['offer_discount']) && $cardData['offer_discount'])
                                            - {{ $cardData['offer_discount'] }}
                                        @endif
                                    </div>
                                @elseif($cardData['card_type'] === 'ticket' && isset($cardData['ticket_number']) && $cardData['ticket_number'])
                                    <div class="mini-ticket-number">
                                        #{{ $cardData['ticket_number'] }}
                                    </div>
                                @endif
                            </div>
                            <div class="mini-card-signature">
                                Glowzel Team ❤️
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <form action="{{ route('admin.thank-you-cards.print') }}" method="POST" style="display: inline;">
                    @csrf
                    @foreach($cardData as $key => $value)
                        @if($key !== '_token')
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    @if(isset($cardData['image_path']))
                        <input type="hidden" name="existing_image" value="{{ $cardData['image_path'] }}">
                    @endif
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-print"></i>
                        Print This Card
                    </button>
                </form>
                
                <a href="{{ route('admin.thank-you-cards.create') }}" class="btn btn-secondary">
                    <i class="fas fa-edit"></i>
                    Edit Card
                </a>
            </div>
        </div>

        <!-- Card Details -->
        <div class="card-details">
            <h3 class="details-title">📋 Card Details</h3>
            
            <div class="detail-item">
                <span class="detail-label">Card Type:</span>
                <span class="detail-value">{{ ucfirst(str_replace('_', ' ', $cardData['card_type'])) }}</span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Title:</span>
                <span class="detail-value">{{ $cardData['title'] }}</span>
            </div>
            
            @if(isset($cardData['subtitle']) && $cardData['subtitle'])
            <div class="detail-item">
                <span class="detail-label">Subtitle:</span>
                <span class="detail-value">{{ $cardData['subtitle'] }}</span>
            </div>
            @endif
            
            @if(isset($cardData['customer_name']) && $cardData['customer_name'])
            <div class="detail-item">
                <span class="detail-label">Customer:</span>
                <span class="detail-value">{{ $cardData['customer_name'] }}</span>
            </div>
            @endif
            
            <div class="detail-item">
                <span class="detail-label">Color:</span>
                <span class="detail-value">{{ ucfirst($cardData['card_color']) }}</span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Style:</span>
                <span class="detail-value">{{ ucfirst($cardData['card_style']) }}</span>
            </div>
            
            @if($cardData['card_type'] === 'offer')
                @if(isset($cardData['offer_code']) && $cardData['offer_code'])
                <div class="detail-item">
                    <span class="detail-label">Offer Code:</span>
                    <span class="detail-value">{{ $cardData['offer_code'] }}</span>
                </div>
                @endif
                
                @if(isset($cardData['offer_discount']) && $cardData['offer_discount'])
                <div class="detail-item">
                    <span class="detail-label">Discount:</span>
                    <span class="detail-value">{{ $cardData['offer_discount'] }}</span>
                </div>
                @endif
            @endif
            
            @if($cardData['card_type'] === 'ticket' && isset($cardData['ticket_number']) && $cardData['ticket_number'])
            <div class="detail-item">
                <span class="detail-label">Ticket #:</span>
                <span class="detail-value">{{ $cardData['ticket_number'] }}</span>
            </div>
            @endif
            
            @if(isset($cardData['image_path']) && $cardData['image_path'])
            <div class="detail-item">
                <span class="detail-label">Image:</span>
                <span class="detail-value">✅ Uploaded</span>
            </div>
            @endif
            
            <div class="detail-item">
                <span class="detail-label">Created:</span>
                <span class="detail-value">{{ now()->format('M j, Y') }}</span>
            </div>
        </div>
    </div>
</div>

@endsection
