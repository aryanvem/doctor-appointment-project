<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $fillable = [
        'name', 'slug', 'phone', 'email', 'photo',
        'qualification', 'specialization', 'bio',
        'experience_years', 'is_active',
    ];

    public function clinics(): HasMany
    {
        return $this->hasMany(Clinic::class);
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

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return asset('images/default-doctor.png');
    }
}
