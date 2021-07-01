<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogSuspend extends Model
{
    protected $table = 'log_suspend';
    protected $fillable = ['suspended_by', 'keterangan'];

}
