<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\CanResetPassword;
// use Illuminate\Foundation\Auth\User as Authenticatable;

class FDCPassword extends Model
{
    // use Notifiable;
    protected $table = 'fdc_zip_password';
    protected $fillable = [
        'tanggal', 'password'
    ];
    
}
