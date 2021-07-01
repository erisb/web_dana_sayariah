<?php

namespace App\Http\Controllers;

use App\Borrower;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Lang;
use Auth;


class BrwLoginController extends Controller
{  
  use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    public $maxAttempts = 2;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //public function __construct()
    //{
        //$this->middleware('auth:')->except('logout');
    // //}
    // public function username(){
    //     return 'username';
    // }
    // public function password(){
    //     return 'password';
    // }
    // public function showLoginForm(){
    //     return redirect('/#loginModals');
    // }

    public function login(Request $request)
    {   
    //   $this->validate($request, [
    //     'username' => 'required',
    //     'password' => 'required|min:6',
    // ]);

    // // Attempt to log the user in
    // if (Auth::guard('borrower')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
    //     // if successful, then redirect to their intendd location
    //     return redirect()->intended(route('admin.dashboard'));
    // }

    // // If unsuccessful, then redirect back to the login with the form data
    // return redirect()->back()->withInput($request->only('username', 'remember'));
      $borrower = Borrower::where('username',$request->username)->get();
      $data_username = isset($borrower[0]['username']);
      $data_password = isset($borrower[0]['password']);
      $password = $request->password;
     
      if($data_username == null)
      {
          return redirect()->to('/#loginModal')->with('status_kosong','Username Tidak Ditemukan ...')->withInput($request->only($this->username(), 'remember'));
      }
      elseif(!Hash::check($password, $borrower[0]['password']))
      {
        return redirect()->to('/#loginModal')->with('status_kosong','Password tidak sesuai')->withInput($request->only($this->username(), 'remember'));
      
      }elseif($borrower[0]['status'] == "suspend"){
        return redirect('/#loginModal')->with('status_max_login', 'Akun Anda sudah kami suspend. Silahkan hubungi admin untuk mengaktifkan kembali.');
      }
      elseif($data_username == null && !Hash::check($password, $borrower[0]['password'])){
        return redirect('/#loginModal')->with('status_kosong', 'Username Atau Password Anda Salah .');
      }
      else{
      
        if(count($borrower)){
          Auth::guard('borrower')->LoginUsingId($borrower[0]['id']);
          return redirect('/');
        }
      }
    }

    public function logout(){

      if(Auth::guard('borrower'->check)){
        Auth:guard('borrower')->logout;
        return redirect('/');
      }

    }
}

 

 
