<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\CanResetPassword;
// use Illuminate\Foundation\Auth\User as Authenticatable;

class RDLCifNumber extends Model
{
    // use Notifiable;
    protected $table = 'rdl_cif_number';

    protected $fillable = [
        'investor_id', 'kode_bank', 
        'cif_number'
    ];

}
