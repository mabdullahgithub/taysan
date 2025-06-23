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
        if ($this->images && is_array($this->images)) {
            foreach ($this->images as $image) {
                $images[] = asset('storage/' . $image);
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
}
