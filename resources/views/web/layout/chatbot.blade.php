<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dr. AI - Skincare Consultant | Taysan Beauty</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        background: #0f0f23;
        color: #ffffff;
        height: 100vh;
        overflow: hidden;
    }
    
    .chat-container {
        display: flex;
        flex-direction: column;
        height: 100vh;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .chat-header {
        padding: 16px 24px;
        border-bottom: 1px solid #2a2a3e;
        background: #0f0f23;
        position: sticky;
        top: 0;
        z-index: 100;
    }
    
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .logo-section {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .logo-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
    }
    
    .logo-text {
        font-size: 20px;
        font-weight: 600;
        color: #ffffff;
    }
    
    .header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .back-btn {
        background: #1a1a2e;
        border: 1px solid #2a2a3e;
        color: #a0a0a0;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        font-size: 14px;
    }
    
    .back-btn:hover {
        background: #2a2a3e;
        color: #ffffff;
        text-decoration: none;
    }
    
    .new-chat-btn {
        background: #7c3aed;
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        font-size: 14px;
    }
    
    .new-chat-btn:hover {
        background: #6d28d9;
    }
    
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 0;
        scrollbar-width: thin;
        scrollbar-color: #2a2a3e #0f0f23;
    }
    
    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }
    
    .chat-messages::-webkit-scrollbar-track {
        background: #0f0f23;
    }
    
    .chat-messages::-webkit-scrollbar-thumb {
        background: #2a2a3e;
        border-radius: 3px;
    }
    
    .message {
        padding: 24px;
        border-bottom: 1px solid #1a1a2e;
        max-width: 100%;
    }
    
    .message-content {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .user-message {
        background: #1a1a2e;
    }
    
    .bot-message {
        background: #0f0f23;
    }
    
    .message-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }
    
    .message-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    
    .user-avatar {
        background: #2a2a3e;
        color: #a0a0a0;
    }
    
    .bot-avatar {
        background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
        color: white;
    }
    
    .message-sender {
        font-weight: 600;
        font-size: 14px;
    }
    
    .user-sender {
        color: #e5e5e5;
    }
    
    .bot-sender {
        color: #a855f7;
    }
    
    .message-text {
        font-size: 15px;
        line-height: 1.6;
        color: #e5e5e5;
        white-space: pre-wrap;
    }
    
    .welcome-section {
        padding: 40px 24px;
        text-align: center;
        background: #0f0f23;
    }
    
    .welcome-content {
        max-width: 600px;
        margin: 0 auto;
    }
    
    .welcome-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: white;
        margin: 0 auto 24px;
    }
    
    .welcome-title {
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 12px;
    }
    
    .welcome-subtitle {
        font-size: 16px;
        color: #a0a0a0;
        margin-bottom: 32px;
        line-height: 1.5;
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 12px;
        margin-bottom: 32px;
    }
    
    .quick-action {
        background: #1a1a2e;
        border: 1px solid #2a2a3e;
        border-radius: 12px;
        padding: 16px 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .quick-action:hover {
        background: #2a2a3e;
        border-color: #7c3aed;
    }
    
    .quick-action-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: white;
        flex-shrink: 0;
    }
    
    .quick-action-text {
        flex: 1;
    }
    
    .quick-action-title {
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 4px;
        font-size: 15px;
    }
    
    .quick-action-desc {
        font-size: 13px;
        color: #a0a0a0;
    }
    
    .chat-input-container {
        padding: 20px 24px;
        background: #0f0f23;
        border-top: 1px solid #1a1a2e;
    }
    
    .input-wrapper {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
    }
    
    .input-box {
        width: 100%;
        min-height: 60px;
        max-height: 200px;
        padding: 16px 60px 16px 20px;
        background: #1a1a2e;
        border: 1px solid #2a2a3e;
        border-radius: 12px;
        color: #ffffff;
        font-size: 15px;
        font-family: inherit;
        resize: none;
        outline: none;
        transition: all 0.2s ease;
    }
    
    .input-box:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }
    
    .input-box::placeholder {
        color: #6b7280;
    }
    
    .send-button {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 36px;
        height: 36px;
        background: #7c3aed;
        border: none;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    
    .send-button:hover {
        background: #6d28d9;
    }
    
    .send-button:disabled {
        background: #374151;
        cursor: not-allowed;
    }
    
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .product-card {
        background: #1a1a2e;
        border: 1px solid #2a2a3e;
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    
    .product-card:hover {
        background: #2a2a3e;
        border-color: #7c3aed;
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(124, 58, 237, 0.2);
    }
    
    .product-image-container {
        position: relative;
        display: flex;
        justify-content: center;
    }
    
    .product-image {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #2a2a3e;
    }
    
    .sale-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 4px 8px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }
    
    .product-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .product-category {
        font-size: 12px;
        color: #7c3aed;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .product-name {
        font-weight: 700;
        color: #ffffff;
        font-size: 18px;
        line-height: 1.3;
    }
    
    .product-price-container {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .product-current-price {
        color: #10b981;
        font-weight: 700;
        font-size: 18px;
    }
    
    .product-original-price {
        color: #6b7280;
        font-size: 14px;
        text-decoration: line-through;
    }
    
    .product-badges {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    
    .product-badge {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .product-badge.organic {
        background: #065f46;
        color: #10b981;
    }
    
    .product-badge.vegan {
        background: #7c2d12;
        color: #fb923c;
    }
    
    .product-badge.cruelty-free {
        background: #1e40af;
        color: #60a5fa;
    }
    
    .recommendation-reason {
        background: rgba(124, 58, 237, 0.1);
        border: 1px solid rgba(124, 58, 237, 0.2);
        border-radius: 8px;
        padding: 12px;
        font-size: 14px;
        color: #e5e5e5;
        display: flex;
        align-items: flex-start;
        gap: 8px;
        line-height: 1.4;
    }
    
    .recommendation-reason i {
        color: #7c3aed;
        margin-top: 2px;
        flex-shrink: 0;
    }
    
    .product-description {
        font-size: 13px;
        color: #a0a0a0;
        line-height: 1.5;
    }
    
    .product-actions {
        display: flex;
        gap: 12px;
        margin-top: auto;
    }
    
    .view-details-btn,
    .buy-now-btn {
        flex: 1;
        padding: 12px 16px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .view-details-btn {
        background: #374151;
        color: #d1d5db;
        border: 1px solid #4b5563;
    }
    
    .view-details-btn:hover {
        background: #4b5563;
        color: #ffffff;
    }
    
    .buy-now-btn {
        background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
        color: white;
    }
    
    .buy-now-btn:hover {
        background: linear-gradient(135deg, #6d28d9 0%, #9333ea 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }
    
    /* Consultation Questions Styles */
    .consultation-questions {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .question-category h4 {
        color: #7c3aed;
        font-size: 16px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .question-options {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .question-btn {
        background: #2a2a3e;
        border: 1px solid #374151;
        border-radius: 8px;
        padding: 12px 16px;
        color: #e5e5e5;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .question-btn:hover {
        background: #374151;
        border-color: #7c3aed;
        color: #ffffff;
        transform: translateX(4px);
    }
    
    .question-btn i {
        color: #7c3aed;
        width: 16px;
    }
    
    .age-badge {
        background: #7c3aed;
        color: white;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        min-width: 40px;
        text-align: center;
    }
    
    .typing-indicator {
        display: flex;
        gap: 6px;
        padding: 16px 0;
    }
    
    .typing-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #7c3aed;
        animation: typing 1.4s infinite ease-in-out;
    }
    
    .typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .typing-dot:nth-child(2) { animation-delay: -0.16s; }
    
    @keyframes typing {
        0%, 80%, 100% { transform: scale(0.8); opacity: 0.5; }
        40% { transform: scale(1); opacity: 1; }
    }
    
    /* Bottom Navigation */
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #0f0f23;
        border-top: 1px solid #1a1a2e;
        padding: 12px 0;
        z-index: 1000;
    }
    
    .nav-container {
        max-width: 400px;
        margin: 0 auto;
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 0 20px;
    }
    
    .nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        padding: 8px 12px;
        border-radius: 8px;
        text-decoration: none;
        color: #6b7280;
        transition: all 0.2s ease;
        min-width: 60px;
    }
    
    .nav-item:hover,
    .nav-item.active {
        color: #7c3aed;
        background: rgba(124, 58, 237, 0.1);
        text-decoration: none;
    }
    
    .nav-icon {
        font-size: 20px;
    }
    
    .nav-text {
        font-size: 11px;
        font-weight: 500;
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .chat-header {
            padding: 12px 16px;
        }
        
        .header-content {
            flex-direction: row;
            gap: 12px;
        }
        
        .logo-text {
            font-size: 18px;
        }
        
        .chat-input-container {
            padding: 16px;
            padding-bottom: 80px;
        }
        
        .quick-actions {
            grid-template-columns: 1fr;
        }
        
        .product-grid {
            grid-template-columns: 1fr;
        }
        
        .product-card {
            padding: 16px;
        }
        
        .product-actions {
            flex-direction: column;
        }
        
        .view-details-btn,
        .buy-now-btn {
            width: 100%;
        }
        
        .welcome-section {
            padding: 32px 16px;
        }
        
        .message {
            padding: 20px 16px;
        }
    }
    
    @media (max-width: 480px) {
        .header-actions {
            gap: 8px;
        }
        
        .back-btn,
        .new-chat-btn {
            padding: 6px 12px;
            font-size: 13px;
        }
        
        .quick-action {
            padding: 12px 16px;
        }
        
        .product-image {
            width: 100px;
            height: 100px;
        }
        
        .product-name {
            font-size: 16px;
        }
        
        .recommendation-reason {
            padding: 10px;
            font-size: 13px;
        }
    }
    
    /* Hide elements on mobile when bottom nav is present */
    @media (max-width: 1199px) {
        .chat-input-container {
            padding-bottom: 100px;
        }
    }
    </style>
</head>

<body>
    <div class="chat-container">
        <!-- Header -->
        <div class="chat-header">
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo-icon">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div class="logo-text">Dr. AI</div>
                </div>
                <div class="header-actions">
                    <a href="{{ url()->previous() }}" class="back-btn">
                        <i class="fas fa-arrow-left"></i>
                        Back
                    </a>
                    <button class="new-chat-btn" onclick="newChat()">
                        <i class="fas fa-plus"></i>
                        New Chat
                    </button>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div class="chat-messages" id="chatMessages">
            @yield('chat-content')
        </div>

        <!-- Input -->
        <div class="chat-input-container">
            <div class="input-wrapper">
                <textarea 
                    id="messageInput" 
                    class="input-box" 
                    placeholder="Ask Dr. AI about your skin concerns..."
                    rows="1"></textarea>
                <button class="send-button" id="sendButton" onclick="sendMessage()">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation (Mobile Only) -->
    <div class="bottom-nav">
        <div class="nav-container">
            <a href="{{ route('web.view.index') }}" class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                <div class="nav-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="nav-text">Home</div>
            </a>
            
            <a href="{{ route('web.view.about') }}" class="nav-item {{ Request::is('about') ? 'active' : '' }}">
                <div class="nav-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="nav-text">About</div>
            </a>
            
            <a href="{{ route('web.view.shop') }}" class="nav-item {{ Request::is('shop*') ? 'active' : '' }}">
                <div class="nav-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="nav-text">Shop</div>
            </a>
            
            <a href="{{ route('web.chatbot') }}" class="nav-item active">
                <div class="nav-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="nav-text">Dr. AI</div>
            </a>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
