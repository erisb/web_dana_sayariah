<?php

namespace App\Http\Controllers\Mobile\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;
use App\Investor;
use Hash;
use Carbon\Carbon;
use App\Jobs\ProcessEmail;
use App\DetilInvestor;
use App\Token;


class ApiAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'checkToken', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['username', 'password']);
        // return $credentials;

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized']);
        }

        // $expo_token = request(['push_token']);
        // if ($expo_token['push_token']) {
            $investor_token = new Token;
            // $investor_token->mobile_token = $expo_token['push_token'];
        // }

        $investor_token->investor_id = Auth::guard('api')->user()->id;
        $investor_token->login_token = $token;
        $investor_token->save();

        $status = Auth::guard('api')->user()->status;

        if (isset(Auth::guard('api')->user()->email_verif)) {
            $status = 'emailverif';
        }
         
        return $this->respondWithToken($token, $status);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $token = JWTAuth::getToken();
        
        $user_token = Token::where('investor_id', Auth::guard('api')->user()->id)->where('login_token', $token)->first();
        $user_token->delete();

        Auth::guard('api')->logout();

        return response()->json(['message' => 'Anda berhasil keluar']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $status)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL(),
            'status' => $status
        ]);
    }

    public function checkToken (Request $request) {

        $token = $request->token;
        // $tes = JWTAuth::getToken();
        // $payload = JWTAuth::getPayload($tes);
        // $auth = Auth::guard('api')->user();

        try {
            // attempt to verify the credentials
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
    
            return response()->json(['error'=>'Silahkan login kembali'], 500);
    
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
    
            return response()->json(['error'=>'Silahkan login dengan akun Danasyariah'], 500);
    
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
    
            return response()->json(['error'=>'token_absent', 'msg' => $e->getMessage()], 500);
    
        }
        
        //check token with db
        // if (!Token::where('login_token', $token)->first()) {
        //     return response()->json(['error'=>'Silahkan login kembali'], 500);
        // }

        $status = Auth::guard('api')->user()->status;

        if (isset(Auth::guard('api')->user()->email_verif)) {
            $status = 'emailverif';
        }

        $new_token = Auth::guard('api')->refresh();
        $user_token = Token::where('login_token', $token)->first();
        $user_token->login_token = $new_token;
        $user_token->save();

        return $this->respondWithToken($user_token->login_token, $status);
    }

    public function register(Request $request) {

        if (Investor::where('username', $request['username'])->first()!== null) {
            return [
                'error' => 'Username Sudah Terdaftar'
            ];
        }
        if (Investor::where('email', $request['email'])->first()!== null) {
            return [
                'error' => 'Email Sudah Terdaftar'
            ];
        }

        if (!isset($request['referal_code'])){
            $user = Investor::create([
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'email_verif' => str_random(30),
                'status'=>'notfilled',
                'ref_number' => null
            ]);
        }
        else {
            $user = Investor::create([
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'email_verif' => str_random(30),
                'status'=>'notfilled',
                'ref_number' => $request['referal_code']
            ]);
        }

        

        dispatch(new ProcessEmail($user, 'regis'));

        $credentials = [
            'username' => $request['username'],
            'password' => $request['password']
        ];
        // return $credentials;

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized']);
        }

        $expo_token = request(['push_token']);
        if ($expo_token['push_token']) {
            $investor_token = new Token;
            $investor_token->mobile_token = $expo_token['push_token'];
        }

        $investor_token->investor_id = $user->id;
        $investor_token->login_token = $token;
        $investor_token->save();

        $status = Auth::guard('api')->user()->status;

        if (isset(Auth::guard('api')->user()->email_verif)) {
            $status = 'emailverif';
        }
         
        return $this->respondWithToken($token, $status);
    }

    public function datafill (Request $request) {

        if (DetilInvestor::where('phone_investor', $request->phone_investor)->first()) {
            return response()->json(['error'=> 'Nomer Telpon Sudah Pernah Terdaftar']);
        }

        $detil = new DetilInvestor;

        $detil->investor_id = Auth::guard('api')->user()->id;
        $detil->nama_investor = $request->nama_investor;
        $detil->no_ktp_investor = $request->no_ktp_investor;
        $detil->phone_investor = $request->phone_investor;
        $detil->pasangan_investor = $request->pasangan_investor;
        $detil->pasangan_phone = $request->pasangan_phone;
        $detil->job_investor = $request->job_investor;
        $detil->alamat_investor = $request->alamat_investor;
        $detil->pic_investor = $this->upload('pic_investor', $request, $detil->investor_id);
        $detil->pic_ktp_investor = $this->upload('pic_ktp_investor', $request, $detil->investor_id);
        $detil->pic_user_ktp_investor = $this->upload('pic_user_ktp_investor', $request, $detil->investor_id);
        $detil->rekening = $request->rekening;
        $detil->bank = $request->bank;
        $detil->no_npwp_investor = $request->no_npwp_investor;
        $detil->save();

        if (Auth::guard('api')->user()->status === 'notfilled') {
            $user = Investor::where('id', Auth::guard('api')->user()->id)->first();
            $user->status = 'pending';
            $user->save();
        }

        $user = Investor::where('id', Auth::guard('api')->user()->id)->first();
        dispatch(new ProcessEmail($user, 'fill'));

        return [
            'success' => 'Data Berhasil diisi, silahkan menunggu konfirmasi admin'
        ];
        
    }

    private function upload($column,Request $request, $investor_id)
    {
        if ($request->hasFile($column)) {
            $file = $request->file($column);
            $filename = Carbon::now()->toDateString() . $column . '.' . $file->getClientOriginalExtension();
//            save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . $investor_id;
            $path = $file->storeAs($store_path, $filename, 'public');
//            save gambar yang di upload di public storage
            return $path;
        }
        else {
            return null;
        }

    }
}

