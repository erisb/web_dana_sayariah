<?php

namespace App\Http\Controllers\Auth;

use App\Investor;
use App\DetilInvestor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Jobs\ProcessEmail;
use App\Jobs\NewProcessEmail;
use App\Mail\EmailAktifasiPendana;
use Mail;
use Lang;
use Auth;

class RegisterController extends Controller
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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/resendMail';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        }, 'Tidak boleh ada spasi');

        $validator =  Validator::make($data, [
            'username' => 'required|without_spaces|string|max:255|unique:investor',
            'email' => 'required|string|email|max:255|unique:investor',
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
        $user = Investor::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verif' => str_random(30),
			'status'=>'Not Active',
            // 'status'=>'notfilled',
            //'ref_number' => $data['ref_number']
            
        ]);

        // dispatch(new NewProcessEmail($user, 'regis'));

        $email = new EmailAktifasiPendana($user);
        Mail::to($user->email)->send($email);
        
        return $user;    
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        
        // if ($this->validator($request->all())->fails()) {
        //     // return redirect()->to('/#registerModal')->withErrors($validator)->withInput();
        //     return redirect()->to('/#registerModal')
        //     ->withInput()
        //     ->withErrors($this->validator($request->all())->validate());
        // }

        //$this->validator($request->all())->validate();
       
		if ($this->validator($request->all())->fails()) {
				
			$errors = $validator->errors()->all();
			//return redirect()->to('/#modal_register_borrower')->withErrors($errors);
			return redirect()->to('/#modal_register_investor')->withInput($request->only($request->username, 'remember'))->withErrors($validator->messages());
		
		}else{
			$user = $this->create($request->all());

			// event(new Registered($user));
			// Auth::loginUsingId($user->id);
			// return redirect('/');
			// return redirect($this->redirectTo)->with('reg_sukses', 'Pendaftaran Sukses, Silahkan Anda Login Dan isi data anda')
			return redirect($this->redirectTo)->with('reg_sukses', 'Pendaftaran Sukses, Cek Email step selanjutnya')
											 ->with('email', $request->email)
											  ->with('email_verif',$request->email_v);
			// $this->guard()->login($user);
			// $message='Register Sukses';

			// return $this->registered($request, $user, $message)
			//                 ?: redirect($this->redirectPath());
		}
		
		
    }

}
