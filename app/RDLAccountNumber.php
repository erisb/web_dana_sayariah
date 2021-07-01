<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\CanResetPassword;
// use Illuminate\Foundation\Auth\User as Authenticatable;

class RDLAccountNumber extends Model
{
    // use Notifiable;
    protected $table = 'rdl_acount_number';

    protected $fillable = [
        'investor_id', 'kode_bank', 
        'cif_number', 'account_number'
    ];

}
