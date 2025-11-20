<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
     use HasFactory;

    // Add this
    protected $fillable = ['name', 'price', 'description','category',
        'img'];
}
