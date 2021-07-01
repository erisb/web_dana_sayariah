<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PemilikPaket extends Model
{
    protected $table="pemilik_paket";
    protected $primaryKey = "id_pemilik";
    public function proyek() {
        return $this->belongsTo('App\Proyek', 'proyek_id');
    }

    public $timestamps = false;
}
