<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipLink extends Model
{
    use HasFactory;

    protected $table = 'sip_links';

    protected $fillable = ['sip_id', 'token', 'expires_at', 'used'];

    protected $casts = [
        'used' => 'boolean',
        'expires_at' => 'datetime',
    ];

    // Relasi ke tabel sip_requests
    public function sipRequest()
    {
        return $this->belongsTo(SipRequest::class, 'sip_id', 'id');
    }
}