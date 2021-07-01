<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\CanResetPassword;
// use Illuminate\Foundation\Auth\User as Authenticatable;

class RDLSumberPendapatan extends Model
{
    // use Notifiable;
    protected $table = 'rdl_sumber_pendapatan';

    protected $fillable = [
        'kode_bank', 'kode_sumber_pendapatan', 
        'deskripsi_sumber_pendapatan'
    ];

}
