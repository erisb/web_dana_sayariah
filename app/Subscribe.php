<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    //
    protected $fillable = [
        'interval','investor_id','pendanaanAktif_id','last_pay','BANK','rekening','pemilik_rekening',
    ];

    protected $dates = [
        'last_pay'
    ];

    public function investor(){
        return $this->belongsTo('App\Investor');
    }

    public function pendanaan(){
        return $this->belongsTo('App\PendanaanAktif','pendanaanAktif_id');
    }
}
