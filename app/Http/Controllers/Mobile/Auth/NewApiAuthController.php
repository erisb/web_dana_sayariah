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
use App\Mail\EmailAktifasiPendana;
use Mail;
use App\DetilInvestor;
use App\InvestorLocation;
use App\Token;
use App\TermCondition;
use App\Jobs\InvestorVerif;
use Image;
use App\BniEnc;
use App\RekeningInvestor;
use GuzzleHttp\Client;
use DB;
use Exception;
use Storage;
use App\Http\Controllers\RekeningController;


class NewApiAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    //development
    // private const CLIENT_ID = '805';
    // private const KEY = '34e64c3fe14335eb64f5c1b2d6e75508';
    // private const API_URL = 'https://apibeta.bni-ecollection.com/';


    //production
    private const CLIENT_ID = '757';
    private const KEY = '9f918ff65dc67027fc5670b7b7a7e89f';
    private const API_URL = 'https://api.bni-ecollection.com/';
    
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'checkToken', 'resendEmail', 'validateOTP', 'register', 'register_new_new', 'newCheckToken', 'newnewCheckToken', 'verificationCode', 'verificationOtp', 'checkVersion', 'checkPhoneNumber', 'test', 'getTermCondition', 'datafillbaru_VA_konv']]);
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

        // if (isset(Auth::guard('api')->user()->email_verif)) {
        //     $status = 'emailverif';
        // }
         
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
        return $this->respondWithToken(Auth::guard('api')->refresh(), Auth::guard('api')->user()->status);
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

    public function newCheckToken (Request $request) {

        $token = $request->token;
        
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

        $status = Auth::guard('api')->user()->status;

        // if (isset(Auth::guard('api')->user()->email_verif)) {
        //     $status = 'emailverif';
        // }

        // $new_token = Auth::guard('api')->refresh();
        // $user_token = Token::where('login_token', $token)->first();
        // $user_token->login_token = $new_token;
        // $user_token->save();

        return $this->respondWithToken($token, $status);
    }

    public function newnewCheckToken (Request $request) {

        $token = $request->token;
        
        try {
            // attempt to verify the credentials
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
    
            return response()->json(['error'=>'Token Expired, Silahkan login kembali'], 500);
    
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
    
            return response()->json(['error'=>'Token Invalid, Silahkan login dengan akun Danasyariah'], 500);
    
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
    
            return response()->json(['error_token_absent'=>'token_absent', 'msg' => $e->getMessage()], 500);
    
        }

        $status = Auth::guard('api')->user()->status;

        // if (isset(Auth::guard('api')->user()->email_verif)) {
        //     $status = 'emailverif';
        // }

        // $new_token = Auth::guard('api')->refresh();
        // $user_token = Token::where('login_token', $token)->first();
        // $user_token->login_token = $new_token;
        // $user_token->save();

        return $this->respondWithToken($token, $status);
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
                'status'=>'Not Active',
                'ref_number' => null
            ]);
        }
        else {
            $user = Investor::create([
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'email_verif' => str_random(30),
                'status'=>'Not Active',
                'ref_number' => $request['referal_code']
            ]);
        }

        // dispatch(new ProcessEmail($user, 'regis'));

        $email = new EmailAktifasiPendana($user);
        Mail::to($user->email)->send($email);

        return response()->json(['status' => 'Not Active']);
    }

    public function datafill (Request $request) {

        if (DetilInvestor::where('phone_investor', $request->no_hp)->first()) {
            return response()->json(['error'=> 'Nomer Telpon Sudah Pernah Terdaftar']);
        }
        if (DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first()) {
            return response()->json(['error'=> 'Data ini sudah terdaftar']);
        }
        // var_dump(json_decode$request);die;
        $detil = new DetilInvestor;

        $detil->investor_id = Auth::guard('api')->user()->id;
        $detil->tipe_pengguna = null;
        $detil->nama_investor = $request->nama;
        $detil->no_ktp_investor = $request->no_ktp;
        $detil->no_npwp_investor = $request->no_npwp == '' ? null : $request->no_npwp;
        $detil->phone_investor = $request->no_hp;
        $detil->alamat_investor = $request->alamat;
        $detil->provinsi_investor = $request->provinsi;
        $detil->kota_investor = $request->kota;
        $detil->kode_pos_investor = $request->kode_pos;
        $detil->tempat_lahir_investor = $request->tempat_lahir;
        $detil->tgl_lahir_investor = $request->tgl_lahir.'-'.$request->bln_lahir.'-'.$request->thn_lahir;
        $detil->jenis_kelamin_investor = $request->jenis_kelamin;
        $detil->status_kawin_investor = null;
        $detil->status_rumah_investor = null;
        $detil->agama_investor = null;
        $detil->pekerjaan_investor = null;
        $detil->bidang_pekerjaan = null;
        $detil->online_investor = null;
        $detil->pendapatan_investor = null;
        $detil->asset_investor = null;
        $detil->pengalaman_investor = null;
        $detil->pendidikan_investor = null;
        $detil->bank_investor = $request->bank;
        $detil->rekening = $request->rekening; 
        $detil->nama_pemilik_rek = $request->nama_pemilik_rek;
        $detil->pic_investor = $this->upload('pic_investor', $request, Auth::user()->id);
        $detil->pic_ktp_investor = $this->upload('pic_ktp_investor', $request, Auth::user()->id);
        $detil->pic_user_ktp_investor = $this->upload('pic_user_ktp_investor', $request, Auth::user()->id);
        // $detil->pic_investor = null;
        // $detil->pic_ktp_investor = null;
        // $detil->pic_user_ktp_investor = null;
        $detil->jenis_badan_hukum = null;
        $detil->nama_perwakilan = null;
        $detil->no_ktp_perwakilan = null;

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

    public function datafillNew (Request $request) {

        if (DetilInvestor::where('phone_investor', $request->no_hp)->first()) {
            return response()->json(['error'=> 'Nomer Telpon Sudah Pernah Terdaftar']);
        }
        if (DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first()) {
            return response()->json(['error'=> 'Data ini sudah terdaftar']);
        }
        // var_dump(json_decode$request);die;
        $detil = new DetilInvestor;

        $detil->investor_id = Auth::guard('api')->user()->id;
        $detil->tipe_pengguna = null;
        $detil->nama_investor = $request->nama;
        $detil->no_ktp_investor = $request->no_ktp;
        $detil->no_npwp_investor = $request->no_npwp == '' ? null : $request->no_npwp;
        $detil->phone_investor = $request->no_hp;
        $detil->alamat_investor = $request->alamat;
        $detil->provinsi_investor = $request->provinsi;
        $detil->kota_investor = $request->kota;
        $detil->kode_pos_investor = $request->kode_pos;
        $detil->tempat_lahir_investor = $request->tempat_lahir;
        $detil->tgl_lahir_investor = $request->tgl_lahir.'-'.$request->bln_lahir.'-'.$request->thn_lahir;
        $detil->jenis_kelamin_investor = $request->jenis_kelamin;
        $detil->status_kawin_investor = null;
        $detil->status_rumah_investor = null;
        $detil->agama_investor = null;
        $detil->pekerjaan_investor = null;
        $detil->bidang_pekerjaan = null;
        $detil->online_investor = null;
        $detil->pendapatan_investor = null;
        $detil->asset_investor = null;
        $detil->pengalaman_investor = null;
        $detil->pendidikan_investor = null;
        $detil->bank_investor = $request->bank;
        $detil->rekening = $request->rekening; 
        $detil->nama_pemilik_rek = $request->nama_pemilik_rek;
        // $detil->pic_investor = $this->upload('pic_investor', $request, Auth::user()->id);
        // $detil->pic_ktp_investor = $this->upload('pic_ktp_investor', $request, Auth::user()->id);
        // $detil->pic_user_ktp_investor = $this->upload('pic_user_ktp_investor', $request, Auth::user()->id);
        $detil->pic_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_investor.' . $request->file('pic_investor')->getClientOriginalExtension();
        $detil->pic_ktp_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.' . $request->file('pic_ktp_investor')->getClientOriginalExtension();
        $detil->pic_user_ktp_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $request->file('pic_user_ktp_investor')->getClientOriginalExtension();
        $detil->jenis_badan_hukum = null;
        $detil->nama_perwakilan = null;
        $detil->no_ktp_perwakilan = null;

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

    public function actionUpload1(Request $request)
    {
        if ($request->hasFile('pic_investor')) {
            $file = $request->file('pic_investor');
            $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_investor.' . $file->getClientOriginalExtension();
//            save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::user()->id;
            $path = $file->storeAs($store_path, $filename, 'public');
//            save gambar yang di upload di public storage
            return response()->json([
                'success' => 'Berhasil di upload'
            ]);
        }
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
        }
    }

    public function actionUpload2(Request $request)
    {
        if ($request->hasFile('pic_ktp_investor')) {
            $file = $request->file('pic_ktp_investor');
            $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_ktp_investor.' . $file->getClientOriginalExtension();
//            save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::user()->id;
            $path = $file->storeAs($store_path, $filename, 'public');
//            save gambar yang di upload di public storage
            return [
                'success' => 'Berhasil di upload'
            ];
        }
        else {
            return [
                'failed' => 'File Kosong'
            ];
        }
    }

    public function actionUpload3(Request $request)
    {
        if ($request->hasFile('pic_user_ktp_investor')) {
            $file = $request->file('pic_user_ktp_investor');
            $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $file->getClientOriginalExtension();
//            save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::user()->id;
            $path = $file->storeAs($store_path, $filename, 'public');
//            save gambar yang di upload di public storage
            return [
                'success' => 'Berhasil di upload'
            ];
        }
        else {
            return [
                'failed' => 'File Kosong'
            ];
        }
    }

    public function actionUpload1new(Request $request)
    {
        if ($request->hasFile('pic_investor')) {
            $file = $request->file('pic_investor');
            $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_investor.' . $file->getClientOriginalExtension();
            //  save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::guard('api')->user()->id;
            //  save gambar yang di upload di public storage
            $path = $file->storeAs($store_path, $filename, 'public');

            // Storage::disk('public')->delete('user/'.Auth::guard('api')->user()->id.'/'.$filename);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'success' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }
        }
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
        }
    }

    public function actionUpload2new(Request $request)
    {
        if ($request->hasFile('pic_ktp_investor')) {
            $file = $request->file('pic_ktp_investor');
            $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_ktp_investor.' . $file->getClientOriginalExtension();
            //  save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::guard('api')->user()->id;
            $path = $file->storeAs($store_path, $filename, 'public');
            //  save gambar yang di upload di public storage

            // Storage::disk('public')->delete('user/'.Auth::guard('api')->user()->id.'/'.$filename);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'success' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }
        }
        else {
            return [
                'failed' => 'File Kosong'
            ];
        }
    }

    public function actionUpload3new(Request $request)
    {
        if ($request->hasFile('pic_user_ktp_investor')) {
            $file = $request->file('pic_user_ktp_investor');
            $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $file->getClientOriginalExtension();
            //  save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::guard('api')->user()->id;
            $path = $file->storeAs($store_path, $filename, 'public');
            //  save gambar yang di upload di public storage
            
            // Storage::disk('public')->delete('user/'.Auth::guard('api')->user()->id.'/'.$filename);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'success' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }
        }
        else {
            return [
                'failed' => 'File Kosong'
            ];
        }
    }

    public function actionUpload1newnew(Request $request)
    {
        if ($request->hasFile('pic_investor')) {
            $file = $request->file('pic_investor');
            $resize = Image::make($file)->save();
            $filename = Carbon::now()->toDateString() . 'pic_investor.' . $file->getClientOriginalExtension();
            //  save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::guard('api')->user()->id;
            //  save gambar yang di upload di public storage
            $path = $file->storeAs($store_path, $filename, 'public');

            // Storage::disk('public')->delete('user/'.Auth::guard('api')->user()->id.'/'.$filename);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'success' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }
        }
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
        }
    }

    public function actionUpload2newnew(Request $request)
    {
        if ($request->hasFile('pic_ktp_investor')) {
            $file = $request->file('pic_ktp_investor');
            $resize = Image::make($file)->save();
            $filename = Carbon::now()->toDateString() . 'pic_ktp_investor.' . $file->getClientOriginalExtension();
            //  save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::guard('api')->user()->id;
            $path = $file->storeAs($store_path, $filename, 'public');
            //  save gambar yang di upload di public storage

            // Storage::disk('public')->delete('user/'.Auth::guard('api')->user()->id.'/'.$filename);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'success' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }
        }
        else {
            return [
                'failed' => 'File Kosong'
            ];
        }
    }

    public function actionUpload3newnew(Request $request)
    {
        if ($request->hasFile('pic_user_ktp_investor')) {
            $file = $request->file('pic_user_ktp_investor');
            $resize = Image::make($file)->save();
            $filename = Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $file->getClientOriginalExtension();
            //  save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::guard('api')->user()->id;
            $path = $file->storeAs($store_path, $filename, 'public');
            //  save gambar yang di upload di public storage
            
            // Storage::disk('public')->delete('user/'.Auth::guard('api')->user()->id.'/'.$filename);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'success' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }
        }
        else {
            return [
                'failed' => 'File Kosong'
            ];
        }
    }
    
    public function register_new(Request $request) {

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

        $user = Investor::create([
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'email_verif' => Null,
            'status'=>'notfilled',
        ]);
        
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

        // if (isset(Auth::guard('api')->user()->email_verif)) {
        //     $status = 'emailverif';
        // }
         
        return $this->respondWithToken($token, $status);

        // if (!isset($request['referal_code'])){
        //     $user = Investor::create([
        //         'username' => $request['username'],
        //         'email' => $request['email'],
        //         'password' => Hash::make($request['password']),
        //         'email_verif' => str_random(30),
        //         'status'=>'Not Active',
        //         'ref_number' => null
        //     ]);
        // }
        // else {
        //     $user = Investor::create([
        //         'username' => $request['username'],
        //         'email' => $request['email'],
        //         'password' => Hash::make($request['password']),
        //         'email_verif' => str_random(30),
        //         'status'=>'Not Active',
        //         'ref_number' => $request['referal_code']
        //     ]);
        // }

        // dispatch(new ProcessEmail($user, 'regis'));

        //return response()->json(['status' => 'Not Active']);
    }

public function register_new_new(Request $request) {

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
                'status'=>'Not Active',
                'ref_number' => null
            ]);
        }
        else {
            $user = Investor::create([
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'email_verif' => str_random(30),
                'status'=>'Not Active',
                'ref_number' => $request['referal_code']
            ]);
        }

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

        // dispatch(new ProcessEmail($user, 'regis'));

        $email = new EmailAktifasiPendana($user);
        Mail::to($user->email)->send($email);

        return response()->json(['status' => 'Not Active']);
    }

    public function resendEmail(Request $request){
        $email = $request->email ? $request->email : 'null';
        if($request->email){
            $user = Investor::where('email', $email)->first();
            $email = new EmailAktifasiPendana($user);
            $send_mail = Mail::to($user->email)->send($email);
            // $send_mail = dispatch(new ProcessEmail($user, 'regis'));
        }else{
            $user = Investor::where('id', Auth::guard('api')->user()->id)->first();
            $email = new EmailAktifasiPendana($user);
            $send_mail = Mail::to($user->email)->send($email);
            // $send_mail = dispatch(new ProcessEmail($user, 'regis'));
        }
        if(!$send_mail){
            return response()->json(['status' => 'Success']);
        }else{
            return response()->json(['status' => 'Failed']);
        }
    }

    public function validateOTP(Request $request){

        // $id = 52215;
        $investor_id=Auth::guard('api')->user()->id;

        $input_otp = $request->no_otp;

        $query = Investor::where('id', $investor_id)->first();
        $otp = $query->otp;

        if($input_otp == $otp){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'failed']);
        }
    }  

    public function verificationOtp(Request $request){

        // $id = '52215';
        $id=Auth::guard('api')->user()->id;

        // $phone_get = DetilInvestor::where('investor_id',$id)->first(['phone_investor']);
        // $to =  $phone_get;
        // $to = '081374953433';

        $to = $request->no_telp;
        $otp = rand(100000, 999999);
        $text =  'Kode OTP : '.$otp.' Silahkan masukan kode ini untuk melanjutkan proses pendaftaran anda.';

        //send to db
        $detil = Investor::where('id', $id)->update(['otp' => $otp]);

        $pecah              = explode(",",$to);
        $jumlah             = count($pecah);
        $from               = "DANASYARIAH"; //Sender ID or SMS Masking Name, if leave blank, it will use default from telco
        // $username           = "smsvirodemo";
        // $password           = "qwerty@123";
        // $from               = "DANASYARIAH";
        $username           = "danasyariahpremium"; //your smsviro username
        $password           = "Dsi701@2019"; //your smsviro password
        $postUrl            = "http://107.20.199.106/restapi/sms/1/text/advanced"; # DO NOT CHANGE THIS
        
        for($i=0; $i<$jumlah; $i++){
            if(substr($pecah[$i],0,2) == "62" || substr($pecah[$i],0,3) == "+62"){
                $pecah = $pecah;
            }elseif(substr($pecah[$i],0,1) == "0"){
                $pecah[$i][0] = "X";
                $pecah = str_replace("X", "62", $pecah);
            }else{
                echo "Invalid mobile number format";
            }
            $destination = array("to" => $pecah[$i]);
            $message     = array("from" => $from,
                                 "destinations" => $destination,
                                 "text" => $text,
                                 "smsCount" => 20);
            $postData           = array("messages" => array($message));
            $postDataJson       = json_encode($postData);
            $ch                 = curl_init();
            $header             = array("Content-Type:application/json", "Accept:application/json");
            
            curl_setopt($ch, CURLOPT_URL, $postUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $responseBody = json_decode($response);
            curl_close($ch);
        }   

        if($detil){
            $data = ['success' => true, 'message' => 'Silahkan masukan kode ini untuk melanjutkan proses penarikan tunai.'];
            return response()->json($data);
        }else{
          $data = ['failed' => false, 'message' => 'Data Telepon tidak benar.'];
          return response()->json($data);
        }
    }  

    public function datafillNewNew (Request $request) {

        if (DetilInvestor::where('phone_investor', $request->no_hp)->first()) {
            return response()->json(['error'=> 'Nomer Telpon Sudah Pernah Terdaftar']);
        }
        if (DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first()) {
            return response()->json(['error'=> 'Data ini sudah terdaftar']);
        }

        $detil = new DetilInvestor;

        $detil->investor_id = Auth::guard('api')->user()->id;
        $detil->tipe_pengguna = null;
        $detil->nama_investor = $request->nama;
        $detil->no_ktp_investor = $request->no_ktp;
        $detil->no_npwp_investor = $request->no_npwp == '' ? null : $request->no_npwp;
        $detil->phone_investor = $request->no_hp;
        $detil->alamat_investor = $request->alamat;
        $detil->provinsi_investor = $request->provinsi;
        $detil->kota_investor = $request->kota;
        $detil->kode_pos_investor = $request->kode_pos;
        $detil->tempat_lahir_investor = $request->tempat_lahir;
        $detil->tgl_lahir_investor = $request->tgl_lahir.'-'.$request->bln_lahir.'-'.$request->thn_lahir;
        $detil->jenis_kelamin_investor = $request->jenis_kelamin;
        $detil->status_kawin_investor = null;
        $detil->status_rumah_investor = null;
        $detil->agama_investor = null;
        $detil->pekerjaan_investor = null;
        $detil->bidang_pekerjaan = null;
        $detil->online_investor = null;
        $detil->pendapatan_investor = null;
        $detil->asset_investor = null;
        $detil->pengalaman_investor = null;
        $detil->pendidikan_investor = null;
        $detil->bank_investor = $request->bank;
        $detil->rekening = $request->rekening; 
        $detil->nama_pemilik_rek = $request->nama_pemilik_rek;
        // $detil->pic_investor = $this->upload('pic_investor', $request, Auth::user()->id);
        // $detil->pic_ktp_investor = $this->upload('pic_ktp_investor', $request, Auth::user()->id);
        // $detil->pic_user_ktp_investor = $this->upload('pic_user_ktp_investor', $request, Auth::user()->id);

                
        if($request->status_upload1=='sukses'){
            $detil->pic_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_investor.' . $request->file('pic_investor')->getClientOriginalExtension();
        }else{
            $detil->pic_investor = null;
        }
        if($request->status_upload2=='sukses'){
            $detil->pic_ktp_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.' . $request->file('pic_ktp_investor')->getClientOriginalExtension();
        }else{
            $detil->pic_ktp_investor = null;
        }
        if($request->status_upload3=='sukses'){
            $detil->pic_user_ktp_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $request->file('pic_user_ktp_investor')->getClientOriginalExtension();
        }else{
            $detil->pic_user_ktp_investor = null;
        }

        
        
        
        // $detil->pic_investor = null;
        // $detil->pic_ktp_investor = null;
        // $detil->pic_user_ktp_investor = null;
        $detil->jenis_badan_hukum = null;
        $detil->nama_perwakilan = null;
        $detil->no_ktp_perwakilan = null;

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

    public function datafillNewNewNew (Request $request) {

        $investor_id=Auth::guard('api')->user()->id;

        if (DetilInvestor::where('phone_investor', $request->no_hp)->first()) {
            return response()->json(['error'=> 'Nomer Telpon Sudah Pernah Terdaftar']);
        }
        if (DetilInvestor::where('investor_id', $investor_id)->first()) {
            return response()->json(['error'=> 'Data ini sudah terdaftar']);
        }

        $detil = new DetilInvestor;

        $detil->investor_id = $investor_id;
        $detil->tipe_pengguna = null;
        $detil->nama_investor = $request->nama;
        $detil->no_ktp_investor = $request->no_ktp;
        $detil->no_npwp_investor = $request->no_npwp == '' ? null : $request->no_npwp;
        $detil->phone_investor = $request->no_hp;
        $detil->alamat_investor = $request->alamat;
        $detil->provinsi_investor = $request->provinsi;
        $detil->kota_investor = $request->kota;
        $detil->kode_pos_investor = $request->kode_pos;
        $detil->tempat_lahir_investor = $request->tempat_lahir;
        $detil->tgl_lahir_investor = $request->tgl_lahir.'-'.$request->bln_lahir.'-'.$request->thn_lahir;
        $detil->jenis_kelamin_investor = $request->jenis_kelamin;
        $detil->status_kawin_investor = null;
        $detil->status_rumah_investor = null;
        $detil->agama_investor = null;
        $detil->pekerjaan_investor = null;
        $detil->bidang_pekerjaan = null;
        $detil->online_investor = null;
        $detil->pendapatan_investor = null;
        $detil->asset_investor = null;
        $detil->pengalaman_investor = null;
        $detil->pendidikan_investor = null;
        $detil->bank_investor = $request->bank;
        $detil->rekening = $request->rekening; 
        $detil->nama_pemilik_rek = $request->nama_pemilik_rek;
                
        if($request->status_upload1=='sukses'){
            $detil->pic_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_investor.' . $request->file('pic_investor')->getClientOriginalExtension();
        }else{
            $detil->pic_investor = null;
        }
        if($request->status_upload2=='sukses'){
            $detil->pic_ktp_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.' . $request->file('pic_ktp_investor')->getClientOriginalExtension();
        }else{
            $detil->pic_ktp_investor = null;
        }
        if($request->status_upload3=='sukses'){
            $detil->pic_user_ktp_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $request->file('pic_user_ktp_investor')->getClientOriginalExtension();
        }else{
            $detil->pic_user_ktp_investor = null;
        }
        $detil->jenis_badan_hukum = null;
        $detil->nama_perwakilan = null;
        $detil->no_ktp_perwakilan = null;

        $detil->save();

        if (Auth::guard('api')->user()->status === 'notfilled') {
            $user = Investor::where('id', $investor_id)->first();
            $user->status = 'active';
            $user->save();
            }
        
        $data_investor = Investor::where('id', $investor_id)->first(); 
        $hasil = $this->generateVA($data_investor->username);
        if(!$hasil){
            return response()->json(['error_va'=> 'Pembuatan VA gagal']);
        }
        else{
            dispatch(new InvestorVerif($data_investor, 1));
            #pesan verifikasi
            $kirimverifikasi = $this->verificationCode($investor_id);
            
            if($kirimverifikasi===5){
                return response()->json(['success'=> 'Data Berhasil diisi']);
            }else{
                return response()->json(['success'=> 'Data Berhasil diisi']);
            }
        }
    }

    public function datafillNewNewNewNew (Request $request) {

        $investor_id=Auth::guard('api')->user()->id;

        if (DetilInvestor::where('phone_investor', $request->no_hp)->first()) {
            return response()->json(['error'=> 'Nomer Telpon Sudah Pernah Terdaftar']);
        }
        if (DetilInvestor::where('investor_id', $investor_id)->first()) {
            return response()->json(['error'=> 'Data ini sudah terdaftar']);
        }

        $detil = new DetilInvestor;

        $detil->investor_id = $investor_id;
        $detil->tipe_pengguna = null;
        $detil->nama_investor = $request->nama;
        $detil->no_ktp_investor = $request->no_ktp;
        $detil->no_npwp_investor = $request->no_npwp == '' ? null : $request->no_npwp;
        $detil->phone_investor = $request->no_hp;
        $detil->alamat_investor = $request->alamat;
        $detil->provinsi_investor = $request->provinsi;
        $detil->kota_investor = $request->kota;
        $detil->kode_pos_investor = $request->kode_pos;
        $detil->tempat_lahir_investor = $request->tempat_lahir;
        $detil->tgl_lahir_investor = $request->tgl_lahir.'-'.$request->bln_lahir.'-'.$request->thn_lahir;
        $detil->jenis_kelamin_investor = $request->jenis_kelamin;
        $detil->status_kawin_investor = null;
        $detil->status_rumah_investor = null;
        $detil->agama_investor = null;
        $detil->pekerjaan_investor = null;
        $detil->bidang_pekerjaan = null;
        $detil->online_investor = null;
        $detil->pendapatan_investor = null;
        $detil->asset_investor = null;
        $detil->pengalaman_investor = null;
        $detil->pendidikan_investor = null;
        $detil->bank_investor = $request->bank;
        $detil->rekening = $request->rekening; 
        $detil->nama_pemilik_rek = $request->nama_pemilik_rek;
                
        if($request->status_upload1=='sukses'){
            $detil->pic_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_investor.' . $request->format_pic_investor;
        }else{
            $detil->pic_investor = null;
        }
        if($request->status_upload2=='sukses'){
            $detil->pic_ktp_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.' . $request->format_pic_ktp_investor;
        }else{
            $detil->pic_ktp_investor = null;
        }
        if($request->status_upload3=='sukses'){
            $detil->pic_user_ktp_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $request->format_pic_user_ktp_investor;
        }else{
            $detil->pic_user_ktp_investor = null;
        }
        $detil->jenis_badan_hukum = null;
        $detil->nama_perwakilan = null;
        $detil->no_ktp_perwakilan = null;

        $detil->save();

        if (Auth::guard('api')->user()->status === 'notfilled') {
            $user = Investor::where('id', $investor_id)->first();
            $user->status = 'active';
            $user->save();
            }
        
        $data_investor = Investor::where('id', $investor_id)->first(); 
        $hasil = $this->generateVA($data_investor->username);
        if(!$hasil){
            return response()->json(['error_va'=> 'Pembuatan VA gagal']);
        }
        else{
            dispatch(new InvestorVerif($data_investor, 1));
            #pesan verifikasi
            $kirimverifikasi = $this->verificationCode($investor_id);
            
            if($kirimverifikasi===5){
                return response()->json(['success'=> 'Data Berhasil diisi']);
            }else{
                return response()->json(['success'=> 'Data Berhasil diisi']);
            }
        }
    }

    public function datafillNewNewNewNewNew (Request $request) {

        $investor_id=Auth::guard('api')->user()->id;

        if (DetilInvestor::where('phone_investor', $request->no_hp)->first()) {
            return response()->json(['error'=> 'Nomer Telpon Sudah Pernah Terdaftar']);
        }
        if (DetilInvestor::where('investor_id', $investor_id)->first()) {
            return response()->json(['error'=> 'Data ini sudah terdaftar']);
        }

        DB::beginTransaction();
        try{
            $detil = new DetilInvestor;

            $detil->investor_id = $investor_id;
            $detil->tipe_pengguna = null;
            $detil->nama_investor = $request->nama;
            $detil->no_ktp_investor = $request->no_ktp;
            $detil->no_npwp_investor = $request->no_npwp == '' ? null : $request->no_npwp;
            $detil->phone_investor = $request->no_hp;
            $detil->alamat_investor = $request->alamat;
            $detil->provinsi_investor = $request->provinsi;
            $detil->kota_investor = $request->kota;
            $detil->kode_pos_investor = $request->kode_pos;
            $detil->tempat_lahir_investor = $request->tempat_lahir;
            $detil->tgl_lahir_investor = $request->tgl_lahir.'-'.$request->bln_lahir.'-'.$request->thn_lahir;
            $detil->jenis_kelamin_investor = $request->jenis_kelamin;
            $detil->status_kawin_investor = null;
            $detil->status_rumah_investor = null;
            $detil->agama_investor = null;
            $detil->pekerjaan_investor = null;
            $detil->bidang_pekerjaan = null;
            $detil->online_investor = null;
            $detil->pendapatan_investor = null;
            $detil->asset_investor = null;
            $detil->pengalaman_investor = null;
            $detil->pendidikan_investor = null;
            $detil->bank_investor = $request->bank;
            $detil->rekening = $request->rekening; 
            $detil->nama_pemilik_rek = $request->nama_pemilik_rek;
                    
            if($request->status_upload1=='sukses'){
                $detil->pic_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_investor.' . $request->format_pic_investor;
            }else{
                $detil->pic_investor = null;
            }
            if($request->status_upload2=='sukses'){
                $detil->pic_ktp_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.' . $request->format_pic_ktp_investor;
            }else{
                $detil->pic_ktp_investor = null;
            }
            if($request->status_upload3=='sukses'){
                $detil->pic_user_ktp_investor = 'user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $request->format_pic_user_ktp_investor;
            }else{
                $detil->pic_user_ktp_investor = null;
            }
            $detil->jenis_badan_hukum = null;
            $detil->nama_perwakilan = null;
            $detil->no_ktp_perwakilan = null;

            $detil->save();

            if (Auth::guard('api')->user()->status === 'notfilled') {
                $user = Investor::where('id', $investor_id)->first();
                $user->status = 'active';
                $user->save();
            }

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['error_simpan'=> 'Data gagal disimpan silahkan coba beberapa saat lagi']);
        }

        $data_investor = Investor::where('id', $investor_id)->first(); 
        $hasil = $this->generateVA($data_investor->username);
        if(!$hasil){
            return response()->json(['error_va'=> 'Pembuatan VA gagal']);
            DB::rollback();
        }
        else{
            // dispatch(new InvestorVerif($data_investor, 1));
            #pesan verifikasi
            // $kirimverifikasi = $this->verificationCode($investor_id);
            DB::commit();
            return response()->json(['success'=> 'Data Berhasil diisi']);
            // if($kirimverifikasi===5){
            //     return response()->json(['success'=> 'Data Berhasil diisi']);
            // }else{
            //     return response()->json(['success'=> 'Data Berhasil diisi']);
            // }
        }   
    }

    public function datafillbaru (Request $request) {

        $investor_id=Auth::guard('api')->user()->id;

        if (DetilInvestor::where('phone_investor', $request->no_hp)->first()) {
            return response()->json(['error'=> 'Nomer Telpon Sudah Pernah Terdaftar']);
        }
        if (DetilInvestor::where('investor_id', $investor_id)->first()) {
            return response()->json(['error'=> 'Data ini sudah terdaftar']);
        }

        DB::beginTransaction();
        try{
            $detil = new DetilInvestor;

            $detil->investor_id = $investor_id;
            $detil->tipe_pengguna = null;
            $detil->nama_investor = $request->nama;
            $detil->no_ktp_investor = $request->no_ktp;
            $detil->no_npwp_investor = $request->no_npwp == '' ? null : $request->no_npwp;
            $detil->phone_investor = $request->no_hp;
            $detil->alamat_investor = $request->alamat;
            $detil->provinsi_investor = $request->provinsi;
            $detil->kota_investor = $request->kota;
            $detil->kode_pos_investor = $request->kode_pos;
            $detil->tempat_lahir_investor = $request->tempat_lahir;
            $detil->tgl_lahir_investor = $request->tgl_lahir.'-'.$request->bln_lahir.'-'.$request->thn_lahir;
            $detil->jenis_kelamin_investor = $request->jenis_kelamin;
            $detil->status_kawin_investor = $request->jenis_kawin;
            $detil->status_rumah_investor = null;
            $detil->agama_investor = null;
            $detil->pekerjaan_investor = $request->pekerjaan;
            $detil->bidang_pekerjaan = null;
            $detil->online_investor = null;
            $detil->pendapatan_investor = $request->pendapatan;
            $detil->asset_investor = null;
            $detil->pengalaman_investor = null;
            $detil->pendidikan_investor = $request->pendidikan;
            $detil->bank_investor = $request->bank;
            $detil->rekening = $request->rekening; 
            $detil->nama_pemilik_rek = $request->nama_pemilik_rek;
            $detil->kecamatan = $request->kecamatan;
            $detil->kelurahan = $request->kelurahan;
            $detil->nama_ibu_kandung = $request->nama_ibu_kandung;

                    
            if($request->status_upload1=='sukses'){
                $detil->pic_investor = 'user/'. $investor_id.'/'.Carbon::now()->toDateString() . 'pic_investor.' . $request->format_pic_investor;
            }else{
                $detil->pic_investor = null;
            }
            if($request->status_upload2=='sukses'){
                $detil->pic_ktp_investor = 'user/'. $investor_id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.' . $request->format_pic_ktp_investor;
            }else{
                $detil->pic_ktp_investor = null;
            }
            if($request->status_upload3=='sukses'){
                $detil->pic_user_ktp_investor = 'user/'. $investor_id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $request->format_pic_user_ktp_investor;
            }else{
                $detil->pic_user_ktp_investor = null;
            }
            $detil->jenis_badan_hukum = null;
            $detil->nama_perwakilan = null;
            $detil->no_ktp_perwakilan = null;

            $detil->save();
            
            $investor_location = new InvestorLocation;
            $investor_location->investor_id = $investor_id;
            $investor_location->longitude = $request->longitude;
            $investor_location->latitude = $request->latitude;
            $investor_location->altitude = $request->altitude;
            $investor_location->save();   


            if (Auth::guard('api')->user()->status === 'notfilled') {
                $user = Investor::where('id', $investor_id)->first();
                $user->status = 'active';
                $user->save();
            }

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['error_simpan'=> 'Data gagal disimpan silahkan coba beberapa saat lagi']);
        }

        $data_investor = Investor::where('id', $investor_id)->first(); 
        $hasil = $this->generateVA($data_investor->username);
        if(!$hasil){
            return response()->json(['error_va'=> 'Pembuatan VA gagal']);
            DB::rollback();
        }
        else{
            // dispatch(new InvestorVerif($data_investor, 1));
            #pesan verifikasi
            // $kirimverifikasi = $this->verificationCode($investor_id);
            DB::commit();
            return response()->json(['success'=> 'Data Berhasil diisi']);
            // if($kirimverifikasi===5){
            //     return response()->json(['success'=> 'Data Berhasil diisi']);
            // }else{
            //     return response()->json(['success'=> 'Data Berhasil diisi']);
            // }
        }   
    }

    public function datafillbaru_VA_konv (Request $request) {

        $investor_id=Auth::guard('api')->user()->id;

        if (DetilInvestor::where('phone_investor', $request->no_hp)->first()) {
            return response()->json(['error'=> 'Nomer Telpon Sudah Pernah Terdaftar']);
        }
        if (DetilInvestor::where('investor_id', $investor_id)->first()) {
            return response()->json(['error'=> 'Data ini sudah terdaftar']);
        }

        DB::beginTransaction();
        try{
            $detil = new DetilInvestor;

            $detil->investor_id = $investor_id;
            $detil->tipe_pengguna = null;
            $detil->nama_investor = $request->nama;
            $detil->no_ktp_investor = $request->no_ktp;
            $detil->no_npwp_investor = $request->no_npwp == '' ? null : $request->no_npwp;
            $detil->phone_investor = $request->no_hp;
            $detil->alamat_investor = $request->alamat;
            $detil->provinsi_investor = $request->provinsi;
            $detil->kota_investor = $request->kota;
            $detil->kode_pos_investor = $request->kode_pos;
            $detil->tempat_lahir_investor = $request->tempat_lahir;
            $detil->tgl_lahir_investor = $request->tgl_lahir.'-'.$request->bln_lahir.'-'.$request->thn_lahir;
            $detil->jenis_kelamin_investor = $request->jenis_kelamin;
            $detil->status_kawin_investor = $request->jenis_kawin;
            $detil->status_rumah_investor = null;
            $detil->agama_investor = null;
            $detil->pekerjaan_investor = $request->pekerjaan;
            $detil->bidang_pekerjaan = null;
            $detil->online_investor = null;
            $detil->pendapatan_investor = $request->pendapatan;
            $detil->asset_investor = null;
            $detil->pengalaman_investor = null;
            $detil->pendidikan_investor = $request->pendidikan;
            $detil->bank_investor = $request->bank;
            $detil->rekening = $request->rekening; 
            $detil->nama_pemilik_rek = $request->nama_pemilik_rek;
            $detil->kecamatan = $request->kecamatan;
            $detil->kelurahan = $request->kelurahan;
            $detil->nama_ibu_kandung = $request->nama_ibu_kandung;

                    
            if($request->status_upload1=='sukses'){
                $detil->pic_investor = 'user/'. $investor_id.'/'.Carbon::now()->toDateString() . 'pic_investor.' . $request->format_pic_investor;
            }else{
                $detil->pic_investor = null;
            }
            if($request->status_upload2=='sukses'){
                $detil->pic_ktp_investor = 'user/'. $investor_id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.' . $request->format_pic_ktp_investor;
            }else{
                $detil->pic_ktp_investor = null;
            }
            if($request->status_upload3=='sukses'){
                $detil->pic_user_ktp_investor = 'user/'. $investor_id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $request->format_pic_user_ktp_investor;
            }else{
                $detil->pic_user_ktp_investor = null;
            }
            $detil->jenis_badan_hukum = null;
            $detil->nama_perwakilan = null;
            $detil->no_ktp_perwakilan = null;

            $detil->save();
            
            $investor_location = new InvestorLocation;
            $investor_location->investor_id = $investor_id;
            $investor_location->longitude = $request->longitude;
            $investor_location->latitude = $request->latitude;
            $investor_location->altitude = $request->altitude;
            $investor_location->save();   


            if (Auth::guard('api')->user()->status === 'notfilled') {
                $user = Investor::where('id', $investor_id)->first();
                $user->status = 'active';
                $user->save();
            }

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['error_simpan'=> 'Data gagal disimpan silahkan coba beberapa saat lagi']);
        }

        $data_investor = Investor::where('id', $investor_id)->first(); 
        $username = $data_investor->username;
        $VA = new RekeningController;
        $hasil = $VA->generateVABNI_Investor_test($username);
        
        if(!$hasil){
            return response()->json(['error_va'=> 'Pembuatan VA gagal']);
            DB::rollback();
        }
        else{
            // dispatch(new InvestorVerif($data_investor, 1));
            #pesan verifikasi
            // $kirimverifikasi = $this->verificationCode($investor_id);
            DB::commit();
            return response()->json(['success'=> 'Data Berhasil diisi']);
            // if($kirimverifikasi===5){
            //     return response()->json(['success'=> 'Data Berhasil diisi']);
            // }else{
            //     return response()->json(['success'=> 'Data Berhasil diisi']);
            // }
        }   
    }

    //Generate VA for user
    public function generateVA($username){
        $date = \Carbon\Carbon::now()->addYear(4);
        $user = Investor::where('username', $username)->first();
        $data = [
            'type' => 'createbilling',
            'client_id' => self::CLIENT_ID,
            'trx_id' => $user->id,
            'trx_amount' => '0',
            'customer_name' => $user->detilInvestor->nama_investor,
            'customer_email' => $user->email,
            'virtual_account' => '8'.self::CLIENT_ID.$user->detilInvestor->getVa(),
            'datetime_expired' => $date->format('Y-m-d').'T'.$date->format('H:i:sP'),
            'billing_type' => 'o',
        ];

    
        $encrypted = BniEnc::encrypt($data,self::CLIENT_ID,self::KEY);

        $client = new Client(); //GuzzleHttp\Client
        $result = $client->post(self::API_URL, [
            'json' => [
                'client_id' => self::CLIENT_ID,
                'data' => $encrypted,
            ]
        ]);

        $result = json_decode($result->getBody()->getContents());
        if($result->status !== '000'){
            return false;
        }
        else{
            $decrypted = BniEnc::decrypt($result->data,self::CLIENT_ID,self::KEY);
            //return json_encode($decrypted);
            $user->RekeningInvestor()->create([
                'investor_id' => $user->id,
                'total_dana' => 0,
                'va_number' => $decrypted['virtual_account'],
                'unallocated' => 0,
            ]);
            
            return true;
            // return view('pages.user.add_funds')->with('message','VA Generate Success!');
         }
    }

    public function verificationCode($investor_id){
        
        $rekening = RekeningInvestor::join('detil_investor', 'detil_investor.investor_id', '=', 'rekening_investor.investor_id')->join('investor', 'investor.id','=','rekening_investor.investor_id')
                    ->select('rekening_investor.va_number', 'detil_investor.nama_investor', 'detil_investor.phone_investor', 'investor.username')
                    ->where('rekening_investor.investor_id', $investor_id)->first();
        $to =  $rekening->phone_investor;
        //$to = "085966528825";
        $text =  'Terima kasih, akun '.$rekening->username.' telah berhasil diverifikasi dengan nomor Virtual Account: '.$rekening->va_number.' atas nama '.$rekening->nama_investor.' . Silahkan lakukan Top Up dana Anda ke nomor virtual account tersebut.';
        // die();
        $pecah              = explode(",",$to);
        $jumlah             = count($pecah);
        $from               = "DANASYARIAH"; //Sender ID or SMS Masking Name, if leave blank, it will use default from telco
        $username           = "danasyariahpremium"; //your smsviro username
        $password           = "Dsi701@2019"; //your smsviro password
        $postUrl            = "http://107.20.199.106/restapi/sms/1/text/advanced"; # DO NOT CHANGE THIS
        
        for($i=0; $i<$jumlah; $i++){
            if(substr($pecah[$i],0,2) == "62" || substr($pecah[$i],0,3) == "+62"){
                $pecah = $pecah;
            }elseif(substr($pecah[$i],0,1) == "0"){
                $pecah[$i][0] = "X";
                $pecah = str_replace("X", "62", $pecah);
            }else{
                echo "Invalid mobile number format";
            }
            $destination = array("to" => $pecah[$i]);
            $message     = array("from" => $from,
                                 "destinations" => $destination,
                                 "text" => $text,
                                 "smsCount" => 20);
            $postData           = array("messages" => array($message));
            $postDataJson       = json_encode($postData);
            $ch                 = curl_init();
            $header             = array("Content-Type:application/json", "Accept:application/json");
            
            curl_setopt($ch, CURLOPT_URL, $postUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $responseBody = json_decode($response, true);
            curl_close($ch);
        }   

       $group_id = $responseBody['messages'][0]['status']['groupId'];
       
        if($response){
            return $group_id;
        }else{
            return $group_id;
        }
    }

    public function checkVersion(){
        $users = DB::table('mobile_version')->orderBy('id', 'desc')->limit(1)->get();
        
        return ['id'=>$users[0]->id,
                'version'=>$users[0]->version,
                'version_code'=>$users[0]->version_code,
                'created_date'=>$users[0]->created_at,
                'location'=>'/storage/'.$users[0]->location
            ];
    }

    public function checkPhoneNumber(Request $request){
        
        if(empty($request->no_hp)){
            return response()->json(['success'=> 'Nomer Telpon Belum Pernah Terdaftar']);
        }
        else
            if (DetilInvestor::where('phone_investor', $request->no_hp)->first()) {
                return response()->json(['error'=> 'Nomer Telpon Sudah Pernah Terdaftar']);
            }
            else
            return response()->json(['success'=> 'Nomer Telpon Belum Pernah Terdaftar']);
    }

    public function getTermCondition(Request $request){
        $detils = TermCondition::orderBy('id', 'desc')->first();

        return [
            'id'=>$detils->id,
            'title'=>$detils->title,
            'writer'=>$detils->writer,
            'deskripsi'=>$detils->deskripsi,
        ];
    }
    
}

