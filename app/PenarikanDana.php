<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenarikanDana extends Model
{
    protected $table = 'penarikan_dana';

    protected $fillable = [
        'investor_id','jumlah','no_rekening','bank','accepted','perihal'
    ];

    public function investor() {
        return $this->belongsTo('App\Investor');
    }
}
