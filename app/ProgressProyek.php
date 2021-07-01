<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgressProyek extends Model
{
    protected $table='progress_proyek';

    protected $fillable = ['proyek_id', 'tanggal', 'pic', 'deskripsi'];

    public function proyek() {
        return $this->belongsTo('App\Proyek');
    }
}
