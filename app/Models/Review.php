<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'email',
        'location',
        'rating',
        'title',
        'comment',
        'helpful_votes',
        'likes_count',
        'liked_by_ips',
        'is_verified_buyer',
        'is_approved',
        'order_reference',
        'reviewed_at'
    ];

    protected $casts = [
        'helpful_votes' => 'array',
        'liked_by_ips' => 'array',
        'is_verified_buyer' => 'boolean',
        'is_approved' => 'boolean',
        'reviewed_at' => 'datetime'
    ];

    /**
     * Get the product that this review belongs to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that wrote the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get only approved reviews
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope to get reviews by rating
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Get formatted date for display
     */
    public function getFormattedDateAttribute()
    {
        if ($this->reviewed_at) {
            return $this->reviewed_at->format('m/d/Y');
        }
        return $this->created_at->format('m/d/Y');
    }

    /**
     * Get initials from name
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
                if (strlen($initials) >= 2) break;
            }
        }
        
        return $initials ?: 'AN'; // Anonymous if no initials
    }

    /**
     * Get masked name for privacy
     */
    public function getMaskedNameAttribute()
    {
        $words = explode(' ', $this->name);
        if (count($words) > 1) {
            $firstName = $words[0];
            $lastName = strtoupper(substr($words[1], 0, 1)) . '.';
            return $firstName . ' ' . $lastName;
        }
        return $this->name;
    }

    /**
     * Get helpful votes count
     */
    public function getHelpfulVotesCountAttribute()
    {
        return is_array($this->helpful_votes) ? count($this->helpful_votes) : 0;
    }

    /**
     * Check if user found this review helpful
     */
    public function isHelpfulForUser($userId)
    {
        if (!is_array($this->helpful_votes)) {
            return false;
        }
        return in_array($userId, $this->helpful_votes);
    }

    /**
     * Toggle helpful vote for user
     */
    public function toggleHelpfulVote($userId)
    {
        $votes = is_array($this->helpful_votes) ? $this->helpful_votes : [];
        
        if (in_array($userId, $votes)) {
            $votes = array_filter($votes, function($vote) use ($userId) {
                return $vote != $userId;
            });
        } else {
            $votes[] = $userId;
        }
        
        $this->helpful_votes = array_values($votes);
        $this->save();
        
        return count($votes);
    }

    /**
     * Get star rating as array for display
     */
    public function getStarRatingAttribute()
    {
        return [
            'filled' => $this->rating,
            'empty' => 5 - $this->rating
        ];
    }

    /**
     * Check if IP has liked this review
     */
    public function isLikedByIp($ip)
    {
        if (!is_array($this->liked_by_ips)) {
            return false;
        }
        return in_array($ip, $this->liked_by_ips);
    }

    /**
     * Toggle like for IP address
     */
    public function toggleLike($ip)
    {
        $likedIps = is_array($this->liked_by_ips) ? $this->liked_by_ips : [];
        
        if (in_array($ip, $likedIps)) {
            // Remove like
            $likedIps = array_filter($likedIps, function($likedIp) use ($ip) {
                return $likedIp !== $ip;
            });
            $this->likes_count = max(0, $this->likes_count - 1);
        } else {
            // Add like
            $likedIps[] = $ip;
            $this->likes_count = $this->likes_count + 1;
        }
        
        $this->liked_by_ips = array_values($likedIps);
        $this->save();
        
        return [
            'liked' => in_array($ip, $this->liked_by_ips),
            'likes_count' => $this->likes_count
        ];
    }
}
