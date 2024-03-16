<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleRepair extends Model
{
    use HasFactory;
    //fillable
    protected $fillable = [
        'vehicle_reg_no',
        'date',
        'description',
        'cost',
        'bill_image',
        'monitored_by',
        'title'
    ];

}
