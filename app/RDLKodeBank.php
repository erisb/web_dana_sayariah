<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\CanResetPassword;
// use Illuminate\Foundation\Auth\User as Authenticatable;

class RDLKodeBank extends Model
{
    // use Notifiable;
    protected $table = 'rdl_kode_bank';

    protected $fillable = [
        'nama_bank', 'kode_interbank', 
        'kode_clearing', 'kode_rtgs','kode_bank' 
    ];

}
