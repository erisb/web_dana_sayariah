<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetilMarketer extends Model
{
    protected $table='detil_marketer';

    public function marketer()
    {
        return $this->belongsTo('App\Marketer');
    }
}
