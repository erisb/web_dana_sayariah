<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\CanResetPassword;
// use Illuminate\Foundation\Auth\User as Authenticatable;

class RDLMap extends Model
{
    // use Notifiable;
    protected $table = 'rdl_map';

    protected $fillable = [
        'kode_bank', 'id_dsi', 
        'kode_map', 'deskripsi_map','kategori' 
    ];

}
