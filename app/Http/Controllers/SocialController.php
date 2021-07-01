<?php

 namespace App\Http\Controllers;

 use Illuminate\Http\Request;
 use Validator,Redirect,Response,File;
 use Socialite;
 use App\Investor;

class SocialController extends Controller
{

  public function redirect($provider)
  {
       return Socialite::driver($provider)->redirect();
  }

  public function callback($provider)
  {
     $getInfo = Socialite::driver($provider)->user();
     $cekEmail = Investor::where('email',$getInfo->email)->where('provider_id',null)->count();
     // dd($cekEmail);die;
     if ($cekEmail > 0)
     {
        return redirect('/#loginModal')->with('status_email', 'Email anda telah terdaftar');
     }
     else
     { 
        $user = $this->createUser($getInfo,$provider);
        auth()->login($user); 
        return redirect()->to('/');
     }
  }
  
  function createUser($getInfo,$provider){
    $user = Investor::where('provider_id', $getInfo->id)->first();
    if (!$user) {
      $user = Investor::create([
         'username'     => $getInfo->email,
         'email'    => $getInfo->email,
         'status'  => 'notfilled',       
         'provider' => $provider,
         'provider_id' => $getInfo->id
      ]);
    }
     return $user;
  }
  
}