<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MutasiInvestor extends Model
{
    protected $table = 'mutasi_investor';

    protected $dates = ['created_at','updated_at'];

    protected $hidden = [
        'investor_id'
    ];
    
    public function investor() {
        return $this->belongsTo('App\Investor');
    }
}
