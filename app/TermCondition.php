<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TermCondition extends Model
{
    protected $table = 'm_term_condition';
    protected $fillable = [
        'title', 'write', 'deskripsi','typesyarat'
    ];
}
