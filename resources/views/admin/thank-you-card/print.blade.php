<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You Card - {{ $cardData['customer_name'] }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&family=Dancing+Script:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8B7BA8;
            --primary-light: #A893C4;
            --primary-dark: #6B5B7D;
            --text-dark: #2D3748;
            --text-medium: #4A5568;
            --text-light: #718096;
            --white: #FFFFFF;
            --gold: #FFD700;
            --rose: #FF69B4;
            --gradient-elegant: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-modern: linear-gradient(135deg, #ff9a9e 0%, #fecfef 50%, #fecfef 100%);
            --gradient-floral: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --gradient-minimal: linear-gradient(135deg, #f7f8fc 0%, #ddd6fe 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f5f5;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card-container {
            width: 400px;
            height: 600px;
            position: relative;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-radius: 20px;
            overflow: hidden;
            background: var(--white);
        }

        /* Elegant Style */
        .card-elegant {
            background: var(--gradient-elegant);
            color: var(--white);
            position: relative;
        }

        .card-elegant::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><circle cx="50" cy="50" r="20" fill="white" opacity="0.1"/><circle cx="150" cy="50" r="15" fill="white" opacity="0.1"/><circle cx="50" cy="150" r="15" fill="white" opacity="0.1"/><circle cx="150" cy="150" r="20" fill="white" opacity="0.1"/></svg>');
            opacity: 0.3;
        }

        .card-elegant .decorative-border {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 15px;
        }

        /* Modern Style */
        .card-modern {
            background: var(--gradient-modern);
            color: var(--text-dark);
            position: relative;
        }

        .card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><polygon points="10,30 30,10 50,30 70,10 90,30 90,90 10,90" fill="white" opacity="0.1"/></svg>');
        }

        /* Floral Style */
        .card-floral {
            background: var(--gradient-floral);
            color: var(--text-dark);
            position: relative;
        }

        .card-floral::before {
            content: '🌸 🌺 🌸 🌺 🌸';
            position: absolute;
            top: 30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 1.5rem;
            opacity: 0.3;
        }

        .card-floral::after {
            content: '🌺 🌸 🌺 🌸 🌺';
            position: absolute;
            bottom: 30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 1.5rem;
            opacity: 0.3;
        }

        /* Minimal Style */
        .card-minimal {
            background: var(--gradient-minimal);
            color: var(--text-dark);
            position: relative;
        }

        .card-minimal .decorative-corner {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 2px solid var(--primary-color);
        }

        .card-minimal .decorative-corner:nth-child(1) {
            top: 20px;
            left: 20px;
            border-right: none;
            border-bottom: none;
        }

        .card-minimal .decorative-corner:nth-child(2) {
            top: 20px;
            right: 20px;
            border-left: none;
            border-bottom: none;
        }

        .card-minimal .decorative-corner:nth-child(3) {
            bottom: 20px;
            left: 20px;
            border-right: none;
            border-top: none;
        }

        .card-minimal .decorative-corner:nth-child(4) {
            bottom: 20px;
            right: 20px;
            border-left: none;
            border-top: none;
        }

        .card-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 2rem;
            text-align: center;
        }

        .company-logo {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .company-logo-img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        .uploaded-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
            border: 4px solid rgba(255,255,255,0.4);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .card-elegant .company-logo {
            color: var(--gold);
        }

        .card-modern .company-logo {
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-floral .company-logo {
            color: #e91e63;
        }

        .card-minimal .company-logo {
            color: var(--primary-color);
        }

        .thank-you-text {
            font-family: 'Dancing Script', cursive;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }

        .customer-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-decoration: underline;
            text-decoration-thickness: 2px;
            text-underline-offset: 8px;
        }

        .card-elegant .customer-name {
            text-decoration-color: var(--gold);
        }

        .card-modern .customer-name {
            text-decoration-color: #667eea;
        }

        .card-floral .customer-name {
            text-decoration-color: #e91e63;
        }

        .card-minimal .customer-name {
            text-decoration-color: var(--primary-color);
        }

        .message-text {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            opacity: 0.9;
            font-style: italic;
            max-width: 300px;
        }

        .signature {
            font-family: 'Dancing Script', cursive;
            font-size: 1.3rem;
            font-weight: 600;
            opacity: 0.8;
            margin-top: auto;
        }

        .generated-date {
            position: absolute;
            bottom: 10px;
            right: 15px;
            font-size: 0.7rem;
            opacity: 0.6;
        }

        .print-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            gap: 10px;
        }

        .print-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .print-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .back-btn {
            background: #6C757D;
            color: var(--white);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .back-btn:hover {
            background: #5A6268;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
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
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .print-controls {
                display: none !important;
            }

            .card-container {
                width: 350px;
                height: 500px;
                box-shadow: none !important;
                page-break-inside: avoid;
                margin: 20mm auto !important;
                border: 2px solid #ddd !important;
                padding: 5mm !important;
            }

            .card-content {
                padding: 2rem 1.5rem;
            }

            .card-content img {
                box-shadow: none !important;
                border: 2px solid #eee !important;
            }

            .generated-date {
                display: none !important;
            }

            /* Remove all shadows and text-shadows for print */
            * {
                box-shadow: none !important;
                text-shadow: none !important;
            }

            /* Remove background patterns for print */
            .card-elegant::before,
            .card-modern::before,
            .card-floral::before,
            .card-floral::after {
                display: none !important;
            }

            /* Print-specific image styling */
            .company-logo-img {
                width: 15mm !important;
                height: 15mm !important;
                box-shadow: none !important;
                border: 1px solid #eee !important;
                margin-bottom: 3mm !important;
            }

            .uploaded-image {
                width: 25mm !important;
                height: 25mm !important;
                box-shadow: none !important;
                border: 2px solid #eee !important;
                margin-bottom: 5mm !important;
            }

            /* Ensure text is readable on print */
            .thank-you-text,
            .customer-name,
            .message-text,
            .signature {
                text-shadow: none !important;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-content > * {
            animation: fadeInUp 0.6s ease forwards;
        }

        .card-content > *:nth-child(2) { animation-delay: 0.1s; }
        .card-content > *:nth-child(3) { animation-delay: 0.2s; }
        .card-content > *:nth-child(4) { animation-delay: 0.3s; }
        .card-content > *:nth-child(5) { animation-delay: 0.4s; }
        .card-content > *:nth-child(6) { animation-delay: 0.5s; }

        /* Sparkle animation for elegant style */
        .card-elegant .sparkle {
            position: absolute;
            color: var(--gold);
            font-size: 1rem;
            animation: sparkle 2s infinite;
        }

        .sparkle:nth-child(1) { top: 15%; left: 15%; animation-delay: 0s; }
        .sparkle:nth-child(2) { top: 20%; right: 20%; animation-delay: 0.5s; }
        .sparkle:nth-child(3) { bottom: 25%; left: 20%; animation-delay: 1s; }
        .sparkle:nth-child(4) { bottom: 20%; right: 15%; animation-delay: 1.5s; }

        @keyframes sparkle {
            0%, 100% { opacity: 0; transform: scale(0.5); }
            50% { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>
    <!-- Print Controls -->
    <div class="print-controls">
        <button onclick="window.print()" class="print-btn">
            <i class="fas fa-print"></i>
            Print Card
        </button>
        <a href="{{ route('admin.thank-you-card.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Back
        </a>
    </div>

    <!-- Thank You Card -->
    <div class="card-container card-{{ $cardData['card_style'] }}">
        @if($cardData['card_style'] == 'elegant')
            <div class="decorative-border"></div>
            <div class="sparkle">✨</div>
            <div class="sparkle">⭐</div>
            <div class="sparkle">✨</div>
            <div class="sparkle">⭐</div>
        @endif

        @if($cardData['card_style'] == 'minimal')
            <div class="decorative-corner"></div>
            <div class="decorative-corner"></div>
            <div class="decorative-corner"></div>
            <div class="decorative-corner"></div>
        @endif

        <div class="card-content">
            <!-- Company logo as image -->
            <img src="{{ asset('logo.png') }}" alt="Taysan Logo" class="company-logo-img">
            
            @if(isset($cardData['image_path']) && $cardData['image_path'])
                <!-- Show uploaded image in center -->
                <img src="{{ asset('storage/' . $cardData['image_path']) }}" alt="Card Image" class="uploaded-image">
            @endif
            
            <div class="thank-you-text">Thank You!</div>
            <div class="customer-name">{{ $cardData['customer_name'] }}</div>
            <div class="message-text">{{ $cardData['message'] }}</div>
            <div class="signature">{{ $cardData['signature'] }}</div>
        </div>

        <div class="generated-date">{{ $cardData['generated_at'] }}</div>
    </div>

    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
    <script>
        // Auto-focus and smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            // Add a subtle hover effect to the card
            const card = document.querySelector('.card-container');
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
                this.style.transition = 'transform 0.3s ease';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Print function
        function printCard() {
            window.print();
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                printCard();
            }
        });
    </script>
</body>
</html>
