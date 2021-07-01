<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MutasiMarketer extends Model
{
    protected $table = 'mutasi_marketer';

    protected $dates = ['created_at','updated_at'];

    protected $hidden = [
        'marketer_id'
    ];
    
    public function investor() {
        return $this->belongsTo('App\Marketer', 'marketer_id');
    }
}
