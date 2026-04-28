<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationalHour extends Model
{
    protected $fillable = [
        'device_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function getDayLabelAttribute(): string
    {
        return match($this->day_of_week) {
            'monday'    => 'Senin',
            'tuesday'   => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday'  => 'Kamis',
            'friday'    => 'Jumat',
            'saturday'  => 'Sabtu',
            'sunday'    => 'Minggu',
            default     => ucfirst($this->day_of_week),
        };
    }
}