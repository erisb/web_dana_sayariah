<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IhListImbalUser extends Model
{
    protected $table = 'ih_list_imbal_user';

    public function pendanaan_aktif() {
        return $this->hasMany('App\PendanaanAktif');
    }
}
