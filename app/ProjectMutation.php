<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectMutation extends Model
{
    //
    protected $fillable = [
        'nominal','tipe','proyek_id',
    ];

    public function Proyek(){
        return $this->belongsTo('App\Proyek','proyek_id');
    }
}
