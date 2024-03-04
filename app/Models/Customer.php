<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    //keytype
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'username';
    //fillable
    protected $fillable = [
        'username',
        'address',
        'phone',
        'email'
    ];
}
