<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LimitPinjaman extends Model
{
    use HasFactory;

    protected $table = 'limitpinjaman';

    protected $fillable = ['user_id', 'limit', 'status'];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}