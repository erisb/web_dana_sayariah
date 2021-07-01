<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckUserSign extends Model
{
    protected $table = 'cek_user_reg_sign';
    protected $primaryKey = 'id_user_cek_reg';
    // protected $fillable = ['user_id','provider_id','tgl_register'];
}
