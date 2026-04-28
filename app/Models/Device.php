<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'token',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }

    public function operationalHours()
    {
        return $this->hasMany(OperationalHour::class);
    }

    /**
     * Cek apakah waktu sekarang dalam jam operasional device ini
     */
    public function isWithinOperationalHours(): bool
    {
        $schedule = $this->operationalHours()
                         ->where('is_active', true)
                         ->first();

        // Jika tidak ada jadwal → akses bebas
        if (!$schedule) {
            return true;
        }

        $now   = now()->format('H:i:s');
        $start = $schedule->start_time;
        $end   = $schedule->end_time;

        // Handle overnight schedule (misal: 22:00 - 06:00)
        if ($start > $end) {
            return $now >= $start || $now <= $end;
        }

        return $now >= $start && $now <= $end;
    }
}