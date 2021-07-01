<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ECollBni extends Model
{
    protected $table = 'e_coll_bni';
    protected $primaryKey = 'id_ecoll';
    protected $fillable = [
        'nama','no_va','tgl_payment'
    ];
}