<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'type',
        'image',
        'background_color',
        'text_color',
        'button_text',
        'button_link',
        'countdown_date',
        'is_active',
        'start_date',
        'end_date',
        'order',
        'display_duration',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'countdown_date' => 'datetime',
        'order' => 'integer',
        'display_duration' => 'integer',
    ];

    /**
     * Scope for active announcements
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('start_date')
                          ->orWhere('start_date', '<=', now());
                    })
                    ->where(function ($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                    });
    }

    /**
     * Get the image URL with proper URL handling
     */
    public function getImageAttribute($value)
    {
        if (!$value) {
            return null;
        }

        // If it's already a full URL, return as is
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // If it starts with 'storage/', return the asset URL
        if (str_starts_with($value, 'storage/')) {
            return asset($value);
        }

        // If it starts with 'announcements/', assume it's in storage
        if (str_starts_with($value, 'announcements/')) {
            return asset('storage/' . $value);
        }

        // For any other path, assume it's a relative path in storage
        return asset('storage/' . $value);
    }

    /**
     * Get the status with color coding
     */
    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        $now = now();
        
        if ($this->start_date && $now->lt($this->start_date)) {
            return 'scheduled';
        }
        
        if ($this->end_date && $now->gt($this->end_date)) {
            return 'expired';
        }
        
        return 'active';
    }

    /**
     * Get status color for badges
     */
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'active':
                return 'success';
            case 'scheduled':
                return 'warning';
            case 'expired':
                return 'secondary';
            case 'inactive':
                return 'secondary';
            default:
                return 'secondary';
        }
    }

    /**
     * Check if announcement is currently active
     */
    public function isCurrentlyActive()
    {
        return $this->status === 'active';
    }

    /**
     * Get display duration in seconds
     */
    public function getDisplayDurationInSecondsAttribute()
    {
        return $this->display_duration / 1000;
    }

    /**
     * Get sort order (alias for 'order' field)
     */
    public function getSortOrderAttribute()
    {
        return $this->order;
    }

    /**
     * Set sort order (alias for 'order' field)
     */
    public function setSortOrderAttribute($value)
    {
        $this->attributes['order'] = $value;
    }
}
