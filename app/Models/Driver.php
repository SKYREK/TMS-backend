<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    //keytype
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'username';
    //fillable
    protected $fillable = [
        'username',
        'salary'
    ];
}
