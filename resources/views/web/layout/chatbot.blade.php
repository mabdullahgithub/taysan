<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skincare Assistant | Glowzel Beauty</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/chatbot-custom.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
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
                    <div class="logo-text">Doctor AI</div>
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
                    placeholder="Ask about your skin concerns..."
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
                    <i class="fas fa-spa"></i>
                </div>
                <div class="nav-text">Skincare AI</div>
            </a>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
