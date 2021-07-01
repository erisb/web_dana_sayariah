<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogPendanaan extends Model
{
    protected $table='log_pendanaan';

    protected $fillable = [
        'nominal','pendanaanAktif_id','tipe'
    ];
    protected $dates = [
        'created_at','updated_at'
    ];

    public function pendanaanAktif() {
        return $this->belongsTo('App\PendanaanAktif');
    }
}
