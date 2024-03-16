<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    //fillable
    protected $fillable = [
        'username',
        'driver_username',
        'date',
        'vehicle_reg_no',
        'distance',
        'cost',
        'payment_status',
        'remarks'
    ];
}
