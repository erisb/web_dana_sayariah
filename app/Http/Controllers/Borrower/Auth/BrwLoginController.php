<?php
namespace App\Http\Controllers\Borrower\Auth;

//use App\Borrower;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Lang;
use App\AuditTrail;

class BrwLoginController extends Controller
{  
  //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
	
	//private const  url = 'http://103.28.23.203/borrower/';
	private const  url = 'http://127.0.0.1:8001/borrower/';
	
    protected $redirectTo = '/';
	
	public function username(){
        return 'username';
    }
    public function password(){
        return 'password';
    }
    public function showLoginForm(){
        return redirect('/#loginModalAs');
    }
	
	
    public function login(Request $request)
    {  
		
		$client = new client();
		$response = $client->post(config('app.apilink')."/borrower/login", [
		//$response = $client->post(self::url.'login', [
			//'headers' => ['Content-Type' => 'application/json'],
			'form_params' => [
				'username' => $request->username,
				'password' => $request->password
			]
        ]);
		
		
		$body = json_decode($response->getBody()->getContents());
		// dd($body);
		if($body->status == "sukses"){
			
			Auth::guard('borrower')->LoginUsingId($body->data_borrower->brw_id);
			$username = Auth::guard('borrower')->user()->username;
			Session::put('brw_type',$body->brw_type);
			Session::put('brw_nama',$body->brw_nama);
			Session::put('brw_ptotal',$body->brw_ptotal);
			Session::put('brw_ppake',$body->brw_ppake);
			Session::put('brw_psisa',$body->brw_psisa);
			Session::put('pendanaan',$body->data_pendanaan);
			Session::put('brw_id',$body->data_borrower->brw_id);
			
			$audit = new AuditTrail;
			$audit->fullname = $username;
			$audit->description = "Login";
			$audit->ip_address =  \Request::ip();
			$audit->save();

			return redirect('/');
		}
		elseif($body->status == "gagal_data"){
			return redirect()->to('/#modal_login_borrower')->with('status_kosong','Username & Password Anda Salah ...')->withInput($request->only($this->username(), 'remember'));
		}
		elseif($body->status == "gagal_password"){
			return redirect()->to('/#modal_login_borrower')->with('status_password','Username & Password Anda Salah ...')->withInput($request->only($this->username(), 'remember'));
		}
		elseif($body->status == "suspend"){
			return redirect()->to('/#modal_login_borrower')->with('status_suspend','Username anda kami suspend ...')->withInput($request->only($this->username(), 'remember'));
		}
		
	  
      
    }

    public function logout(){
		
		//$borrowerDetails === null ? null : $borrowerDetails->nama;
		
		$username = Auth::guard('borrower')->user()->username === null ? "Null" : Auth::guard('borrower')->user()->username;
		
		Auth::guard('borrower')->logout();
        \Session::forget('key');
		\Session::flush();
		
		
		$audit = new AuditTrail;
        $audit->fullname = $username;
        $audit->description = "Logout";
        $audit->ip_address =  \Request::ip();
		$audit->save();
		
        return redirect('/');

    }
}

 

 
