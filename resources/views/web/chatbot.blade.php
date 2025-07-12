@extends('web.layout.chatbot')

@section('chat-content')
<div class="welcome-section">
    <div class="welcome-content">
        <div class="welcome-icon">
            <i class="fas fa-user-md doctor-icon"></i>
        </div>
        <h1 class="welcome-title">Welcome to Doctor AI</h1>
        <p class="welcome-subtitle">Your personal skincare consultant powered by AI. Ask me anything about skincare, ingredients, routines, or skin concerns. I can also recommend Taysan Beauty products for your specific needs!</p>
        
        <div class="quick-actions">
            <div class="quick-action" onclick="selectQuickOption('What ingredients should I look for in a good cleanser for sensitive skin?')">
                <div class="quick-action-icon">
                    <i class="fas fa-flask"></i>
                </div>
                <div class="quick-action-text">
                    <div class="quick-action-title">Skincare Ingredients</div>
                    <div class="quick-action-desc">Learn about beneficial ingredients for your skin</div>
                </div>
            </div>
            
            <div class="quick-action" onclick="selectQuickOption('How do I build a simple skincare routine for my skin type?')">
                <div class="quick-action-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="quick-action-text">
                    <div class="quick-action-title">Skincare Routine</div>
                    <div class="quick-action-desc">Get advice on building an effective routine</div>
                </div>
            </div>
            
            <div class="quick-action" onclick="selectQuickOption('What can I do to treat and prevent acne breakouts?')">
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
            
            <div class="quick-action" onclick="selectQuickOption('Can you recommend some Taysan Beauty products for my dry skin?')">
                <div class="quick-action-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="quick-action-text">
                    <div class="quick-action-title">Product Recommendations</div>
                    <div class="quick-action-desc">Get personalized Taysan Beauty recommendations</div>
                </div>
            </div>
            
            <div class="quick-action" onclick="selectQuickOption('I have combination skin with an oily T-zone and dry cheeks. What kind of moisturizer should I use?')">
                <div class="quick-action-icon">
                    <i class="fas fa-spa"></i>
                </div>
                <div class="quick-action-text">
                    <div class="quick-action-title">Combination Skin</div>
                    <div class="quick-action-desc">Get advice for combination skin type</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let conversationStarted = false;
let messageCount = 0;
let firstResponseReceived = false;

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
    
    // Check if message is not skincare related
    if (!isMessageSkinCareRelated(message)) {
        hideTypingIndicator();
        addMessage("I'm a skincare specialist and can only answer questions related to skin care, skincare products, and beauty routines. If you have any questions about your skin concerns or would like product recommendations, I'd be happy to help with those!", 'bot');
        document.getElementById('sendButton').disabled = false;
        return;
    }
    
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
    .then(response => response.json())
    .then(data => {
        hideTypingIndicator();
        
        if (data.success) {
            addMessage(data.recommendations, 'bot');
            messageCount++;
            
            // For first response: explain concerns and automatically show products
            if (!firstResponseReceived) {
                firstResponseReceived = true;
                
                // Add continuation message with integrated product button
                setTimeout(() => {
                    addContinuationMessage();
                }, 800);
                
                // If we have products from backend, show them automatically after continuation message
                if (data.products && data.products.length > 0) {
                    setTimeout(() => {
                        addProductRecommendations(data.products);
                    }, 2500);
                }
            }
            // If directly requesting products
            else if (isRequestingProducts(message)) {
                if (data.products && data.products.length > 0) {
                    addProductRecommendations(data.products);
                } else {
                    addProductSuggestionPrompt();
                }
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

function isMessageSkinCareRelated(message) {
    const message_lower = message.toLowerCase();
    const skinCareKeywords = [
        'skin', 'acne', 'pimple', 'breakout', 'wrinkle', 'anti-aging', 'dry', 'oily', 
        'moisturizer', 'serum', 'cleanser', 'toner', 'exfoliat', 'spf', 'sunscreen', 
        'dark spot', 'pigment', 'sensitive', 'redness', 'routine', 'face', 'cream',
        'lotion', 'skincare', 'beauty', 'ingredient', 'product', 'hyaluronic', 'vitamin c',
        'retinol', 'salicylic', 'glycolic', 'acid', 'hydration', 'moistur', 'pore',
        'blackhead', 'whitehead', 'mask', 'facial', 'treatment', 'night', 'day',
        'eye', 'lip', 'oil', 'natural', 'organic'
    ];
    
    for (const keyword of skinCareKeywords) {
        if (message_lower.includes(keyword)) {
            return true;
        }
    }
    
    return false;
}

function isRequestingProducts(message) {
    const message_lower = message.toLowerCase();
    const productKeywords = [
        'recommend', 'suggest', 'product', 'what should i use', 'what can i use',
        'which product', 'show me', 'i need', 'buy', 'purchase', 'get'
    ];
    
    for (const keyword of productKeywords) {
        if (message_lower.includes(keyword)) {
            return true;
        }
    }
    
    return false;
}

function isSkinConcernMessage(message) {
    const message_lower = message.toLowerCase();
    const skinConcernKeywords = [
        'acne', 'pimple', 'breakout', 'wrinkle', 'anti-aging', 'dry skin', 'oily skin', 
        'dark spot', 'pigment', 'sensitive', 'redness', 'irritation', 'blackhead', 
        'whitehead', 'aging', 'fine line', 'blemish', 'scar', 'hyperpigmentation', 
        'dark circles', 'puffy', 'uneven skin tone', 'dull skin', 'skin problem'
    ];
    
    for (const keyword of skinConcernKeywords) {
        if (message_lower.includes(keyword)) {
            return true;
        }
    }
    
    return false;
}

function containsSkinTypeInfo(message) {
    const message_lower = message.toLowerCase();
    const skinTypeKeywords = [
        'dry skin', 'oily skin', 'combination skin', 'normal skin', 'sensitive skin',
        'my skin is dry', 'my skin is oily', 'my skin is sensitive', 'my skin is combination',
        'skin type', 'skin concern', 'skin problem', 'skin issue', 'suffer from'
    ];
    
    for (const keyword of skinTypeKeywords) {
        if (message_lower.includes(keyword)) {
            return true;
        }
    }
    
    return false;
}

function addSkinTypeQuestion() {
    const messagesContainer = document.getElementById('chatMessages');
    const questionDiv = document.createElement('div');
    questionDiv.className = 'message bot-message';
    
    questionDiv.innerHTML = `
        <div class="message-content">
            <div class="message-header">
                <div class="message-avatar bot-avatar">
                    <i class="fas fa-user-md doctor-icon"></i>
                </div>
                <div class="message-sender bot-sender">Doctor AI</div>
            </div>
            <div class="message-text">
                <p>To provide you with the most personalized skincare advice, could you please share:</p>
                <ol>
                    <li>Your skin type (dry, oily, combination, normal, or sensitive)</li>
                    <li>Any specific skin concerns you're experiencing (acne, aging, hyperpigmentation, etc.)</li>
                </ol>
                <p>This will help me tailor my recommendations specifically for your needs.</p>
            </div>
        </div>
    `;
    
    messagesContainer.appendChild(questionDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function addContinuationMessage() {
    const messagesContainer = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = 'message bot-message';
    
    messageDiv.innerHTML = `
        <div class="message-content">
            <div class="continuation-message glassmorphism-light">
                <i class="fas fa-comment-dots"></i>
                <span>Continue chatting for more personalized skincare advice and tips!</span>
                <button class="inline-product-btn" onclick="selectQuickOption('Show me products for my skin type')">
                    <i class="fas fa-magic"></i> View Products
                </button>
            </div>
        </div>
    `;
    
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function addMessage(content, sender) {
    const messagesContainer = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${sender}-message`;
    
    const senderName = sender === 'user' ? 'You' : 'Doctor AI';
    const avatarClass = sender === 'user' ? 'user-avatar' : 'bot-avatar';
    const senderClass = sender === 'user' ? 'user-sender' : 'bot-sender';
    const iconClass = sender === 'user' ? 'fa-user' : 'fa-user-md doctor-icon';
    
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

function addProductSuggestionPrompt() {
    const messagesContainer = document.getElementById('chatMessages');
    const productPromptDiv = document.createElement('div');
    productPromptDiv.className = 'message bot-message';
    
    productPromptDiv.innerHTML = `
        <div class="message-content">
            <div class="message-header">
                <div class="message-avatar bot-avatar">
                    <i class="fas fa-user-md doctor-icon"></i>
                </div>
                <div class="message-sender bot-sender">Doctor AI</div>
            </div>
            <div class="message-text glassmorphism-light">
                Based on your skin type and concerns I've analyzed, I can show you personalized Taysan Beauty products that would work best for you.
            </div>
            <div class="product-suggestions-prompt glassmorphism">
                <button onclick="selectQuickOption('Show me products for my skin type')">
                    <i class="fas fa-magic"></i> Get My Personalized Products
                </button>
            </div>
        </div>
    `;
    
    messagesContainer.appendChild(productPromptDiv);
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
                    <i class="fas fa-user-md doctor-icon"></i>
                </div>
                <div class="message-sender bot-sender">Doctor AI</div>
            </div>
            <div class="message-text glassmorphism-light">
                <p><strong>Perfect Products for Your Skin Type:</strong></p>
                <p>Based on my analysis of your skin concerns, here are the Taysan Beauty products I recommend:</p>
            </div>
            <div class="product-grid">
    `;
    
    products.forEach(product => {
        const currentPrice = product.is_on_sale && product.sale_price ? product.sale_price : product.price;
        const originalPrice = product.is_on_sale && product.sale_price ? product.price : null;
        const discountPercent = originalPrice ? Math.round(((originalPrice - currentPrice) / originalPrice) * 100) : 0;
        
        productHtml += `
            <div class="product-card glassmorphism">
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
                    <div class="recommendation-reason glassmorphism-light">
                        <i class="fas fa-lightbulb"></i>
                        <span><strong>Why this works for you:</strong> ${product.recommendation_reason}</span>
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

function showTypingIndicator() {
    const messagesContainer = document.getElementById('chatMessages');
    const typingDiv = document.createElement('div');
    typingDiv.className = 'message bot-message';
    typingDiv.id = 'typingIndicator';
    
    typingDiv.innerHTML = `
        <div class="message-content">
            <div class="message-header">
                <div class="message-avatar bot-avatar">
                    <i class="fas fa-user-md doctor-icon"></i>
                </div>
                <div class="message-sender bot-sender">Doctor AI</div>
            </div>
            <div class="typing-indicator glassmorphism-light">
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
