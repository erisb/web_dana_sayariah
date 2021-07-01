<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\CanResetPassword;
// use Illuminate\Foundation\Auth\User as Authenticatable;

class RDLTipeCharging extends Model
{
    // use Notifiable;
    protected $table = 'rdl_tipe_charging';

    protected $fillable = [
        'kode_bank', 'kode_charging', 
        'deskripsi_charging'
    ];

}
