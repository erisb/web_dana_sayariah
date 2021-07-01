<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListImbalUser extends Model
{
    protected $table = 'list_imbal_user';
    // protected $fillable = [
    //     'proyek_id','pendanaan_id','investor_id','tanggal_payout','imbal_payout','total_dana','status_payout','status_update','tgl_update','keterangan','status_libur','keterangan_libur','ket_weekend','created_at','update_at'
    // ];

    public function pendanaan_aktif() {
        return $this->hasMany('App\PendanaanAktif');
    }
}
