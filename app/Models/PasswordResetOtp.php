<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PasswordResetOtp extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
        'is_used',
        'used_at',
        'ip_address',
        'user_agent'
    ];
    
    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
        'is_used' => 'boolean'
    ];
    
    /**
     * Generate a new OTP for the given email
     */
    public static function generateOtp(string $email, string $ipAddress = null, string $userAgent = null): string
    {
        // Delete old OTPs for this email
        self::where('email', $email)->delete();
        
        // Generate 6-digit OTP
        $otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        
        // Create new OTP record
        self::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10), // 10 minutes expiry
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent
        ]);
        
        return $otp;
    }
    
    /**
     * Verify OTP for the given email
     */
    public static function verifyOtp(string $email, string $otp): bool
    {
        $otpRecord = self::where('email', $email)
            ->where('otp', $otp)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();
            
        if ($otpRecord) {
            $otpRecord->update([
                'is_used' => true,
                'used_at' => Carbon::now()
            ]);
            return true;
        }
        
        return false;
    }
    
    /**
     * Check if OTP exists and is valid (not expired, not used)
     */
    public static function isValidOtp(string $email, string $otp): bool
    {
        return self::where('email', $email)
            ->where('otp', $otp)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->exists();
    }
    
    /**
     * Clean up expired OTPs
     */
    public static function cleanupExpired(): int
    {
        return self::where('expires_at', '<', Carbon::now()->subHours(24))
            ->delete();
    }
    
    /**
     * Get remaining time for OTP
     */
    public function getRemainingMinutes(): int
    {
        return max(0, $this->expires_at->diffInMinutes(Carbon::now()));
    }
}
