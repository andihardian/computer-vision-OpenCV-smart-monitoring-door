<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaceRegistrationRequest extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'progress',
        'message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }
}