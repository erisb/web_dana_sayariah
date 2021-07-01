<?php
namespace App\Http\Controllers\Borrower\Auth;

use App\Borrower;
//use App\DetilInvestor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Jobs\ProcessEmailBorrower;
use Mail;
use App\Mail\EmailAktifasiPenerimaPendanaan;
use Lang;
//use Auth;

class BrwRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
	//private const  url = 'http://103.28.23.203/borrower/';
	private const  url = 'http://127.0.0.1:8001/borrower/';
	
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $redirectTomail = '/resendMailborrower';
    
	public function username_borrower(){
        return 'username_borrower';
    }
	public function email(){
        return 'email';
    }
    public function password(){
        return 'password';
    }
    public function showRegisterForm(){
        return redirect('/#modal_register_borrower');
    }
	
    protected function validator(array $data)
    {
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        }, 'Tidak boleh ada spasi');

        $validator =  Validator::make($data, [
            'username' => 'required|without_spaces|string|max:50|unique:brw_users',
            'email' => 'required|string|email|max:75|unique:brw_users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $Borrower = Borrower::create([
            'username' => $data['username_borrower'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verif' => Null,
            'status'=>'notfilled',
            //'ref_number' => $data['ref_number']
            
        ]);

        //dispatch(new ProcessEmail($user, 'regis'));
        
        return $Borrower;    
    }

    public function register(Request $request)
    {
		$lengthUsername 	= strlen($request->username_borrower);
		$lengthPass 		= strlen($request->password);
		$email 				= $request->email; 
		
		if($lengthUsername < 4){
			return redirect()->to('/#modal_register_borrower')->with('brw_status_username','Username Anda Kurang dari 4, minimal 4 ...')->withInput($request->only($this->username_borrower(), 'remember'));
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			
			return redirect()->to('/#modal_register_borrower')->with('brw_status_email','Format Email Tidak Valid ...')->withInput($request->only($this->email(), 'remember'));
		
		}
		if($lengthPass < 8 ){
			
			return redirect()->to('/#modal_register_borrower')->with('brw_status_length_password','Password Kurang Dari 8 Digit, Minimal Harus 8 Digit ...');
		
		}
		if($request->password != $request->password_confirmation){
			
			return redirect()->to('/#modal_register_borrower')->with('brw_status_same_password','Password Tidak Sama, Pastikan Password Harus Sama ...');
			
		}
		if( strlen($request->password_confirmation) < 8){
			
			return redirect()->to('/#modal_register_borrower')->with('brw_status_length_confirm_password','Password Tidak Sama, Pastikan Password Harus Sama ...')->withInput($request->only($this->password(), 'remember'));
			
		}
		else{

            $email_verif = str_random(30);
			
			
			
			$client = new client();
			$response = $client->post(config('app.apilink')."/borrower/register", [
				
				'form_params' => [
					'username' => $request->username_borrower,
					'email' => $request->email,
                    'password' => $request->password,
                    'email_verif' => $email_verif
				]
			]);
			
			$body = json_decode($response->getBody()->getContents());
			$validator = $this->validator($request->all());
			
			
			
			
			
			// if ($this->validator($request->all())->fails()) {
				
				// $errors = $validator->errors()->all();
				// //return redirect()->to('/#modal_register_borrower')->withErrors($errors);
				// //return redirect()->to('/#modal_register_borrower')->with('brw_status_username','Username Anda Sudah Terdaftar ...')->withInput($request->only($this->username_borrower(), 'remember'));
				// return redirect()->to('/#modal_register_borrower')->withInput($request->only($request->username_borrower, 'remember'))->withErrors($validator->messages());
			
			// }
			
			
			if($body->status == "gagal_username"){
				
			
				//return redirect()->to('/#modal_register_borrower')->with(brw_status_username)->withInput($request->only($this->username(), 'remember'));
				return redirect()->to('/#modal_register_borrower')->with('brw_status_username','Akun Anda Sudah Terdaftar ...')->withInput($request->only($this->username_borrower(), 'remember'));
			}
			if($body->status == "gagal_email"){
				
				return redirect()->to('/#modal_register_borrower')->with('brw_status_email','Email Anda Sudah Terdaftar ...')->withInput($request->only($request->email, 'remember'))->withInput($request->only($this->email(), 'remember'));
			}
			
			else{

                // dispatch(new ProcessEmailBorrower($request->username, $request->email, $email_verif, 'regis'));
                // Auth::guard('borrower')->LoginUsingId($body->data_borrower->brw_id);
                
                $email = new EmailAktifasiPenerimaPendanaan($request->username, $request->email, $email_verif);
                Mail::to($request->email)->send($email);
				
                // return redirect('/');
                return redirect($this->redirectTomail)->with('reg_sukses', 'Pendaftaran Sukses, Cek Email step selanjutnya')
                                                  ->with('email', $request->email)
                                                  ->with('email_verif',$request->email_verif);
			}
			
		}
       
    }

    public function emailConfirm($code) {
        $user = Borrower::where('email_verif', $code)->first();

        if(!$user){
            return "False";
        }
        else{
            if($user->email_verif === $code){
                $user->status = 'notfilled';
                $user->email_verif = Null;
                $user->save();

                return redirect('/');

            }
            else{
                return redirect('/#loginModalAs');
            }
        }
    }
	
}
