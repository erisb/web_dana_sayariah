<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Marketer extends Authenticatable
{

    protected $table='marketer';
    protected $guard='marketer';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','email', 'password',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function detilMarketer()
    {
        return $this->hasOne('App\DetilMarketer');
    }

    public function investor() {
        return $this->hasMany('App\Investor','ref_number','ref_code');
    }

    public function mutasi_marketer(){
        return $this->hasMany('App\MutasiMarketer', 'marketer_id');
    }

    public function dataBank(){
        return $this->hasOne('App\MasterBank','kode_bank','bank');
    }

    public $timestamps = false;
}
