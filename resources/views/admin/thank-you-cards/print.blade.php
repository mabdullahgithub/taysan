<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cardData['title'] ?? 'Beautiful Card' }} - Print</title>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&family=Dancing+Script:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --card-purple: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --card-blue: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --card-green: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --card-pink: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --card-orange: linear-gradient(135deg, #fa8142 0%, #ffd89b 100%);
            --card-red: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%);
            --card-teal: linear-gradient(135deg, #48cae4 0%, #023e8a 100%);
            --card-indigo: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --white: #FFFFFF;
            --black: #1a1a1a;
            --shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 2rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .print-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'Poppins', sans-serif;
        }

        .btn-print {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .btn-back {
            background: white;
            color: #333;
            border: 2px solid #ddd;
        }

        .btn-back:hover {
            border-color: #667eea;
            color: #667eea;
        }

        .card-container {
            perspective: 1000px;
            margin: 0 auto;
        }

        .card {
            width: 400px;
            height: 280px;
            background: var(--white);
            border-radius: 24px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
            transition: transform 0.6s ease;
        }

        .card:hover {
            transform: rotateY(5deg) rotateX(5deg);
        }

        /* Card Color Backgrounds */
        .card-purple .card-header { background: var(--card-purple); }
        .card-blue .card-header { background: var(--card-blue); }
        .card-green .card-header { background: var(--card-green); }
        .card-pink .card-header { background: var(--card-pink); }
        .card-orange .card-header { background: var(--card-orange); }
        .card-red .card-header { background: var(--card-red); }
        .card-teal .card-header { background: var(--card-teal); }
        .card-indigo .card-header { background: var(--card-indigo); }

        .card-header {
            height: 120px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            overflow: hidden;
        }

        .card-header::before {
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

        .card-image {
            position: absolute;
            top: 10px;
            right: 15px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.3);
            z-index: 2;
        }

        .card-center-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255,255,255,0.4);
            margin-bottom: 1rem;
            z-index: 2;
            position: relative;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .company-logo {
            position: absolute;
            bottom: 10px;
            left: 15px;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: contain;
            background: rgba(255,255,255,0.9);
            padding: 4px;
            border: 2px solid rgba(255,255,255,0.3);
            z-index: 2;
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 0.5rem;
            z-index: 2;
            position: relative;
        }

        .card-title {
            font-family: 'Comfortaa', cursive;
            font-size: 1.8rem;
            font-weight: 700;
            text-align: center;
            z-index: 2;
            position: relative;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            text-align: center;
            margin-top: 0.25rem;
            z-index: 2;
            position: relative;
        }

        .card-body {
            padding: 1.5rem;
            height: 160px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .customer-name {
            font-family: 'Dancing Script', cursive;
            font-size: 1.4rem;
            font-weight: 600;
            color: #2d3748;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .card-message {
            font-size: 0.85rem;
            line-height: 1.5;
            color: #4a5568;
            text-align: center;
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }

        .offer-code {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        .ticket-number {
            background: #f7fafc;
            color: #2d3748;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            border: 2px solid #e2e8f0;
        }

        .card-signature {
            font-family: 'Dancing Script', cursive;
            font-size: 1rem;
            color: #718096;
            font-style: italic;
        }

        .decorative-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .decorative-elements::before,
        .decorative-elements::after {
            content: '';
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }

        .decorative-elements::before {
            top: -50px;
            left: -50px;
            animation: float 6s ease-in-out infinite;
        }

        .decorative-elements::after {
            bottom: -50px;
            right: -50px;
            animation: float 6s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Style variations */
        .style-modern {
            border-radius: 24px;
        }

        .style-elegant .card-title {
            font-family: 'Dancing Script', cursive;
        }

        .style-playful {
            transform: rotate(-2deg);
        }

        .style-playful:hover {
            transform: rotate(0deg) scale(1.02);
        }

        .style-professional {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .style-professional .card-header {
            height: 80px;
        }

        .style-professional .card-body {
            height: 200px;
        }

        /* Print Styles */
        @media print {
            @page {
                size: A4;
                margin: 15mm;
            }

            body {
                background: white !important;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
            }

            .print-controls {
                display: none !important;
            }

            .card {
                width: 150mm;
                height: 105mm;
                box-shadow: none !important;
                border: 2px solid #ddd;
                transform: none !important;
                margin: 20px;
            }

            .card:hover {
                transform: none !important;
            }

            .card-header {
                height: 45mm;
                padding: 5mm;
            }

            .card-body {
                height: 60mm;
                padding: 8mm;
            }

            .company-logo {
                width: 12mm;
                height: 12mm;
                bottom: 4mm;
                left: 6mm;
                box-shadow: none !important;
                border: 1px solid #eee !important;
            }

            .card-center-image {
                width: 20mm;
                height: 20mm;
                margin-bottom: 3mm;
                box-shadow: none !important;
                border: 2px solid #eee !important;
            }

            .card-message {
                font-size: 0.9rem;
            }

            /* Remove all shadows and decorative elements for print */
            * {
                box-shadow: none !important;
                text-shadow: none !important;
            }

            .decorative-elements::before,
            .decorative-elements::after,
            .card-header::before {
                display: none !important;
            }

            /* Ensure text is readable on print */
            .card-title,
            .card-subtitle,
            .customer-name,
            .card-message,
            .card-signature {
                text-shadow: none !important;
            }
        }

        /* Responsive */
        @media (max-width: 480px) {
            body {
                padding: 1rem;
            }

            .card {
                width: 100%;
                max-width: 350px;
            }

            .print-controls {
                position: static;
                justify-content: center;
                margin-bottom: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Print Controls -->
    <div class="print-controls">
        <button onclick="window.print()" class="btn btn-print">
            <i>🖨️</i>
            Print Card
        </button>
        <a href="{{ route('admin.thank-you-cards.create') }}" class="btn btn-back">
            <i>⬅️</i>
            Back to Create
        </a>
    </div>

    <!-- Card Container -->
    <div class="card-container">
        <div class="card card-{{ $cardData['card_color'] ?? 'purple' }} style-{{ $cardData['card_style'] ?? 'modern' }}">
            <!-- Decorative Elements -->
            <div class="decorative-elements"></div>

            <!-- Card Header -->
            <div class="card-header">
                <!-- Company Logo -->
                <img src="{{ asset('logo.png') }}" alt="Glowzel Logo" class="company-logo">

                <div style="text-align: center;">
                    @if(isset($cardData['image_path']) && $cardData['image_path'])
                        <!-- Show uploaded image in center -->
                        <img src="{{ asset('storage/' . $cardData['image_path']) }}" alt="Card Image" class="card-center-image">
                    @else
                        <!-- Show emoji icon if no image uploaded -->
                        @if($cardData['card_type'] === 'thank_you')
                            <div class="card-icon">💝</div>
                        @elseif($cardData['card_type'] === 'offer')
                            <div class="card-icon">🎯</div>
                        @elseif($cardData['card_type'] === 'ticket')
                            <div class="card-icon">🎫</div>
                        @else
                            <div class="card-icon">✨</div>
                        @endif
                    @endif

                    <h1 class="card-title">{{ $cardData['title'] ?? 'Beautiful Card' }}</h1>
                    @if(isset($cardData['subtitle']) && $cardData['subtitle'])
                        <p class="card-subtitle">{{ $cardData['subtitle'] }}</p>
                    @endif
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                @if(isset($cardData['customer_name']) && $cardData['customer_name'])
                    <div class="customer-name">Dear {{ $cardData['customer_name'] }},</div>
                @endif

                <div class="card-message">
                    {{ $cardData['message'] ?? 'Thank you for being amazing!' }}
                </div>

                <div class="card-footer">
                    <div>
                        @if($cardData['card_type'] === 'offer' && isset($cardData['offer_code']) && $cardData['offer_code'])
                            <div class="offer-code">
                                {{ $cardData['offer_code'] }}
                                @if(isset($cardData['offer_discount']) && $cardData['offer_discount'])
                                    - {{ $cardData['offer_discount'] }}
                                @endif
                            </div>
                        @elseif($cardData['card_type'] === 'ticket' && isset($cardData['ticket_number']) && $cardData['ticket_number'])
                            <div class="ticket-number">
                                #{{ $cardData['ticket_number'] }}
                            </div>
                        @endif
                    </div>
                    <div class="card-signature">
                        With love, Glowzel Team ❤️
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.card');
            
            // Add hover effect for non-touch devices
            if (!('ontouchstart' in window)) {
                card.addEventListener('mousemove', function(e) {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    const rotateX = (y - centerY) / 10;
                    const rotateY = (centerX - x) / 10;
                    
                    card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                });
                
                card.addEventListener('mouseleave', function() {
                    card.style.transform = 'rotateX(0deg) rotateY(0deg)';
                });
            }
        });
    </script>
</body>
</html>
