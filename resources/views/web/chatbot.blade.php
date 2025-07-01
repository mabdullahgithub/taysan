@extends('web.layout.chatbot')

@section('chat-content')
<div class="welcome-section">
    <div class="welcome-content">
        <div class="welcome-icon">
            <i class="fas fa-user-md"></i>
        </div>
        <h1 class="welcome-title">Welcome to Dr. AI</h1>
        <p class="welcome-subtitle">Your personal skincare consultant powered by AI. Ask me anything about skincare, ingredients, routines, or skin concerns. I can also recommend Taysan Beauty products when you're ready!</p>
        
        <div class="quick-actions">
            <div class="quick-action" onclick="selectQuickOption('What ingredients should I look for in a good cleanser?')">
                <div class="quick-action-icon">
                    <i class="fas fa-flask"></i>
                </div>
                <div class="quick-action-text">
                    <div class="quick-action-title">Skincare Ingredients</div>
                    <div class="quick-action-desc">Learn about beneficial ingredients for your skin</div>
                </div>
            </div>
            
            <div class="quick-action" onclick="selectQuickOption('How do I build a skincare routine for my skin type?')">
                <div class="quick-action-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="quick-action-text">
                    <div class="quick-action-title">Skincare Routine</div>
                    <div class="quick-action-desc">Get advice on building an effective routine</div>
                </div>
            </div>
            
            <div class="quick-action" onclick="selectQuickOption('I have acne-prone skin. What can I do to treat and prevent breakouts?')">
                <div class="quick-action-icon">
                    <i class="fas fa-droplet"></i>
                </div>
                <div class="quick-action-text">
                    <div class="quick-action-title">Acne Treatment</div>
                    <div class="quick-action-desc">Learn about acne causes and treatments</div>
                </div>
            </div>
            
            <div class="quick-action" onclick="selectQuickOption('What are the best anti-aging ingredients and how do they work?')">
                <div class="quick-action-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="quick-action-text">
                    <div class="quick-action-title">Anti-Aging</div>
                    <div class="quick-action-desc">Understand aging prevention and treatment</div>
                </div>
            </div>
            
            <div class="quick-action" onclick="selectQuickOption('Can you recommend some Taysan Beauty products for my skin concerns?')">
                <div class="quick-action-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="quick-action-text">
                    <div class="quick-action-title">Product Recommendations</div>
                    <div class="quick-action-desc">Get personalized Taysan Beauty recommendations</div>
                </div>
            </div>
            
            <div class="quick-action" onclick="selectQuickOption('I have combination skin with an oily T-zone and dry cheeks. I am 26 years old and need a balanced routine that can handle both oily and dry areas.')">
                <div class="quick-action-icon">
                    <i class="fas fa-spa"></i>
                </div>
                <div class="quick-action-text">
                    <div class="quick-action-title">Combination Skin</div>
                    <div class="quick-action-desc">Complete assessment for combination skin type</div>
                </div>
            </div>
            
            <div class="quick-action" onclick="selectQuickOption('I am new to skincare and want to build a complete routine. I am 22 years old with normal skin and want to maintain healthy skin and prevent future issues.')">
                <div class="quick-action-icon">
                    <i class="fas fa-balance-scale"></i>
                </div>
                <div class="quick-action-text">
                    <div class="quick-action-title">Complete Routine</div>
                    <div class="quick-action-desc">Complete assessment for building a skincare routine</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let conversationStarted = false;

function selectQuickOption(text) {
    document.getElementById('messageInput').value = text;
    sendMessage();
}

function newChat() {
    location.reload();
}

function sendMessage() {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    
    if (!message) return;
    
    // Hide welcome section when conversation starts
    if (!conversationStarted) {
        document.querySelector('.welcome-section').style.display = 'none';
        conversationStarted = true;
    }
    
    // Add user message
    addMessage(message, 'user');
    
    // Clear input and disable send button
    input.value = '';
    document.getElementById('sendButton').disabled = true;
    
    // Show typing indicator
    showTypingIndicator();
    
    // Auto-resize textarea
    input.style.height = 'auto';
    
    // Send to backend
    fetch('/chatbot/recommendations', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            skin_info: message
        })
    })
    .then(response => response.json())        .then(data => {
            hideTypingIndicator();
            
            if (data.success) {
                addMessage(data.recommendations, 'bot');
                
                // Only add product recommendations if we have products
                if (data.products && data.products.length > 0) {
                    addProductRecommendations(data.products);
                }
            } else {
                addMessage('I apologize, but I\'m experiencing technical difficulties right now. Please try again in a moment, or feel free to ask me any skincare questions!', 'bot');
            }
        })
    .catch(error => {
        hideTypingIndicator();
        addMessage('I\'m having trouble connecting right now. Please check your internet connection and try again.', 'bot');
        console.error('Chatbot error:', error);
    })
    .finally(() => {
        document.getElementById('sendButton').disabled = false;
    });
}

function addMessage(content, sender) {
    const messagesContainer = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${sender}-message`;
    
    const senderName = sender === 'user' ? 'You' : 'Dr. AI';
    const avatarClass = sender === 'user' ? 'user-avatar' : 'bot-avatar';
    const senderClass = sender === 'user' ? 'user-sender' : 'bot-sender';
    const iconClass = sender === 'user' ? 'fa-user' : 'fa-user-md';
    
    messageDiv.innerHTML = `
        <div class="message-content">
            <div class="message-header">
                <div class="message-avatar ${avatarClass}">
                    <i class="fas ${iconClass}"></i>
                </div>
                <div class="message-sender ${senderClass}">${senderName}</div>
            </div>
            <div class="message-text">${content}</div>
        </div>
    `;
    
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function addProductRecommendations(products) {
    const messagesContainer = document.getElementById('chatMessages');
    const productDiv = document.createElement('div');
    productDiv.className = 'message bot-message';
    
    let productHtml = `
        <div class="message-content">
            <div class="message-header">
                <div class="message-avatar bot-avatar">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="message-sender bot-sender">Dr. AI</div>
            </div>
            <div class="message-text">Here are the specific products I recommend for you:</div>
            <div class="product-grid">
    `;
    
    products.forEach(product => {
        const currentPrice = product.is_on_sale && product.sale_price ? product.sale_price : product.price;
        const originalPrice = product.is_on_sale && product.sale_price ? product.price : null;
        const discountPercent = originalPrice ? Math.round(((originalPrice - currentPrice) / originalPrice) * 100) : 0;
        
        productHtml += `
            <div class="product-card">
                <div class="product-image-container">
                    <img src="${product.image || '/logo.png'}" alt="${product.name}" class="product-image">
                    ${product.is_on_sale ? `<div class="sale-badge">${discountPercent}% OFF</div>` : ''}
                </div>
                <div class="product-info">
                    <div class="product-category">${product.category}</div>
                    <div class="product-name">${product.name}</div>
                    <div class="product-price-container">
                        <div class="product-current-price">PKR ${currentPrice}</div>
                        ${originalPrice ? `<div class="product-original-price">PKR ${originalPrice}</div>` : ''}
                    </div>
                    <div class="product-badges">
                        ${product.is_organic ? '<span class="product-badge organic">Organic</span>' : ''}
                        ${product.is_vegan ? '<span class="product-badge vegan">Vegan</span>' : ''}
                        ${product.is_cruelty_free ? '<span class="product-badge cruelty-free">Cruelty-Free</span>' : ''}
                    </div>
                    <div class="recommendation-reason">
                        <i class="fas fa-lightbulb"></i>
                        ${product.recommendation_reason}
                    </div>
                    ${product.description ? `<div class="product-description">${product.description.substring(0, 120)}${product.description.length > 120 ? '...' : ''}</div>` : ''}
                    <div class="product-actions">
                        <button class="view-details-btn" onclick="window.location.href='/product/${product.id}'">
                            <i class="fas fa-eye"></i>
                            View Details
                        </button>
                        <button class="buy-now-btn" onclick="buyNow(${product.id}, ${product.is_on_sale})">
                            <i class="fas fa-shopping-cart"></i>
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
    
    productHtml += `
            </div>
        </div>
    `;
    
    productDiv.innerHTML = productHtml;
    messagesContainer.appendChild(productDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function buyNow(productId, isOnSale) {
    // Redirect to checkout page for the specific product
    window.location.href = `/checkout/product/${productId}`;
}

function addFollowUpQuestions() {
    const messagesContainer = document.getElementById('chatMessages');
    const followUpDiv = document.createElement('div');
    followUpDiv.className = 'message bot-message';
    
    followUpDiv.innerHTML = `
        <div class="message-content">
            <div class="message-header">
                <div class="message-avatar bot-avatar">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="message-sender bot-sender">Dr. AI</div>
            </div>
            <div class="message-text">You can also answer these specific questions to help me understand your skin better:</div>
            <div class="consultation-questions">
                <div class="question-category">
                    <h4><i class="fas fa-user"></i> About You</h4>
                    <div class="question-options">
                        <button class="question-btn" onclick="selectDetailedOption('I am in my teens (13-19) with hormonal acne and oily skin')">
                            <span class="age-badge">13-19</span> Teenage skin with acne
                        </button>
                        <button class="question-btn" onclick="selectDetailedOption('I am in my twenties (20-29) with combination skin and occasional breakouts')">
                            <span class="age-badge">20-29</span> Young adult skin concerns
                        </button>
                        <button class="question-btn" onclick="selectDetailedOption('I am in my thirties (30-39) with early aging signs and dry skin')">
                            <span class="age-badge">30-39</span> Early aging prevention
                        </button>
                        <button class="question-btn" onclick="selectDetailedOption('I am 40+ with mature skin, wrinkles, and firmness concerns')">
                            <span class="age-badge">40+</span> Mature skin care
                        </button>
                    </div>
                </div>
                
                <div class="question-category">
                    <h4><i class="fas fa-eye"></i> Primary Concerns</h4>
                    <div class="question-options">
                        <button class="question-btn" onclick="selectDetailedOption('My main concern is controlling oily skin and preventing acne breakouts')">
                            <i class="fas fa-droplet"></i> Oil Control & Acne
                        </button>
                        <button class="question-btn" onclick="selectDetailedOption('I need deep hydration for very dry and flaky skin')">
                            <i class="fas fa-tint"></i> Severe Dryness
                        </button>
                        <button class="question-btn" onclick="selectDetailedOption('I want to fade dark spots and even out my skin tone')">
                            <i class="fas fa-sun"></i> Pigmentation Issues
                        </button>
                        <button class="question-btn" onclick="selectDetailedOption('I need gentle products for very sensitive and reactive skin')">
                            <i class="fas fa-leaf"></i> Sensitive Skin
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    messagesContainer.appendChild(followUpDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function selectDetailedOption(text) {
    document.getElementById('messageInput').value = text;
    sendMessage();
}

// Function to ask follow-up questions based on user input
function askFollowUpQuestions(userInput) {
    const lowercaseInput = userInput.toLowerCase();
    let followUpQuestions = [];
    
    if (lowercaseInput.includes('acne') || lowercaseInput.includes('pimple') || lowercaseInput.includes('breakout')) {
        followUpQuestions = [
            { icon: 'fas fa-calendar-alt', text: 'How long have you been experiencing acne?', category: 'Duration' },
            { icon: 'fas fa-map-marker-alt', text: 'Which areas of your face are most affected?', category: 'Location' },
            { icon: 'fas fa-pills', text: 'Have you tried any acne treatments before?', category: 'Treatment History' }
        ];
    } else if (lowercaseInput.includes('dark') || lowercaseInput.includes('spot') || lowercaseInput.includes('pigment')) {
        followUpQuestions = [
            { icon: 'fas fa-sun', text: 'Do you spend a lot of time in the sun?', category: 'Lifestyle' },
            { icon: 'fas fa-history', text: 'When did you first notice these dark spots?', category: 'Timeline' },
            { icon: 'fas fa-shield-alt', text: 'Do you regularly use sunscreen?', category: 'Sun Protection' }
        ];
    } else if (lowercaseInput.includes('wrinkle') || lowercaseInput.includes('aging') || lowercaseInput.includes('fine line')) {
        followUpQuestions = [
            { icon: 'fas fa-birthday-cake', text: 'What\'s your age range?', category: 'Age' },
            { icon: 'fas fa-eye', text: 'Are the lines around your eyes or mouth?', category: 'Location' },
            { icon: 'fas fa-clock', text: 'When do you notice the lines most?', category: 'Timing' }
        ];
    } else if (lowercaseInput.includes('dry') || lowercaseInput.includes('moistur')) {
        followUpQuestions = [
            { icon: 'fas fa-thermometer-half', text: 'Does your skin feel tight after washing?', category: 'Symptoms' },
            { icon: 'fas fa-snowflake', text: 'Is the dryness worse in winter?', category: 'Seasonal' },
            { icon: 'fas fa-tint', text: 'Do you drink enough water daily?', category: 'Hydration' }
        ];
    }
    
    if (followUpQuestions.length > 0) {
        addBotMessage("To provide the best recommendation, I need to understand your specific situation better. Please help me with these details:");
        addConsultationQuestions(followUpQuestions);
    }
}

// Function to add consultation questions to chat
function addConsultationQuestions(questions) {
    const chatMessages = document.getElementById('chatMessages');
    const questionsDiv = document.createElement('div');
    questionsDiv.className = 'message bot-message';
    questionsDiv.innerHTML = `
        <div class="message-content">
            <div class="consultation-questions">
                <div class="question-category">
                    <h4><i class="fas fa-user-md"></i> Please select or type your answer:</h4>
                    <div class="question-options">
                        ${questions.map(q => `
                            <button class="question-btn" onclick="sendQuestionResponse('${q.text}')">
                                <i class="${q.icon}"></i>
                                <span>${q.text}</span>
                                <small style="margin-left: auto; color: #9ca3af;">${q.category}</small>
                            </button>
                        `).join('')}
                    </div>
                </div>
            </div>
        </div>
    `;
    chatMessages.appendChild(questionsDiv);
    scrollToBottom();
}

// Function to handle question responses
function sendQuestionResponse(questionText) {
    sendMessage(questionText);
}

// Helper function to add bot message
function addBotMessage(text) {
    const messagesContainer = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = 'message bot-message';
    messageDiv.innerHTML = `
        <div class="message-content">
            <div class="message-header">
                <div class="message-avatar bot-avatar">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="message-sender bot-sender">Dr. AI</div>
            </div>
            <div class="message-text">${text}</div>
        </div>
    `;
    messagesContainer.appendChild(messageDiv);
    scrollToBottom();
}

function scrollToBottom() {
    const messagesContainer = document.getElementById('chatMessages');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function showTypingIndicator() {
    const messagesContainer = document.getElementById('chatMessages');
    const typingDiv = document.createElement('div');
    typingDiv.className = 'message bot-message';
    typingDiv.id = 'typingIndicator';
    
    typingDiv.innerHTML = `
        <div class="message-content">
            <div class="message-header">
                <div class="message-avatar bot-avatar">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="message-sender bot-sender">Dr. AI</div>
            </div>
            <div class="typing-indicator">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        </div>
    `;
    
    messagesContainer.appendChild(typingDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function hideTypingIndicator() {
    const typingIndicator = document.getElementById('typingIndicator');
    if (typingIndicator) {
        typingIndicator.remove();
    }
}

// Auto-resize textarea
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('messageInput');
    
    input.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 200) + 'px';
    });
    
    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
});
</script>
@endsection
