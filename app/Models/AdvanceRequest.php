<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvanceRequest extends Model
{
    use HasFactory;
    //fillable
    protected $fillable = [
        'username',
        'date',
        'description',
        'revieved_by',
        'status',
        'amount',
        'remarks'
    ];
}
