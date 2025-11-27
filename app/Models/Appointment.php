<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'user_email',
        'user_contact',
        'services',
        'total_price',
        'appointment_date',
        'appointment_time',
        'status'
    ];

    protected $casts = [
        'services' => 'array', // JSON <-> array
        'appointment_date' => 'date',
        'total_price' => 'decimal:2',
    ];
}
