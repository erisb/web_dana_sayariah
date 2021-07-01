<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\CanResetPassword;
// use Illuminate\Foundation\Auth\User as Authenticatable;

class RDLTitle extends Model
{
    // use Notifiable;
    protected $table = 'rdl_title';

    protected $fillable = [
        'kode_bank', 'kode_title', 
        'deskripsi_title'
    ];

}
