<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmpSelectedProyek extends Model
{
    // protected $table='tmp_selected_proyek';

    // protected $fillable = [
    //     'investor_id','proyek_id','qty'
    // ];
    // protected $dates = [
    //     'created_at','updated_at'
    // ];
    protected $table = 'tmp_selected_proyek';
    protected $fillable = ['investor_id','proyek_id','qty','total_price', 'status','invoice_status', 'invoice_id', 'no_va', 'amount', 'trx_date_va'];

}
