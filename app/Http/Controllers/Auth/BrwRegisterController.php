<?php

namespace App\Http\Controllers\Auth;

use App\Borrower;
//use App\DetilInvestor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Lang;
use Auth;

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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //public function __construct()
    //{
        //$this->middleware('guest');
    //}

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
        }, 'space not allowed');

        $validator =  Validator::make($data, [
            'username' => 'required|without_spaces|string|max:50|unique:brw_users',
            'email' => 'required|string|email|max:75|unique:brw_users',
            'password' => 'required|string|min:6|confirmed',
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
            'username' => $data['username'],
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
        
        // if ($this->validator($request->all())->fails()) {
        //     // return redirect()->to('/#registerModal')->withErrors($validator)->withInput();
        //     return redirect()->to('/#registerModal')
        //     ->withInput()
        //     ->withErrors($this->validator($request->all())->validate());
        // }

       
        
        //if($borrower){
            // if($data_username == $request->username){
            //     echo "username udah ada ni bro";die;
            // }
            // elseif($data_email == $request->email){
            //     echo "email udah ada ni bro";die;
            // }
        //}
        $this->validator($request->all())->validate();
        $Borrower = $this->create($request->all());

        event(new Registered($Borrower));
        Auth::guard('borrower')->LoginUsingId($Borrower->id);
        return redirect('/');
       
    }

}
