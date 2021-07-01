<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestimoniPendana extends Model
{
    protected $table = 'cms';
    protected $primaryKey = 'id';
    protected $fillable = ['id','content','link','file','gambar','nama','type','publish'];
}
