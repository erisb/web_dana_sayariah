<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\CanResetPassword;
// use Illuminate\Foundation\Auth\User as Authenticatable;

class BorrowerPembayaran extends Model
{
    // use Notifiable;
    protected $primaryKey = 'pembayaran_id';
    protected $table = 'brw_pembayaran';
    protected $guard = 'borrower';

    protected $fillable = [
        'pembayaran_id', 'invoice_id', 'brw_id', 'pendanaan_id','tipe_pembayaran','tipe_percepatan','nilai_pelunasan','pic_pemabyaran','tgl_pembayaran','status','keterangan'
    ];
    
}
