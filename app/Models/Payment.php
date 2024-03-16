<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    //fillable
    protected $fillable = [
        'booking_id',
        'amount',
        'date',
        'card_number',
        'card_holder_name',
        'card_expiry_date',
        'card_cvv'
    ];
}
