<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
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
}