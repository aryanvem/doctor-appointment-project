<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slot extends Model
{
    protected $fillable = [
        'doctor_id', 'clinic_id', 'start_time', 'end_time', 'day_of_week', 'is_active',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function isBookedOn(string $date): bool
    {
        return $this->appointments()
            ->where('appointment_date', $date)
            ->where('status', '!=', 'cancelled')
            ->exists();
    }

    public function getFormattedTimeAttribute(): string
    {
        return date('h:i A', strtotime($this->start_time));
    }
}
