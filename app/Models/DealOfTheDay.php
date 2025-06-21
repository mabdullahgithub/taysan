<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DealOfTheDay extends Model
{
    use HasFactory;

    protected $table = 'deal_of_the_day';

    protected $fillable = [
        'product_id',
        'discount_percentage',
        'deal_price',
        'deal_title',
        'deal_description',
        'start_date',
        'end_date',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'discount_percentage' => 'decimal:2',
        'deal_price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    /**
     * Get the product associated with the deal
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope to get active deals
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    /**
     * Get the final deal price (always returns whole numbers)
     */
    public function getFinalPriceAttribute()
    {
        if ($this->deal_price) {
            return round($this->deal_price, 0);
        }

        if ($this->discount_percentage > 0) {
            $discount = ($this->product->price * $this->discount_percentage) / 100;
            $finalPrice = $this->product->price - $discount;
            return round($finalPrice, 0);
        }

        return round($this->product->price, 0);
    }

    /**
     * Get the savings amount
     */
    public function getSavingsAttribute()
    {
        return $this->product->price - $this->final_price;
    }

    /**
     * Check if deal is currently active
     */
    public function getIsCurrentlyActiveAttribute()
    {
        return $this->is_active && 
               $this->start_date <= now() && 
               $this->end_date >= now();
    }
}
