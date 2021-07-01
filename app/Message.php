<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table='message_user';

    protected $fillable = [
        'name',  'email', 'subject', 'number', 'message',
    ];

}
