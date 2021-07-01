<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\TestimoniPendana;

class CmsController extends Controller
{
    
    public function media()
    {
       
        $media= TestimoniPendana::all()->where('type','==',2);
                        
        return view('includes.footerhome')->with(['media' => $media]);
    }

    public function perjanjian()
    {
       
        $perjanjian= TestimoniPendana::all()->where('type','==',3);
                        
        return view('includes.footerhome')->with(['perjanjian' => $perjanjian]);
    }

    
}
