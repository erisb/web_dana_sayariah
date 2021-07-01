<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Interfaces\Investable;
use Tymon\JWTAuth\Contracts\JWTSubject;
// use Illuminate\Auth\Passwords\CanResetPassword;

class Investor extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table = 'investor';

    protected $fillable = [
        'username', 'email', 'password', 'email_verif','ref_number', 'status', 'provider', 'provider_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rekeningInvestor() {
        return $this->hasOne('App\RekeningInvestor');
    }
    public function detilInvestor() {
        return $this->hasOne('App\DetilInvestor');
    }
    public function mutasiInvestor() {
        return $this->hasMany('App\MutasiInvestor');
    }
    public function perusahaanInvestor(){
        return $this->hasOne('App\PerusahaanInvestor');
    }
    public function pendanaanAktif() {
        return $this->hasMany('App\PendanaanAktif');
    }
    public function penarikanDana() {
        return $this->hasMany('App\PenarikanDana');
    }
    // public function activeCart(){
    //     return $this->hasMany('App\Cart');
    // }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new Notifications\ResetPasswordNotification($token));
    }
    
    public function subscribe(){
        return $this->hasMany('App\Subscribe');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
