<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\CanResetPassword;
// use Illuminate\Foundation\Auth\User as Authenticatable;

class RDLAlasan extends Model
{
    // use Notifiable;
    protected $table = 'rdl_alasan';

    protected $fillable = [
        'kode_bank', 'kode_alasan', 
        'deskripsi_alasan'
    ];

}
