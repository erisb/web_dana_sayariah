<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    protected $table = 'm_harilibur';

    protected $fillable = [
        'tgl_harilibur', 'deskripsi', 'dibuat', 'dimodifikasi','status', 'created_at',
    ];
}
