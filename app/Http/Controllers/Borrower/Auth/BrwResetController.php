<?php
namespace App\Http\Controllers\Borrower\Auth;

use App\Borrower;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Lang;

class BrwResetController extends Controller
{  
  //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
	
	public function showLinkRequestResetForm()
    {
        return view('auth.passwords.email_borrower',['status' => '']);
    }

    public function sendEmail(Request $request)
    {
        $client = new client();
        $checkexist = Borrower::where('email',$request->email)->first();
        if(!empty($checkexist)){
            $request = $client->post(config('app.apilink')."/borrower/resetPassword",[
                'form_params' =>
                [
                    "email"			=> $request->email,
                  ]
            ]);
            $response = json_decode($request->getBody()->getContents());

            // echo $request->getBody();
            return view('auth.passwords.email_borrower',['status' => $response->status]);

        }else{
            return view('auth.passwords.email_borrower',['status' => '03']);
        }
		
    }
	
	public function showLinkFormResetForm($id)
    {
        $aidi = explode('&',base64_decode($id));
        return view('auth.passwords.reset_borrower')->with(['id'=> $aidi[0], 'email' => $aidi[1], 'status' => '']);
    }

    public function ubahPassword(Request $request)
    {
        $client = new client();
        if($request->password_baru === $request->password_confirmation){
            if(strlen($request->password_confirmation) >= 8 ){
                $req = $client->post(config('app.apilink')."/borrower/resetPasswordProses",[
                    'form_params' =>
                    [
                        "aidi"			    => $request->aidi,
                        "password"			=> $request->password_confirmation,
                    ]
                ]);
                $response = json_decode($req ->getBody()->getContents());

                if($response->status == '01'){
                    return view('auth.passwords.reset_borrower')->with(['id'=> $request->aidi, 'email' => $request->email, 'status' => '01']);
                }else{
                    Auth::guard('borrower')->LoginUsingId($request->aidi);
                    return redirect('/');
                }
            }else{
                return view('auth.passwords.reset_borrower')->with(['id'=> $request->aidi, 'email' => $request->email, 'status' => '03']);
            }
        }else{
            return view('auth.passwords.reset_borrower')->with(['id'=> $request->aidi, 'email' => $request->email, 'status' => '02']);
        }
    }
    
}

 

 
