<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetilInvestor extends Model
{
    protected $table = 'detil_investor';
      protected $fillable = ['agama_investor', 'pic_investor', 'pic_ktp_investor', 'pic_user_ktp_investor'];

    public function investor() {
        return $this->belongsTo('App\Investor');
    }

    public function getVA(){
        $number = $this->attributes['phone_investor'];
        if(strlen($number)<12){
            $number = str_pad($number,12,'0',STR_PAD_RIGHT);
        }
        elseif (strlen($number)>12){
            $number = substr($number, -12);
        }
            
        $number_cut = substr($number, 2, 12);
        $number_va = str_pad($number_cut, 12, '01', STR_PAD_LEFT);
        return $number_va;
         
    }

    public function getVA_konv(){
        $number = $this->attributes['phone_investor'];
        if(strlen($number)<12){
            $number = str_pad($number,12,'0',STR_PAD_RIGHT);
        }
        elseif (strlen($number)>12){
            $number = substr($number, -12);
        }
            
        $number_cut = substr($number, 6, 12);
        $number_va = str_pad($number_cut, 8, '01', STR_PAD_LEFT);
        return $number_va;
         
    }

    public $timestamps = false;
}
