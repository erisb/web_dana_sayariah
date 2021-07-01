<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Lang;
use Illuminate\Http\Request;
use Auth;
use App\Investor;
use App\LogSuspend;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function username(){
        return 'username';
    }
    public function password(){
        return 'password';
    }
    public function showLoginForm(){
        return redirect('/#loginModalAs')->with(['skinvestor'=>'skinniinni']);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            \Auth::logoutOtherDevices(request('password'));
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    // public function logout(Request $request)
    // {
    //   Auth::logout();
    //   \Session::forget('key');
    //   \Session::flush();
    //   return redirect()->back();
    // }

    // protected function validateLogin(Request $request)
    // {
    //     $request->validate([
    //         $this->username() => 'required|string',
    //         'password' => 'required|string|confirmed',
    //         'password_confirmation'  =>  'required',
    //     ]);
    // }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = $request->only($this->username(), 'remember');
        $password = $request->only($this->password());

        $data = Investor::where('username',$user)->first();
        $data_user = $data['email_verif'];
        $data_username = $data['username'];
        $data_password = $data['password'];
        // var_dump($data_user);die;
        if($data_username == null)
        {
            return redirect()->to('/#modal_login_investor')->with('status_kosong','Username & Password Anda Salah ...')->withInput($request->only($this->username(), 'remember'));
        }
        elseif ($data_password != $password)
        {
            return redirect()->to('/#modal_login_investor')->with('status_kosong','Username & Password Anda Salah')->withInput($request->only($this->username(), 'remember'));
            // return redirect()->to('/#loginModal')
            //     ->withInput($request->only($this->username(), 'remember'))
            //     ->withErrors(['usernameLog' => Lang::get('auth.failed'),
            //     ]);
        }
        elseif($data_user != null)
        {
            return redirect()->to('/#modal_login_investor')->with('status_sukses','Silahkan aktivasi akun anda.')->withInput($request->only($this->username(), 'remember'));
        }
            
    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $this->maxAttempts()
        );
    }

    protected function sendLockoutResponse(Request $request)
    {
        $cek_username = Investor::where('username',$request->username)->first();
        
        if (isset($cek_username))
        {
            $status = 'suspend';
            $keterangan = 'Salah masukkan password lebih dari 3x';
            $suspended_by = 'Sistem';
            $updateDetails = [
                'status' => $status,
                'keterangan' =>  $keterangan,
                'suspended_by' =>  $suspended_by
            ];
            //Investor::where('username',$request->username)->update(['status' => $status]);
            Investor::where('username',$request->username)->update($updateDetails);
            $Log = new LogSuspend;
            $Log->keterangan = 'Salah masukkan password lebih dari 3x';
            $Log->suspended_by = 'Sistem';
            $Log->save();
            $redirect = redirect('/#modal_login_investor')->with('status_max_login', 'Akun Anda sudah kami suspend. Silahkan hubungi admin untuk mengaktifkan kembali.');
        }
        else
        {
            $redirect = redirect('/#modal_login_investor')->with('status_kosong','Username & Password Anda Salah ...');
        }

        return $redirect;
    }
}
