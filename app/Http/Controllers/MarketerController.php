<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marketer;
use App\DetilMarketer;
use App\Investor;
use App\MutasiMarketer;
use App\MasterBank;
use Auth;
use App\AuditTrail;

class MarketerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin')
        ->only(['admin_manage', 'admin_mutasi', 'admin_create_post', 'admin_delete_post', 'admin_changepass_post', 'admin_mutasi_create']);
        
        $this->middleware('auth:marketer')
        ->only(['dashboard', 'mutasi', 'datainvestor']);
    }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    //marketer side below
    public function dashboard(){
        $jumlah_investor = Investor::where('ref_number', Auth::user()->username)->count();
        $total_dana = MutasiMarketer::where('marketer_id', Auth::user()->id)->sum('nominal');

        return view('pages.marketer.dashboard')->with(compact('jumlah_investor', 'total_dana'));
    }

    public function mutasi(){
        $mutasi = MutasiMarketer::where('marketer_id', Auth::user()->id)->get();

        return view('pages.marketer.mutasi')->with('mutasi', $mutasi);
    }

    public function datainvestor(){
        $data_investor = Investor::where('ref_number', Auth::user()->username)->get();

        return view('pages.marketer.datainvestor')->with('data_investor', $data_investor);
    }


     //admin side below

     public function admin_manage(){
        $marketers = Marketer::all();
        $master_bank = MasterBank::all();

        return view('pages.admin.marketer_manage')->with('marketers', $marketers)->with('master_bank', $master_bank);
     }
     public function admin_mutasi(){
        return view('pages.admin.marketer_mutasi');
     }

     public function get_marketer_datatables()
     {
        $marketer = Marketer::leftJoin('investor','investor.ref_number','=','marketer.ref_code')
                    ->leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                    ->leftJoin('detil_marketer','detil_marketer.marketer_id','=','marketer.id')
                    ->leftJoin('mutasi_marketer','mutasi_marketer.marketer_id','=','marketer.id')
                    ->leftJoin('m_bank','m_bank.kode_bank','=','detil_investor.bank_investor')
                    ->groupBy('marketer.id')
                    ->get([
                        'marketer.id',
                        'marketer.email',
                        'marketer.ref_code',
                        \DB::raw('count(investor.id) as jumlah_investor'),
                        \DB::raw('sum(mutasi_marketer.nominal) as total_nominal'),
                        'investor.email as email_investor',
                        'detil_investor.nama_investor',
                        'detil_marketer.nama_lengkap',
                        'detil_investor.rekening',
                        'm_bank.nama_bank'
                    ]);
        $response = ['data' => $marketer];

        return response()->json($response);
     }

     public function get_mutasi_marketer($id)
     {
        $mutasi_marketer = MutasiMarketer::where('marketer_id',$id)->get();

        $response = ['data' => $mutasi_marketer];

        return response()->json($response);
     }

     public function get_investor_marketer($id)
     {
        $investor_marketer = Marketer::leftJoin('investor','investor.ref_number','=','marketer.ref_code')
                    ->leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                    ->where('marketer.id',$id)
                    ->get([
                        'detil_investor.nama_investor',
                        'investor.email',
                        \DB::raw('(select sum(total_dana) from pendanaan_aktif where pendanaan_aktif.investor_id = investor.id) as total_invest')
                    ]);

        $response = ['data' => $investor_marketer];

        return response()->json($response);
     }

     public function admin_mutasi_create(Request $request){
        $mutasi_marketer = new MutasiMarketer;

        $mutasi_marketer->marketer_id = $request->id;
        $mutasi_marketer->nominal = $request->nominal;
        $mutasi_marketer->perihal = $request->perihal;
        $mutasi_marketer->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Wiraniaga";
        $audit->description = "Konfirmasi Pembayaran Wiraniaga";
        $audit->ip_address =  \Request::ip();
        $audit->save();


        return redirect()->route('admin.marketer.mutasi')->with('konfirmasi', 'Berhasil konfirmasi pembayaran Wiraniaga');
     }

     public function admin_create_post(Request $request){
        if(Marketer::where('username', $request->email)->exists() || Marketer::where('username', $request->username)->exists()){
            return redirect()->route('admin.marketer.manage')->with('exists', 'Username or Email exists!');
        }

        $marketer = new Marketer;

        $marketer->username = $request->username;
        $marketer->email = $request->email;
        $marketer->password = bcrypt($request->password);
        $marketer->ref_code = $request->username;

        $marketer->save();

        $detil_marketer = new DetilMarketer;

        $detil_marketer->marketer_id = $marketer->id;
        $detil_marketer->nama_lengkap =$request->nama_lengkap;
        $detil_marketer->alamat=$request->alamat;
        $detil_marketer->phone=$request->phone;
        $detil_marketer->no_rek=$request->no_rek;
        $detil_marketer->bank=$request->bank;
        
        $detil_marketer->save();

         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Wiraniaga";
        $audit->description = "Tambah data Wiraniaga";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->route('admin.marketer.manage')->with('createdone', 'Create Marketer successfull');

     }

     public function admin_update_post(Request $request){
         $marketer = Marketer::where('id', $request->id)->first();

         $detil_marketer = $marketer->detilMarketer;

         $detil_marketer->nama_lengkap =$request->nama_lengkap;
         $detil_marketer->alamat=$request->alamat;
         $detil_marketer->phone=$request->phone;
         $detil_marketer->no_rek=$request->no_rek;
         $detil_marketer->bank=$request->bank;

         $detil_marketer->save();

         $audit = new AuditTrail;
         $username = Auth::guard('admin')->user()->firstname;
         $audit->fullname = $username;
         $audit->menu = "Kelola Wiraniaga";
         $audit->description = "Ubah data Wiraniaga";
         $audit->ip_address =  \Request::ip();
         $audit->save();

         return redirect()->route('admin.marketer.manage')->with('updatedone', 'Update Marketer successfull');
     }

     public function admin_delete_post(Request $request){
        Marketer::where('id', $request->id)->delete();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Wiraniaga";
        $audit->description = "Hapus data Wiraniaga";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->route('admin.marketer.manage')->with('deletedone', 'Marketer was deleted');;
     }

     public function admin_changepass_post(Request $request){
        $newhash = bcrypt($request->password);

        Marketer::where('id', $request->id)
        ->update(['password'=>$newhash]);

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Wiraniaga";
        $audit->description = "Ubah password Wiraniaga";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->route('admin.marketer.manage')->with('changepassdone', 'Change password successfull');;
     }

}
