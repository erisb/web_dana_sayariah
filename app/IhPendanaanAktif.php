<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IhPendanaanAktif extends Model
{
    protected $fillable = [
        'id',
        'investor_id',
        'proyek_id',
        'total_dana',
        'nominal_awal',
        'tanggal_invest',
        'efektif_day_proposional',
        'status',
        'last_pay',
    ];
    
    protected $dates = [
        'tanggal_invest','last_pay',
    ];

    protected $table = 'ih_pendanaan_aktif';

    public function investor() {
        return $this->belongsTo('App\Investor');
    }
    public function proyek() {
        return $this->belongsTo('App\Proyek');
    }
    public function logPendanaan() {
        return $this->hasMany('App\LogPendanaan','pendanaanAktif_id');
    }
    public function subscribe(){
        return $this->hasMany('App\Subscribe','pendanaanAktif_id');
    }
    public function log_payout_user() {
        return $this->hasMany('App\log_payout_user');
    }
}
