<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'identifier',
        'status',
        'method',
        'ip_address',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    // Ambil user berdasarkan identifier
    public function userIdentifier()
    {
        return $this->belongsTo(UserIdentifier::class, 'identifier', 'identifier');
    }

    public function getUserNameAttribute(): string
    {
        $ui = UserIdentifier::where('identifier', $this->identifier)->first();
        return $ui?->user?->name ?? '—';
    }
}