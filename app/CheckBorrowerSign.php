<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckBorrowerSign extends Model
{
    protected $table = 'cek_borrower_reg_sign';
    protected $primaryKey = 'id_borrower_cek_reg';
    protected $fillable = ['user_id','provider_id','tgl_register'];
}