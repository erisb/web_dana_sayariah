<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogRekening extends Model
{
    protected $table='log_rekening';

    protected $fillable = [
        'investor_id','nominal','keterangan'
    ];

}
