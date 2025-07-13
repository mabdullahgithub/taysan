<div class="review-item">
    <div class="review-header">
        <div class="reviewer-info">
            <div class="reviewer-avatar">
                <span class="reviewer-initials">{{ $review->initials }}</span>
            </div>
            <div class="reviewer-details">
                <div class="reviewer-name">
                    {{ $review->masked_name }}
                    @if($review->is_verified_buyer)
                        <span class="verified-badge">
                            <i class="fas fa-check-circle"></i>
                            Verified Buyer
                        </span>
                    @endif
                </div>
                <div class="reviewer-meta">
                    <span class="review-date">{{ $review->formatted_date }}</span>
                    @if($review->location)
                        <span class="review-location">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $review->location }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="review-rating">
            <div class="review-stars">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $review->rating)
                        <i class="fas fa-star filled"></i>
                    @else
                        <i class="far fa-star empty"></i>
                    @endif
                @endfor
            </div>
        </div>
    </div>
    
    <div class="review-content">
        <h4 class="review-title">{{ $review->title }}</h4>
        <p class="review-text">{{ $review->comment }}</p>
    </div>
    
    <div class="review-actions">
        <button class="btn-helpful" onclick="toggleHelpful({{ $review->id }}, this)" data-helpful="{{ $review->helpful_votes_count }}">
            <i class="far fa-thumbs-up"></i>
            Helpful ({{ $review->helpful_votes_count }})
        </button>
        <span class="review-actions-separator">•</span>
        <button class="btn-like" onclick="toggleLike({{ $review->id }}, this)" data-likes="{{ $review->likes_count ?? 0 }}">
            <i class="far fa-heart"></i>
            Like ({{ $review->likes_count ?? 0 }})
        </button>
        <span class="review-actions-separator">•</span>
        <button class="btn-share" onclick="shareReview({{ $review->id }})">
            <i class="fas fa-share"></i>
            Share
        </button>
    </div>
</div>

<style>
/* Individual Review Item Styles */
.review-item {
    padding: 25px 0;
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.3s ease;
}

.review-item:last-child {
    border-bottom: none;
}

.review-item:hover {
    background-color: #fafafa;
    border-radius: 8px;
    margin: 0 -15px;
    padding: 25px 15px;
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
    gap: 20px;
}

.reviewer-info {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    flex: 1;
}

.reviewer-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.reviewer-initials {
    color: white;
    font-weight: 600;
    font-size: 1rem;
    text-transform: uppercase;
}

.reviewer-details {
    flex: 1;
    min-width: 0;
}

.reviewer-name {
    font-weight: 600;
    color: var(--text-color);
    font-size: 1rem;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.reviewer-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    font-size: 0.85rem;
    color: var(--text-light);
}

.review-date {
    color: var(--text-light);
}

.review-location {
    display: flex;
    align-items: center;
    gap: 4px;
    color: var(--text-light);
}

.review-location i {
    font-size: 0.8rem;
}

.verified-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    white-space: nowrap;
    flex-shrink: 0;
}

.verified-badge i {
    font-size: 0.7rem;
}

.review-rating {
    flex-shrink: 0;
}

.review-stars {
    display: flex;
    gap: 2px;
}

.review-stars i {
    font-size: 1rem;
}

.review-stars .filled {
    color: #FFD700;
}

.review-stars .empty {
    color: #ddd;
}

.review-content {
    margin-bottom: 20px;
}

.review-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-color);
    margin: 0 0 8px 0;
    line-height: 1.3;
}

.review-text {
    font-size: 0.95rem;
    color: var(--text-color);
    line-height: 1.6;
    margin: 0;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.review-actions {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.btn-helpful,
.btn-like,
.btn-share {
    background: none;
    border: none;
    color: var(--text-light);
    font-size: 0.85rem;
    cursor: pointer;
    padding: 6px 0;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s ease;
    border-radius: 4px;
}

.btn-helpful:hover,
.btn-like:hover,
.btn-share:hover {
    color: var(--primary-color);
}

.btn-helpful:hover,
.btn-like:hover {
    background: rgba(141, 104, 173, 0.1);
    padding: 6px 10px;
}

.btn-share:hover {
    background: rgba(141, 104, 173, 0.1);
    padding: 6px 10px;
}

.btn-helpful.helpful-active {
    color: var(--primary-color);
    font-weight: 600;
}

.btn-helpful.helpful-active i {
    color: var(--primary-color);
}

.btn-like.liked-active {
    color: #e74c3c;
    font-weight: 600;
}

.btn-like.liked-active i {
    color: #e74c3c;
}

.review-actions-separator {
    color: #ddd;
    font-weight: bold;
}

/* Responsive Design */
@media (max-width: 768px) {
    .review-header {
        flex-direction: column;
        gap: 15px;
    }
    
    .review-rating {
        align-self: flex-start;
    }
    
    .reviewer-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
    }
    
    .review-actions {
        flex-direction: row;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: flex-start;
    }
    
    .review-actions-separator {
        display: inline;
    }
}

@media (max-width: 480px) {
    .reviewer-avatar {
        width: 40px;
        height: 40px;
    }
    
    .reviewer-initials {
        font-size: 0.9rem;
    }
    
    .reviewer-name {
        font-size: 0.95rem;
    }
    
    .review-title {
        font-size: 1rem;
    }
    
    .review-text {
        font-size: 0.9rem;
    }
}

/* Animation for new reviews */
@keyframes slideInReview {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.review-item.new-review {
    animation: slideInReview 0.5s ease-out;
}

/* Loading state */
.review-item.loading {
    opacity: 0.6;
    pointer-events: none;
}

.review-item.loading .btn-helpful,
.review-item.loading .btn-like,
.review-item.loading .btn-share {
    cursor: not-allowed;
}

/* Highlight state for linked reviews */
.review-item.highlighted {
    background: linear-gradient(135deg, #fff3cd, #ffeaa7);
    border-radius: 8px;
    margin: 0 -15px;
    padding: 25px 15px;
    animation: highlightFade 3s ease-out;
}

@keyframes highlightFade {
    0% {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
    }
    100% {
        background: transparent;
    }
}
</style>

<script>
// Share review functionality
function shareReview(reviewId) {
    const reviewElement = document.querySelector(`[data-review-id="${reviewId}"]`);
    if (!reviewElement) return;
    
    const productName = '{{ $review->product->name }}';
    const reviewTitle = reviewElement.querySelector('.review-title').textContent;
    const reviewerName = reviewElement.querySelector('.reviewer-name').textContent;
    
    const shareText = `Check out this review of ${productName} by ${reviewerName}: "${reviewTitle}"`;
    const shareUrl = window.location.href + `#review-${reviewId}`;
    
    if (navigator.share) {
        // Use native sharing if available
        navigator.share({
            title: `Review of ${productName}`,
            text: shareText,
            url: shareUrl
        }).catch(console.error);
    } else {
        // Fallback to copying to clipboard
        navigator.clipboard.writeText(`${shareText} ${shareUrl}`).then(() => {
            console.log('Review link copied to clipboard!');
        }).catch(() => {
            // Ultimate fallback
            prompt('Copy this link to share the review:', shareUrl);
        });
    }
}

// Toggle like functionality
async function toggleLike(reviewId, button) {
    try {
        // Add loading state
        button.disabled = true;
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        
        const response = await fetch(`/reviews/${reviewId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Update button appearance and count
            const icon = result.liked ? 'fas fa-heart' : 'far fa-heart';
            const className = result.liked ? 'btn-like liked-active' : 'btn-like';
            
            button.className = className;
            button.innerHTML = `<i class="${icon}"></i> Like (${result.likes_count})`;
            
            // Show feedback
            if (result.liked) {
                console.log('❤️ You liked this review!');
            } else {
                console.log('Like removed');
            }
        } else {
            // Restore original state
            button.innerHTML = originalHTML;
            console.error('Unable to process like:', result.message || 'Unable to process like. Please try again.');
        }
    } catch (error) {
        console.error('Error toggling like:', error);
        button.innerHTML = originalHTML;
    } finally {
        button.disabled = false;
    }
}

// Add review ID attribute for deep linking
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.review-item').forEach((item, index) => {
        const reviewId = item.querySelector('.btn-helpful').onclick.toString().match(/\d+/);
        if (reviewId) {
            item.setAttribute('data-review-id', reviewId[0]);
            item.id = `review-${reviewId[0]}`;
        }
    });
    
    // Check for hash in URL to highlight specific review
    if (window.location.hash.startsWith('#review-')) {
        const reviewElement = document.querySelector(window.location.hash);
        if (reviewElement) {
            reviewElement.classList.add('highlighted');
            reviewElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
});
</script>
