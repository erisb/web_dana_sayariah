<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GambarProyek extends Model
{
    protected $table='gambar_proyek';

    protected $fillable = [
        'gambar'
    ];

    public function proyek() {
        return $this->belongsTo('App\Proyek');
    }
}
