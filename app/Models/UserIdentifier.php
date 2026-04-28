<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserIdentifier extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'identifier',
        'type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTypelabelAttribute(): string
    {
        return match($this->type) {
            'face' => 'Wajah',
            'rfid' => 'Kartu RFID',
            'pin'  => 'PIN',
            default => ucfirst($this->type),
        };
    }
}