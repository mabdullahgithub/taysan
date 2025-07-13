<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'first_name',
        'last_name', 
        'email',
        'phone',
        'address',
        'postal_code',
        'city',
        'country',
        'subtotal',
        'shipping_cost',
        'total',
        'status',
        'order_source',
        'deal_id'
    ];

    /**
     * Boot method to auto-generate order number
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = self::generateOrderNumber();
            }
        });
    }

    /**
     * Generate a unique 8-digit order number
     */
    public static function generateOrderNumber()
    {
        do {
            $orderNumber = str_pad(random_int(10000000, 99999999), 8, '0', STR_PAD_LEFT);
        } while (self::where('order_number', $orderNumber)->exists());
        
        return $orderNumber;
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the deal of the day associated with this order (if applicable)
     */
    public function dealOfTheDay()
    {
        return $this->belongsTo(DealOfTheDay::class, 'deal_id');
    }

    // Helper method to get full name
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Helper method to get formatted order source
    public function getOrderSourceLabelAttribute()
    {
        return match($this->order_source) {
            'deal' => 'Deal of the Day',
            'regular' => 'Regular Order',
            default => 'Regular Order'
        };
    }

    /**
     * Check if this order contains a specific product
     */
    public function hasProduct($productId)
    {
        return $this->orderItems()->where('product_id', $productId)->exists();
    }

    /**
     * Get order reference number
     */
    public function getOrderReferenceAttribute()
    {
        return $this->order_number ?: self::generateOrderNumber();
    }
}