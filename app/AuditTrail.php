<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    protected $table = 'audit_trail';
    protected $fillable = ['fullname','description','ip_address'];

}
