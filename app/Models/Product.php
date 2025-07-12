<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'detailed_description',
        'price',
        'stock',
        'sold_count',
        'image',
        'images',
        'sku',
        'weight',
        'dimensions',
        'ingredients',
        'benefits',
        'usage_instructions',
        'origin_country',
        'is_organic',
        'is_vegan',
        'is_cruelty_free',
        'tags',
        'status',
        'flag',
    ];

    protected $casts = [
        'images' => 'array',
        'tags' => 'array',
        'is_organic' => 'boolean',
        'is_vegan' => 'boolean',
        'is_cruelty_free' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function dealOfTheDay()
    {
        return $this->hasMany(DealOfTheDay::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-product.jpg');
    }

    public function getAllImagesAttribute()
    {
        $images = [];
        
        // Add main image first
        if ($this->image) {
            $images[] = asset('storage/' . $this->image);
        }
        
        // Add additional images
        $additionalImages = $this->images;
        
        // Handle if images is stored as JSON string
        if (is_string($additionalImages)) {
            $additionalImages = json_decode($additionalImages, true);
        }
        
        if ($additionalImages && is_array($additionalImages)) {
            foreach ($additionalImages as $image) {
                if (is_string($image)) {
                    $images[] = asset('storage/' . $image);
                }
            }
        }
        
        // Return default image if no images available
        if (empty($images)) {
            $images[] = asset('images/default-product.jpg');
        }
        
        return $images;
    }

    public function hasMultipleImages()
    {
        return count($this->all_images) > 1;
    }

    public function hasImages()
    {
        // Check main image
        if ($this->image) {
            return true;
        }
        
        // Check additional images
        $additionalImages = $this->images;
        
        // Handle if images is stored as JSON string
        if (is_string($additionalImages)) {
            $additionalImages = json_decode($additionalImages, true);
        }
        
        return $additionalImages && is_array($additionalImages) && count($additionalImages) > 0;
    }

    /**
     * Scope to get best selling products
     */
    public function scopeBestSelling($query, $limit = 10)
    {
        return $query->orderBy('sold_count', 'desc')->limit($limit);
    }

    /**
     * Get formatted sold count
     */
    public function getFormattedSoldCountAttribute()
    {
        if ($this->sold_count >= 1000) {
            return round($this->sold_count / 1000, 1) . 'k';
        }
        return $this->sold_count;
    }

    /**
     * Check if product is a best seller (sold more than average)
     */
    public function getIsBestSellerAttribute()
    {
        $avgSoldCount = static::avg('sold_count') ?? 0;
        return $this->sold_count > $avgSoldCount;
    }

    /**
     * Get average rating for this product
     */
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?: 0;
    }

    /**
     * Get total reviews count
     */
    public function getReviewsCountAttribute()
    {
        return $this->approvedReviews()->count();
    }

    /**
     * Get rating distribution (1-5 stars)
     */
    public function getRatingDistributionAttribute()
    {
        $distribution = [];
        $totalReviews = $this->reviews_count;
        
        for ($i = 1; $i <= 5; $i++) {
            $count = $this->approvedReviews()->where('rating', $i)->count();
            $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
            
            $distribution[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }
        
        return $distribution;
    }

    /**
     * Get formatted average rating (e.g., "4.5")
     */
    public function getFormattedRatingAttribute()
    {
        return number_format($this->average_rating, 1);
    }

    /**
     * Get star rating display array
     */
    public function getStarRatingAttribute()
    {
        $rating = $this->average_rating;
        $fullStars = floor($rating);
        $hasHalfStar = ($rating - $fullStars) >= 0.5;
        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
        
        return [
            'full' => $fullStars,
            'half' => $hasHalfStar ? 1 : 0,
            'empty' => $emptyStars
        ];
    }
}
