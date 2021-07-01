<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\CanResetPassword;
// use Illuminate\Foundation\Auth\User as Authenticatable;

class RDLCabang extends Model
{
    // use Notifiable;
    protected $table = 'rdl_cabang';

    protected $fillable = [
        'kode_bank', 'kode_cabang', 
        'nama_cabang'
    ];

}
