<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admins;
use Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:admin', ['except' => ['logout']]);
    }
    
    public function showLoginForm()
    {
      return view('pages.admin.auth.login');
    }
    
    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);
      // update data waktu login & ip address
      $admins = Admins::where('email',$request->email)->first();
      if (!empty($admins))
      {
          $admins->update(['last_login_at' => \Carbon\Carbon::now()->toDateTimeString(), 'last_login_ip' => $request->getClientIp()]);
      }
      else
      {
          return redirect()->back()->withInput($request->only('email', 'remember'));
      }

      // Attempt to log the user in
      if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        // if successful, then redirect to their intended location
        $data_user = Admins::where('email',$request->email)->first(['id','password']);
        \Session::put('id',$data_user->id);
        \Session::put('pass',$data_user->password);
        return redirect()->route('admin.dashboard');
      } 
      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()->withInput($request->only('email', 'remember'));
    }
    
    public function logout()
    {
        Auth::guard('admin')->logout();
        \Session::forget('key');
        \Session::flush();
        return redirect()->route('admin.login');
    }
}
