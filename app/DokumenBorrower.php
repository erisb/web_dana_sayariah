<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DokumenBorrower extends Model
{
    protected $table = 'brw_dokumen';
    protected $primaryKey = 'id_dokumen';
    protected $fillable = ['id_dokumen','brw_id','nama_dokumen','path_file','author'];
}
