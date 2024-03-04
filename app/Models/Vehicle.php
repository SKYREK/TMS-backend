<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    //keytype
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'reg_no';
    //fillable
    protected $fillable = [
        "reg_no",
        'category',
        'milage',
        'description',
        'make',
        'model',
        'yom',
        'yor',
        'image',
        'type'
    ];
}
