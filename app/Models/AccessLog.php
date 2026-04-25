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
}