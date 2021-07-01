<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerusahaanInvestor extends Model
{
    protected $table = 'perusahaan_investor';

    public function investor() {
        return $this->belongsTo('App\Investor');
    }

    public $timestamps = false;
}
