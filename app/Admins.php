<?php
namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admins extends Authenticatable
{
    protected $guard = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',  'lastname', 'email', 'address', 'password','last_login_at','last_login_ip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}