<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $fillable = [
        'user_id',
        'otp',
        'expires_at',
        'is_used',
    ];


    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function isExpired()
    {
        return now()->isAfter($this->expires_at);
    }


    public function isValid()
    {
        return !$this->is_used && !$this->isExpired();
    }
}