<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\CanResetPassword;
// use Illuminate\Foundation\Auth\User as Authenticatable;

class RDLAkunTIpe extends Model
{
    // use Notifiable;
    protected $table = 'rdl_akun_tipe';

    protected $fillable = [
        'kode_bank', 'tipe_akun', 
        'deskripsi_akun'
    ];

}
