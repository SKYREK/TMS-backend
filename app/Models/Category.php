<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    //keytype
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'name';
    //fillable
    protected $fillable = [
        'name',
        'description',
        'price'
    ];

}
