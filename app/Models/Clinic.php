<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clinic extends Model
{
    protected $fillable = [
        'doctor_id', 'name', 'address', 'city', 'state', 'pincode', 'phone', 'is_active',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }

    public function feesDetails(): HasMany
    {
        return $this->hasMany(FeesDetail::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([$this->address, $this->city, $this->state, $this->pincode]);
        return implode(', ', $parts);
    }
}
