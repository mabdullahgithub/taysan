<!-- Reviews Section -->
<div class="reviews-section" id="reviewsSection">
    <div class="reviews-header">
        <div class="reviews-title-row">
            <h2 class="reviews-title">
                <i class="fas fa-star"></i>
                Customer Reviews
            </h2>
            <button class="btn-write-review" onclick="openReviewModal()">
                <i class="fas fa-plus"></i>
                Write a Review
            </button>
        </div>
    </div>

    <!-- Rating Summary -->
    <div class="rating-summary">
        <div class="rating-overview">
            <div class="overall-rating">
                <div class="rating-score">{{ $reviewsData['average_rating'] ?: '0.0' }}</div>
                <div class="rating-stars">
                    @php
                        $avgRating = $reviewsData['average_rating'] ?? 0;
                        $fullStars = floor($avgRating);
                        $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                    @endphp
                    
                    @for($i = 0; $i < $fullStars; $i++)
                        <i class="fas fa-star filled"></i>
                    @endfor
                    
                    @if($hasHalfStar)
                        <i class="fas fa-star-half-alt half"></i>
                    @endif
                    
                    @for($i = 0; $i < $emptyStars; $i++)
                        <i class="far fa-star empty"></i>
                    @endfor
                </div>
                <div class="rating-count">Based on {{ $reviewsData['total_reviews'] }} review{{ $reviewsData['total_reviews'] != 1 ? 's' : '' }}</div>
            </div>
            
            <div class="rating-breakdown">
                @for($star = 5; $star >= 1; $star--)
                    @php
                        $distribution = $reviewsData['rating_distribution'][$star] ?? ['count' => 0, 'percentage' => 0];
                    @endphp
                    <div class="rating-bar">
                        <span class="star-label">{{ $star }} <i class="fas fa-star"></i></span>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $distribution['percentage'] }}%"></div>
                        </div>
                        <span class="count">{{ $distribution['count'] }}</span>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Reviews Sort -->
    <div class="reviews-filters">
        <div class="filter-group">
            <label for="sortFilter">Sort by:</label>
            <select id="sortFilter" onchange="sortReviews()">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="highest">Highest Rating</option>
                <option value="lowest">Lowest Rating</option>
                <option value="helpful">Most Helpful</option>
                <option value="likes">Most Liked</option>
            </select>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="reviews-list" id="reviewsList">
        @forelse($reviewsData['recent_reviews'] as $review)
            @include('web.product.partials.review-item', ['review' => $review])
        @empty
            <div class="no-reviews">
                <div class="no-reviews-icon">
                    <i class="far fa-comment"></i>
                </div>
                <h3>No reviews yet</h3>
                <p>Be the first to review this product!</p>
                <button class="btn-write-first-review" onclick="openReviewModal()">
                    Write the first review
                </button>
            </div>
        @endforelse
    </div>

    <!-- Load More Button -->
    @if($reviewsData['total_reviews'] > count($reviewsData['recent_reviews']))
    <div class="load-more-container">
        <button class="btn-load-more" onclick="loadMoreReviews()">
            <i class="fas fa-plus"></i>
            Load More Reviews
        </button>
    </div>
    @endif
</div>

<!-- Review Modal -->
<div class="review-modal" id="reviewModal" onclick="closeReviewModal(event)">
    <div class="review-modal-content" onclick="event.stopPropagation()">
        <!-- Step 1: Order Verification -->
        <div class="order-verification-step" id="orderVerificationStep">
            <div class="review-modal-header">
                <h3>Verify Your Purchase</h3>
                <button class="review-modal-close" onclick="closeReviewModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="order-verification-content">
                <div class="verification-icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <h4>Enter Your Order ID</h4>
                <p>To ensure authentic reviews, please provide your 8-digit order ID from any of your previous purchases with us.</p>
                
                <form id="orderVerificationForm" onsubmit="verifyOrder(event)">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="form-group">
                        <label for="orderIdInput">Order ID *</label>
                        <input type="text" id="orderIdInput" name="order_id" placeholder="Enter your 8-digit order ID (e.g., 12345678)" maxlength="8" pattern="[0-9]{8}" required>
                        <small>Enter any valid order ID from your purchases. You can find your order ID in your email confirmation or order history.</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="closeReviewModal()">Cancel</button>
                        <button type="submit" class="btn-verify-order">
                            <i class="fas fa-check"></i>
                            Verify Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Step 2: Review Form (Hidden initially) -->
        <div class="review-form-step" id="reviewFormStep" style="display: none;">
            <div class="review-modal-header">
                <h3>Write Your Review</h3>
                <button class="review-modal-close" onclick="closeReviewModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="reviewForm" onsubmit="submitMultiReview(event)">
                @csrf
                <input type="hidden" name="order_reference" id="verifiedOrderId">
                
                <div class="order-success-info">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="success-text">
                        <h5>Order Verified Successfully!</h5>
                        <p>Order ID: <span id="displayOrderId"></span></p>
                        <p class="text-muted">You can review one or more products now, and come back later to review the rest anytime.</p>
                    </div>
                </div>

                <!-- Order Items Container -->
                <div id="orderItemsContainer" class="order-items-container">
                    <!-- Order items will be populated here -->
                </div>
                
                <!-- Common Details Section -->
                <div class="common-details-section">
                    <h5><i class="fas fa-user"></i> Your Details</h5>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="reviewName">Your Name *</label>
                            <input type="text" id="reviewName" name="name" placeholder="Enter your name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="reviewEmail">Email Address *</label>
                            <input type="email" id="reviewEmail" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="reviewLocation">Location</label>
                        <select id="reviewLocation" name="location">
                            <option value="">Select your location (optional)</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="India">India</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Canada">Canada</option>
                            <option value="Australia">Australia</option>
                            <option value="Germany">Germany</option>
                            <option value="France">France</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeReviewModal()">Cancel</button>
                    <button type="submit" class="btn-submit-review">
                        <i class="fas fa-paper-plane"></i> Submit Selected Reviews
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Reviews Section Styles */
.reviews-section {
    margin-top: 60px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.reviews-header {
    padding: 30px;
    border-bottom: 1px solid #eee;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.reviews-title-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.reviews-title {
    font-size: 1.8rem;
    font-weight: 600;
    color: var(--text-color);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.reviews-title i {
    color: #FFD700;
}

.btn-write-review {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-write-review:hover {
    background: var(--primary-light);
    transform: translateY(-2px);
}

/* Rating Summary */
.rating-summary {
    padding: 30px;
    border-bottom: 1px solid #eee;
}

.rating-overview {
    display: grid;
    grid-template-columns: auto 1fr;
    gap: 40px;
    align-items: center;
}

.overall-rating {
    text-align: center;
}

.rating-score {
    font-size: 3rem;
    font-weight: 700;
    color: var(--primary-color);
    line-height: 1;
    margin-bottom: 8px;
}

.rating-stars {
    margin-bottom: 8px;
}

.rating-stars i {
    font-size: 1.2rem;
    margin: 0 2px;
}

.rating-stars .filled {
    color: #FFD700;
}

.rating-stars .half {
    color: #FFD700;
}

.rating-stars .empty {
    color: #ddd;
}

.rating-count {
    font-size: 0.9rem;
    color: var(--text-light);
    margin: 0;
}

.rating-breakdown {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.rating-bar {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.85rem;
}

.star-label {
    min-width: 60px;
    color: var(--text-color);
    display: flex;
    align-items: center;
    gap: 4px;
}

.star-label i {
    color: #FFD700;
    font-size: 0.8rem;
}

.progress-bar {
    flex: 1;
    height: 8px;
    background: #f0f0f0;
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #FFD700, #FFA500);
    transition: width 0.3s ease;
}

.count {
    min-width: 30px;
    text-align: right;
    color: var(--text-light);
}

/* Reviews Filters */
.reviews-filters {
    padding: 20px 30px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.5);
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.filter-group label {
    font-weight: 600;
    color: var(--text-color);
    font-size: 0.9rem;
    white-space: nowrap;
}

.filter-group select {
    padding: 10px 14px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    background: white;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.filter-group select:hover {
    border-color: var(--primary-color);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.filter-group select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(141, 104, 173, 0.2);
}

/* Reviews List */
.reviews-list {
    padding: 30px;
}

/* No Reviews State */
.no-reviews {
    text-align: center;
    padding: 60px 20px;
    color: var(--text-light);
}

.no-reviews-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    color: #ddd;
}

.no-reviews h3 {
    font-size: 1.5rem;
    margin-bottom: 10px;
    color: var(--text-color);
}

.no-reviews p {
    font-size: 1rem;
    margin-bottom: 30px;
}

.btn-write-first-review {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-write-first-review:hover {
    background: var(--primary-light);
    transform: translateY(-2px);
}

/* Load More Button */
.load-more-container {
    text-align: center;
    padding: 30px;
    border-top: 1px solid #eee;
}

.btn-load-more {
    background: transparent;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0 auto;
}

.btn-load-more:hover {
    background: var(--primary-color);
    color: white;
}

/* Review Modal */
.review-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1050;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.review-modal.active {
    display: flex;
}

.review-modal-content {
    background: white;
    border-radius: 12px;
    width: 100%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.review-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 25px 30px;
    border-bottom: 1px solid #eee;
    background: #f8f9fa;
}

.review-modal-header h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-color);
    margin: 0;
}

.review-modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: var(--text-light);
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.review-modal-close:hover {
    background: #e9ecef;
    color: var(--text-color);
}

/* Order Verification Styles */
.order-verification-content {
    padding: 40px 30px;
    text-align: center;
}

.verification-icon {
    font-size: 4rem;
    color: var(--primary-color);
    margin-bottom: 20px;
}

.order-verification-content h4 {
    font-size: 1.5rem;
    color: var(--text-color);
    margin-bottom: 15px;
    font-weight: 600;
}

.order-verification-content p {
    color: var(--text-light);
    margin-bottom: 30px;
    line-height: 1.6;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.order-success-info {
    display: flex;
    align-items: center;
    gap: 15px;
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    border: 1px solid #c3e6cb;
    border-radius: 8px;
    padding: 15px 20px;
    margin-bottom: 25px;
}

.success-icon {
    color: #155724;
    font-size: 1.5rem;
}

.success-text h5 {
    color: #155724;
    margin: 0 0 5px 0;
    font-size: 1rem;
    font-weight: 600;
}

.success-text p {
    color: #155724;
    margin: 0;
    font-size: 0.9rem;
}

.btn-verify-order {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-verify-order:hover {
    background: var(--primary-light);
}

.btn-verify-order:disabled {
    background: #6c757d;
    cursor: not-allowed;
}

.btn-back {
    background: #6c757d;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-back:hover {
    background: #545b62;
}

/* Review Form */
#reviewForm {
    padding: 30px;
}

.review-product-info {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    align-items: center;
}

.review-product-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    flex-shrink: 0;
}

.review-product-details h4 {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0 0 8px 0;
    color: var(--text-color);
}

.review-product-details p {
    font-size: 0.9rem;
    color: var(--text-light);
    margin: 0;
    line-height: 1.4;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    font-weight: 500;
    color: var(--text-color);
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: border-color 0.3s ease;
    background: white;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: var(--primary-color);
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

.form-group small {
    display: block;
    margin-top: 5px;
    font-size: 0.8rem;
    color: var(--text-light);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.character-count {
    text-align: right;
    margin-top: 5px;
    font-size: 0.8rem;
    color: var(--text-light);
}

/* Star Rating Input */
.star-rating-input {
    display: flex;
    gap: 5px;
    margin-bottom: 8px;
}

.star-input {
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
    transition: all 0.2s ease;
}

.star-input:hover,
.star-input.filled {
    color: #FFD700;
    transform: scale(1.1);
}

.rating-label {
    font-size: 0.9rem;
    color: var(--text-light);
    font-style: italic;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
    justify-content: flex-end;
}

.btn-cancel {
    background: #6c757d;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #545b62;
}

.btn-submit-review {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-submit-review:hover {
    background: var(--primary-light);
}

.btn-submit-review:disabled {
    background: #6c757d;
    cursor: not-allowed;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .reviews-title-row {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }
    
    .btn-write-review {
        justify-content: center;
    }
    
    .rating-overview {
        grid-template-columns: 1fr;
        gap: 30px;
        text-align: center;
    }
    
    .reviews-filters {
        flex-direction: column;
        gap: 20px;
        align-items: stretch;
    }
    
    .filter-group {
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
    }
    
    .filter-group select {
        width: 100%;
    }
    
    .reviews-list,
    .rating-summary,
    .reviews-header {
        padding: 20px;
    }
    
    .review-modal-content {
        margin: 10px;
        max-height: calc(100vh - 20px);
    }
    
    .review-modal-header {
        padding: 20px;
    }
    
    #reviewForm {
        padding: 20px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .review-product-info {
        flex-direction: column;
        text-align: center;
    }
    
    .review-product-image {
        align-self: center;
    }
}

/* Order Items Review Styles */
.order-items-container {
    margin: 20px 0;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
}

.order-item-review {
    border-bottom: 1px solid #e9ecef;
    background: #fff;
    transition: background-color 0.3s ease;
}

.order-item-review:last-child {
    border-bottom: none;
}

.order-item-review.already-reviewed {
    background: #f8f9fa;
    opacity: 0.7;
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
}

.item-info {
    display: flex;
    align-items: center;
    gap: 15px;
    flex: 1;
}

.item-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.item-details h6 {
    margin: 0 0 5px 0;
    font-weight: 600;
    color: #333;
}

.item-details p {
    margin: 0 0 8px 0;
    color: #666;
    font-size: 0.9rem;
}

.item-details small {
    display: block;
    margin-top: 5px;
    font-size: 0.8rem;
}

.text-info {
    color: #17a2b8 !important;
}

.text-muted {
    color: #6c757d !important;
}

.badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.badge-primary {
    background: #007bff;
    color: white;
}

.badge-secondary {
    background: #6c757d;
    color: white;
}

.badge-success {
    background: #28a745;
    color: white;
}

.review-toggle {
    display: flex;
    align-items: center;
}

/* Toggle Switch Styles */
.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #007bff;
}

input:focus + .slider {
    box-shadow: 0 0 1px #007bff;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

input:disabled + .slider {
    background-color: #e9ecef;
    cursor: not-allowed;
}

/* Review Fields Styles */
.review-fields {
    padding: 0 20px 20px 20px;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    display: none;
}

.review-fields.active {
    display: block;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        max-height: 0;
    }
    to {
        opacity: 1;
        max-height: 500px;
    }
}

.review-fields .form-group {
    margin-bottom: 15px;
}

.review-fields label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
}

.review-fields input,
.review-fields textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.review-fields input:focus,
.review-fields textarea:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.star-rating-input {
    display: flex;
    gap: 5px;
    margin-bottom: 5px;
}

.star-rating-input .star-input {
    font-size: 1.5rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s ease;
}

.star-rating-input .star-input:hover,
.star-rating-input .star-input.fas {
    color: #FFD700;
}

.rating-label {
    font-size: 0.9rem;
    color: #666;
    margin-top: 5px;
}

.character-count {
    text-align: right;
    font-size: 0.8rem;
    color: #666;
    margin-top: 5px;
}

.common-details-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
    border: 1px solid #e9ecef;
}

.common-details-section h5 {
    margin: 0 0 15px 0;
    color: #333;
    display: flex;
    align-items: center;
    gap: 8px;
}

.common-details-section h5 i {
    color: #007bff;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media (max-width: 768px) {
    .item-header {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }
    
    .item-info {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .review-toggle {
        justify-content: center;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .review-fields {
        padding: 15px;
    }
}

@media (max-width: 480px) {
    .reviews-title {
        font-size: 1.5rem;
    }
    
    .rating-score {
        font-size: 2.5rem;
    }
    
    .star-input {
        font-size: 1.8rem;
    }
}
</style>

<script>
// Reviews functionality
let currentPage = 1;
let currentSort = 'newest';
let isLoading = false; // Prevent multiple simultaneous requests

// Character counter and input validation
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== Reviews section initialized ===');
    console.log('Initial total reviews:', {{ $reviewsData['total_reviews'] ?? 0 }});
    console.log('Initial loaded reviews:', {{ count($reviewsData['recent_reviews'] ?? []) }});
    
    // Initialize current page based on initial data
    currentPage = 1;
    
    // Check if load more button should be visible
    const totalReviews = {{ $reviewsData['total_reviews'] ?? 0 }};
    const loadedReviews = {{ count($reviewsData['recent_reviews'] ?? []) }};
    const loadMoreContainer = document.querySelector('.load-more-container');
    
    if (loadMoreContainer) {
        if (totalReviews > loadedReviews) {
            loadMoreContainer.style.display = 'block';
            console.log('Load more button should be visible');
        } else {
            loadMoreContainer.style.display = 'none';
            console.log('Load more button hidden - no more reviews');
        }
    }
    
    const textarea = document.getElementById('reviewComment');
    const charCount = document.getElementById('charCount');
    
    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }
    
    // Order ID input validation
    const orderIdInput = document.getElementById('orderIdInput');
    if (orderIdInput) {
        orderIdInput.addEventListener('input', function() {
            // Remove any non-digit characters
            this.value = this.value.replace(/\D/g, '');
            
            // Limit to 8 digits
            if (this.value.length > 8) {
                this.value = this.value.substring(0, 8);
            }
        });
    }
});

// Review modal functions
function openReviewModal() {
    document.getElementById('reviewModal').classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Reset to order verification step
    document.getElementById('orderVerificationStep').style.display = 'block';
    document.getElementById('reviewFormStep').style.display = 'none';
    
    // Reset forms
    document.getElementById('orderVerificationForm').reset();
    document.getElementById('reviewForm').reset();
    setRating(0);
    if (document.getElementById('charCount')) {
        document.getElementById('charCount').textContent = '0';
    }
}

function closeReviewModal(event) {
    if (event && event.target !== event.currentTarget) return;
    
    document.getElementById('reviewModal').classList.remove('active');
    document.body.style.overflow = '';
    
    // Reset to order verification step
    document.getElementById('orderVerificationStep').style.display = 'block';
    document.getElementById('reviewFormStep').style.display = 'none';
    
    // Reset forms
    document.getElementById('orderVerificationForm').reset();
    document.getElementById('reviewForm').reset();
    
    // Clear order items container
    const orderItemsContainer = document.getElementById('orderItemsContainer');
    if (orderItemsContainer) {
        orderItemsContainer.innerHTML = '';
    }
    
    // Reset verified order ID
    document.getElementById('verifiedOrderId').value = '';
    document.getElementById('displayOrderId').textContent = '';
}

// Order verification
async function verifyOrder(event) {
    event.preventDefault();
    
    const submitBtn = document.querySelector('.btn-verify-order');
    const originalText = submitBtn.innerHTML;
    
    // Disable button and show loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
    
    try {
        const formData = new FormData(event.target);
        
        // Get CSRF token
        let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            csrfToken = document.querySelector('[name="_token"]')?.value;
        }
        
        if (!csrfToken) {
            throw new Error('CSRF token not found');
        }
        
        console.log('Sending verification request with order ID:', formData.get('order_id'));
        
        const response = await fetch(`/products/{{ $product->id }}/verify-order`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            if (response.status === 422) {
                // Handle validation errors
                const errorData = await response.json();
                console.log('Validation errors:', errorData);
                
                if (errorData.errors) {
                    let errorMessage = 'Please fix the following errors:\n';
                    Object.entries(errorData.errors).forEach(([field, errors]) => {
                        errors.forEach(error => {
                            errorMessage += '• ' + error + '\n';
                        });
                    });
                    console.error('Validation errors:', errorMessage);
                } else {
                    console.error('Validation error:', errorData.message || 'Please check your order ID format.');
                }
                return;
            } else if (response.status === 419) {
                throw new Error('CSRF token mismatch - page expired');
            } else {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
        }
        
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Invalid response format - expected JSON');
        }
        
        const result = await response.json();
        console.log('Response result:', result);
        
        if (result.success) {
            console.log('Order verification successful, result:', result);
            
            // Store order ID for review submission
            document.getElementById('verifiedOrderId').value = result.order_id;
            document.getElementById('displayOrderId').textContent = result.order_id;
            
            // Display order items
            console.log('Displaying order items:', result.order_items);
            displayOrderItems(result.order_items);
            
            // Populate customer details if available
            if (result.customer_name) {
                document.getElementById('reviewName').value = result.customer_name;
            }
            if (result.customer_email) {
                document.getElementById('reviewEmail').value = result.customer_email;
            }
            
            // Switch to review form
            document.getElementById('orderVerificationStep').style.display = 'none';
            document.getElementById('reviewFormStep').style.display = 'block';
        } else {
            console.error('Order verification failed:', result.message || 'Order verification failed. Please check your order ID and make sure it\'s a valid 8-digit number from your order confirmation.');
        }
    } catch (error) {
        console.error('Error verifying order:', error);
        
        if (error.message.includes('CSRF')) {
            console.error('Security token error. Please refresh the page and try again.');
        } else if (error.message.includes('419')) {
            console.error('Session expired. Please refresh the page and try again.');
        } else {
            console.error('An error occurred while verifying your order. Please try again.');
        }
    } finally {
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
}

// Go back to order verification
function goBackToOrderVerification() {
    document.getElementById('orderVerificationStep').style.display = 'block';
    document.getElementById('reviewFormStep').style.display = 'none';
}

// Sort function
function sortReviews() {
    currentSort = document.getElementById('sortFilter').value;
    currentPage = 1;
    loadReviews();
}

// Load reviews with sorting
async function loadReviews() {
    try {
        const params = new URLSearchParams({
            sort: currentSort,
            page: 1 // Always start from page 1 when sorting
        });
        
        const response = await fetch(`/products/{{ $product->id }}/reviews?${params}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.reviews) {
            updateReviewsList(data.reviews.data);
            updateRatingSummary(data);
            
            // Reset current page to 1 since we're reloading
            currentPage = 1;
            
            // Update load more button visibility
            const loadMoreBtn = document.querySelector('.btn-load-more');
            const loadMoreContainer = document.querySelector('.load-more-container');
            
            if (loadMoreBtn && loadMoreContainer) {
                const hasMorePages = data.reviews.current_page < data.reviews.last_page;
                if (hasMorePages) {
                    loadMoreContainer.style.display = 'block';
                    loadMoreBtn.style.display = 'flex';
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.innerHTML = '<i class="fas fa-plus"></i> Load More Reviews';
                } else {
                    loadMoreContainer.style.display = 'none';
                }
            }
        }
    } catch (error) {
        console.error('Error loading reviews:', error);
    }
}

// Load more reviews
async function loadMoreReviews() {
    console.log('=== loadMoreReviews called ===');
    
    if (isLoading) {
        console.log('Already loading, ignoring request');
        return;
    }
    
    const loadMoreBtn = document.querySelector('.btn-load-more');
    if (!loadMoreBtn) {
        console.error('Load more button not found');
        return;
    }
    
    // Set loading state
    isLoading = true;
    const originalText = loadMoreBtn.innerHTML;
    loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    loadMoreBtn.disabled = true;
    
    console.log('Current page before increment:', currentPage);
    const nextPage = currentPage + 1;
    console.log('Loading page:', nextPage, 'with sort:', currentSort);
    
    try {
        const params = new URLSearchParams({
            sort: currentSort,
            page: nextPage
        });
        
        const url = `/products/{{ $product->id }}/reviews?${params}`;
        console.log('Fetching URL:', url);
        
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('Load more response data:', data);
        
        if (data.reviews && data.reviews.data && data.reviews.data.length > 0) {
            console.log('Appending', data.reviews.data.length, 'new reviews');
            appendReviews(data.reviews.data);
            
            // Update current page only after successful load
            currentPage = nextPage;
            
            // Check if there are more pages
            const hasMorePages = data.reviews.current_page < data.reviews.last_page;
            console.log('Has more pages:', hasMorePages, 'Current page:', data.reviews.current_page, 'Last page:', data.reviews.last_page);
            
            if (!hasMorePages) {
                console.log('No more pages, hiding load more button');
                loadMoreBtn.style.display = 'none';
            } else {
                // Restore button state for next load
                loadMoreBtn.innerHTML = originalText;
                loadMoreBtn.disabled = false;
            }
        } else {
            // No more reviews to load
            console.log('No more reviews to load');
            loadMoreBtn.style.display = 'none';
        }
    } catch (error) {
        console.error('Error loading more reviews:', error);
        
        // Restore button state (don't increment currentPage since request failed)
        loadMoreBtn.innerHTML = originalText;
        loadMoreBtn.disabled = false;
    } finally {
        // Always reset loading state
        isLoading = false;
    }
}

// Update reviews list
function updateReviewsList(reviews) {
    const reviewsList = document.getElementById('reviewsList');
    
    if (reviews.length === 0) {
        reviewsList.innerHTML = `
            <div class="no-reviews">
                <div class="no-reviews-icon">
                    <i class="far fa-comment"></i>
                </div>
                <h3>No reviews yet</h3>
                <p>Be the first to review this product!</p>
                <button class="btn-write-first-review" onclick="openReviewModal()">
                    Write the first review
                </button>
            </div>
        `;
    } else {
        reviewsList.innerHTML = reviews.map(review => generateReviewHTML(review)).join('');
    }
}

// Append more reviews
function appendReviews(reviews) {
    console.log('=== appendReviews called with', reviews.length, 'reviews ===');
    const reviewsList = document.getElementById('reviewsList');
    
    if (!reviewsList) {
        console.error('Reviews list container not found');
        return;
    }
    
    if (!reviews || reviews.length === 0) {
        console.log('No reviews to append');
        return;
    }
    
    try {
        const reviewsHTML = reviews.map(review => generateReviewHTML(review)).join('');
        console.log('Generated HTML for', reviews.length, 'reviews');
        
        // Check if we have existing reviews (not the "no reviews" message)
        const noReviewsElement = reviewsList.querySelector('.no-reviews');
        if (noReviewsElement) {
            // Replace the "no reviews" message with the new reviews
            reviewsList.innerHTML = reviewsHTML;
        } else {
            // Append to existing reviews
            reviewsList.insertAdjacentHTML('beforeend', reviewsHTML);
        }
        
        console.log('Successfully appended reviews to DOM');
        
        // Show success message
        console.log(`Loaded ${reviews.length} more review${reviews.length !== 1 ? 's' : ''}`);
        
    } catch (error) {
        console.error('Error appending reviews:', error);
    }
}

// Generate review HTML
function generateReviewHTML(review) {
    if (!review) {
        console.error('Invalid review data provided to generateReviewHTML');
        return '';
    }
    
    // Safely handle missing data with proper defaults
    const reviewId = review.id || 0;
    const rating = Math.max(1, Math.min(5, parseInt(review.rating) || 0));
    const name = (review.masked_name || review.name || 'Anonymous').toString();
    const title = (review.title || 'Review').toString();
    const comment = (review.comment || '').toString();
    const date = (review.formatted_date || 'Recently').toString();
    const location = (review.location || '').toString();
    const helpfulVotes = parseInt(review.helpful_votes_count) || 0;
    const likesCount = parseInt(review.likes_count) || 0;
    const initials = (review.initials || name.substring(0, 2).toUpperCase() || 'AN').toString();
    const isVerified = review.is_verified_buyer === true || review.is_verified_buyer === 1;
    
    // Generate stars HTML
    const stars = Array.from({length: 5}, (_, i) => {
        const isFilled = i < rating;
        return `<i class="fa${isFilled ? 's' : 'r'} fa-star ${isFilled ? 'filled' : 'empty'}"></i>`;
    }).join('');
    
    const verifiedBadge = isVerified ? 
        '<span class="verified-badge"><i class="fas fa-check-circle"></i> Verified Buyer</span>' : '';
    
    const locationHtml = location ? 
        `<span class="review-location"><i class="fas fa-map-marker-alt"></i> ${location}</span>` : '';
    
    return `
        <div class="review-item" data-review-id="${reviewId}">
            <div class="review-header">
                <div class="reviewer-info">
                    <div class="reviewer-avatar">
                        <span class="reviewer-initials">${initials}</span>
                    </div>
                    <div class="reviewer-details">
                        <div class="reviewer-name">
                            ${name}
                            ${verifiedBadge}
                        </div>
                        <div class="reviewer-meta">
                            <span class="review-date">${date}</span>
                            ${locationHtml}
                        </div>
                    </div>
                </div>
                <div class="review-rating">
                    <div class="review-stars">${stars}</div>
                </div>
            </div>
            <div class="review-content">
                <h4 class="review-title">${title}</h4>
                <p class="review-text">${comment}</p>
            </div>
            <div class="review-actions">
                <button class="btn-helpful" onclick="toggleHelpful(${reviewId}, this)">
                    <i class="far fa-thumbs-up"></i>
                    Helpful (${helpfulVotes})
                </button>
                <span class="review-actions-separator">•</span>
                <button class="btn-like" onclick="toggleLike(${reviewId}, this)">
                    <i class="far fa-heart"></i>
                    Like (${likesCount})
                </button>
            </div>
        </div>
    `;
}

// Toggle helpful vote
async function toggleHelpful(reviewId, button) {
    try {
        const response = await fetch(`/reviews/${reviewId}/helpful`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') || document.querySelector('[name="_token"]').value
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Update button text
            const icon = result.is_helpful ? 'fas' : 'far';
            button.innerHTML = `<i class="${icon} fa-thumbs-up"></i> Helpful (${result.helpful_count})`;
        }
    } catch (error) {
        console.error('Error toggling helpful vote:', error);
    }
}

// Update rating summary
function updateRatingSummary(data) {
    // Update overall rating
    document.querySelector('.rating-score').textContent = data.formatted_rating;
    document.querySelector('.rating-count').textContent = `Based on ${data.total_reviews} review${data.total_reviews !== 1 ? 's' : ''}`;
    
    // Update rating distribution
    Object.keys(data.rating_distribution).forEach(star => {
        const distribution = data.rating_distribution[star];
        const progressFill = document.querySelector(`.rating-bar:nth-child(${6-star}) .progress-fill`);
        const count = document.querySelector(`.rating-bar:nth-child(${6-star}) .count`);
        
        if (progressFill) progressFill.style.width = `${distribution.percentage}%`;
        if (count) count.textContent = distribution.count;
    });
}

// Display order items for review
function displayOrderItems(orderItems) {
    console.log('displayOrderItems called with:', orderItems);
    
    const container = document.getElementById('orderItemsContainer');
    if (!container) {
        console.error('orderItemsContainer not found!');
        return;
    }
    
    container.innerHTML = '';
    
    if (!orderItems || orderItems.length === 0) {
        console.log('No order items found');
        container.innerHTML = '<p class="text-muted">No items found in this order.</p>';
        return;
    }
    
    console.log('Processing', orderItems.length, 'order items');
    
    const itemsHtml = orderItems.map((item, index) => {
        const reviewedBadge = item.already_reviewed ? 
            '<span class="badge badge-success">✓ Reviewed</span>' : 
            '<span class="badge badge-primary">Ready to Review</span>';
            
        const toggleDisabled = item.already_reviewed ? 'disabled' : '';
        const itemClass = item.already_reviewed ? 'already-reviewed' : '';
        const reviewNote = item.already_reviewed ? 
            '<small class="text-muted">This product has already been reviewed for this order.</small>' : 
            '<small class="text-info">Toggle on to review this product.</small>';
            
        return `
            <div class="order-item-review ${itemClass}" data-product-id="${item.id}">
                <div class="item-header">
                    <div class="item-info">
                        <img src="${item.image}" alt="${item.name}" class="item-image">
                        <div class="item-details">
                            <h6>${item.name}</h6>
                            <p>Price: $${item.price} × ${item.quantity}</p>
                            ${reviewedBadge}
                            ${reviewNote}
                        </div>
                    </div>
                    <div class="review-toggle">
                        <label class="switch">
                            <input type="checkbox" ${toggleDisabled} 
                                   onchange="toggleProductReview(${item.id}, this.checked)">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
                <div class="review-fields" id="review-fields-${item.id}" style="display: none;">
                    <div class="form-group">
                        <label>Rating *</label>
                        <div class="star-rating-input" data-product-id="${item.id}">
                            ${[1,2,3,4,5].map(star => 
                                `<i class="far fa-star star-input" data-rating="${star}" 
                                    onclick="setProductRating(${item.id}, ${star})"></i>`
                            ).join('')}
                        </div>
                        <div class="rating-label" id="rating-label-${item.id}">Click to rate</div>
                    </div>
                    <div class="form-group">
                        <label>Review Title *</label>
                        <input type="text" id="title-${item.id}" placeholder="Give your review a title" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label>Your Review *</label>
                        <textarea id="comment-${item.id}" rows="4" placeholder="Share your experience with this product..." 
                                  maxlength="1000" required oninput="updateCharCount(${item.id})"></textarea>
                        <div class="character-count">
                            <span id="char-count-${item.id}">0</span>/1000 characters
                        </div>
                    </div>
                </div>
            </div>
        `;
    }).join('');
    
    console.log('Generated HTML:', itemsHtml);
    container.innerHTML = itemsHtml;
    console.log('Order items displayed successfully');
}

// Toggle product review form
function toggleProductReview(productId, enabled) {
    const reviewFields = document.getElementById(`review-fields-${productId}`);
    if (enabled) {
        reviewFields.style.display = 'block';
        reviewFields.classList.add('active');
    } else {
        reviewFields.style.display = 'none';
        reviewFields.classList.remove('active');
        // Clear form data
        document.getElementById(`title-${productId}`).value = '';
        document.getElementById(`comment-${productId}`).value = '';
        // Reset rating
        const stars = reviewFields.querySelectorAll('.star-input');
        stars.forEach(star => {
            star.classList.remove('fas');
            star.classList.add('far');
        });
        document.getElementById(`rating-label-${productId}`).textContent = 'Click to rate';
    }
}

// Set rating for specific product
function setProductRating(productId, rating) {
    const container = document.querySelector(`[data-product-id="${productId}"]`);
    const stars = container.querySelectorAll('.star-input');
    const label = document.getElementById(`rating-label-${productId}`);
    
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('far');
            star.classList.add('fas');
        } else {
            star.classList.remove('fas');
            star.classList.add('far');
        }
    });
    
    const labels = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
    label.textContent = labels[rating];
    
    // Store rating in data attribute
    container.dataset.rating = rating;
}

// Update character count for specific product
function updateCharCount(productId) {
    const textarea = document.getElementById(`comment-${productId}`);
    const counter = document.getElementById(`char-count-${productId}`);
    counter.textContent = textarea.value.length;
}

// Submit multiple reviews
async function submitMultiReview(event) {
    console.log('=== submitMultiReview called ===');
    event.preventDefault();
    
    const submitBtn = document.querySelector('.btn-submit-review');
    if (!submitBtn) {
        console.error('Submit button not found');
        return;
    }
    
    const originalText = submitBtn.innerHTML;
    
    try {
        // Disable button and show loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
        
        console.log('Starting review collection...');
        
        // Collect reviews data
        const reviewsData = [];
        const activeReviews = document.querySelectorAll('.review-fields.active');
        
        console.log('Found active reviews:', activeReviews.length);
        console.log('Active review elements:', activeReviews);
        
        if (activeReviews.length === 0) {
            console.log('No active reviews found - exiting');
            alert('Please select at least one product to review by toggling it on.');
            return;
        }
        
        let hasValidReviews = false;
        
        activeReviews.forEach(reviewField => {
            const productId = reviewField.id.replace('review-fields-', '');
            console.log('Processing review for product:', productId);
            
            // Check if this product is already reviewed by looking at the parent container
            const orderItem = document.querySelector(`.order-item-review[data-product-id="${productId}"]`);
            if (orderItem && orderItem.classList.contains('already-reviewed')) {
                console.log('Skipping already reviewed product:', productId, '- has already-reviewed class');
                return;
            }
            
            // Also check if the toggle switch is disabled
            const toggleInput = document.querySelector(`.order-item-review[data-product-id="${productId}"] input[type="checkbox"]`);
            if (toggleInput && toggleInput.disabled) {
                console.log('Skipping already reviewed product:', productId, '- toggle is disabled');
                return;
            }
            
            const container = document.querySelector(`[data-product-id="${productId}"]`);
            if (!container) {
                console.error('Container not found for product:', productId);
                return;
            }
            
            const rating = container.dataset.rating;
            const titleElement = document.getElementById(`title-${productId}`);
            const commentElement = document.getElementById(`comment-${productId}`);
            
            const title = titleElement ? titleElement.value.trim() : '';
            const comment = commentElement ? commentElement.value.trim() : '';
            
            console.log('Product data:', { productId, rating, title, comment, hasContainer: !!container, hasTitle: !!titleElement, hasComment: !!commentElement });
            
            // Only rating is required
            if (rating && rating > 0) {
                reviewsData.push({
                    product_id: parseInt(productId),
                    rating: parseInt(rating),
                    title: title || 'Review',
                    comment: comment || ''
                });
                hasValidReviews = true;
                console.log('Added valid review for product:', productId);
            } else {
                console.log('Missing rating for product:', productId, 'Rating value:', rating);
            }
        });
        
        console.log('Final reviews data:', reviewsData);
        
        if (!hasValidReviews || reviewsData.length === 0) {
            console.log('No valid reviews to submit');
            alert('Please provide ratings for the selected products.');
            return;
        }
        
        // Additional check: make sure we're not trying to review already reviewed products
        const alreadyReviewedProducts = [];
        reviewsData.forEach(reviewData => {
            const orderItem = document.querySelector(`.order-item-review[data-product-id="${reviewData.product_id}"]`);
            if (orderItem && orderItem.classList.contains('already-reviewed')) {
                alreadyReviewedProducts.push(reviewData.product_id);
            }
        });
        
        if (alreadyReviewedProducts.length > 0) {
            console.log('Blocked submission: trying to review already reviewed products:', alreadyReviewedProducts);
            alert('Some of the selected products have already been reviewed. Please refresh the page and try again.');
            return;
        }
        
        // Get form field values
        const nameElement = document.getElementById('reviewName');
        const emailElement = document.getElementById('reviewEmail');
        const locationElement = document.getElementById('reviewLocation');
        const orderElement = document.getElementById('verifiedOrderId');
        
        const formData = {
            name: nameElement ? nameElement.value.trim() : '',
            email: emailElement ? emailElement.value.trim() : '',
            location: locationElement ? locationElement.value : '',
            order_reference: orderElement ? orderElement.value : '',
            reviews: reviewsData
        };
        
        console.log('Form data prepared:', formData);
        
        // Validate required fields
        if (!formData.name) {
            console.log('Name is missing');
            alert('Please enter your name.');
            return;
        }
        if (!formData.email) {
            console.log('Email is missing');
            alert('Please enter your email.');
            return;
        }
        if (!formData.order_reference) {
            console.log('Order reference is missing');
            alert('Order ID is missing. Please verify your order first.');
            return;
        }
        
        console.log('All validation passed, submitting...');
        
        // Get CSRF token
        let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            csrfToken = document.querySelector('[name="_token"]')?.value;
        }
        
        if (!csrfToken) {
            console.error('CSRF token not found');
            alert('Security token not found. Please refresh the page.');
            return;
        }
        
        const productId = {{ $product->id }};
        const submitUrl = `/products/${productId}/reviews`;
        console.log('Submitting to URL:', submitUrl);
        
        const response = await fetch(submitUrl, {
            method: 'POST',
            body: JSON.stringify(formData),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Response error:', errorText);
            
            if (response.status === 422) {
                try {
                    const errorData = JSON.parse(errorText);
                    console.log('Validation errors:', errorData);
                    alert('Validation error: ' + JSON.stringify(errorData.errors || errorData.message));
                } catch (e) {
                    alert('Validation error occurred. Please check your input.');
                }
            } else {
                alert(`Error: ${response.status} - ${response.statusText}`);
            }
            return;
        }
        
        const result = await response.json();
        console.log('Success response:', result);
        
        if (result.success) {
            console.log('Reviews submitted successfully!');
            alert('Reviews submitted successfully!');
            
            // Close modal and reload
            const modal = document.getElementById('reviewModal');
            if (modal) {
                modal.style.display = 'none';
            }
            
            // Reset form
            const form = document.getElementById('reviewForm');
            if (form) {
                form.reset();
            }
            
            // Reload page to show new reviews
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            console.log('Server returned error:', result.message);
            alert(result.message || 'An error occurred.');
        }
        
    } catch (error) {
        console.error('Error submitting reviews:', error);
        alert('An error occurred while submitting reviews: ' + error.message);
    } finally {
        // Always re-enable button
        console.log('Re-enabling submit button...');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    }
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && document.getElementById('reviewModal').classList.contains('active')) {
        closeReviewModal();
    }
});
</script>
