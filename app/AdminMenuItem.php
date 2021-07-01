<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminMenuItem extends Model
{
    protected $table = 'admin_menu_items';
    protected $fillable=['label','link','parent','sort','class','menu','depth','role_id'];
}
