<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    // Specify the table name if it's not the plural form of the model name
    protected $table = 'units';

    // Specify the fields that can be mass assigned
    protected $fillable = ['name', 'slug_name', 'details', 'status'];
}
