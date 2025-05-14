<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiWhatsapp extends Model
{
    use HasFactory;

    protected $table = 'apiwhatsapp';

    protected $fillable = ['name', 'phone', 'links', 'authorization', 'status', 'key'];
}