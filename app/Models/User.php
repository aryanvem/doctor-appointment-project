<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'otp', 'otp_expires_at', 'is_verified',
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function isOtpValid(string $otp): bool
    {
        return $this->otp === $otp
            && $this->otp_expires_at
            && now()->lessThanOrEqualTo($this->otp_expires_at);
    }
}
