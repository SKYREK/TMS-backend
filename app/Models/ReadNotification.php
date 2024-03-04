<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadNotification extends Model
{
    use HasFactory;
    //keytype
    protected $keyType = 'string';
    public $incrementing = false;
    //composite primary key username and notification_id
    protected $primaryKey = ['username', 'notification_id'];
    //fillable
    protected $fillable = [
        'username',
        'notification_id'
    ];
}
