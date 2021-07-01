<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admins;
use App\Investor;
use App\PendanaanAktif;
use App\Proyek;
use App\Marketer;
use App\MasterProvinsi;
use App\MasterAgama;
use App\MasterAsset;
use App\MasterBadanHukum;
use App\MasterBank;
use App\MasterBidangPekerjaan;
use App\MasterJenisKelamin;
use App\MasterJenisPengguna;
use App\MasterKawin;
use App\MasterKepemilikanRumah;
use App\MasterNegara;
use App\MasterOnline;
use App\MasterPekerjaan;
use App\MasterPendapatan;
use App\MasterPendidikan;
use App\MasterPengalamanKerja;
use App\ManageCarousel;
use App\ECollBni;
use App\ManagePenghargaan;
use App\ManageKhazanah;
use App\TermCondition;
use App\Jobs\BroadcastEmail;
use App\News;
use App\BorrowerTipePendanaan;
use App\BorrowerDetails;
use App\BorrowerAhliWaris;
use App\BorrowerRekening;
use App\BorrowerPengurus;
use App\LogPengembalianDana;
use Carbon\Carbon;
use Storage;
use League\Csv\Reader;
use App\ManageRole;
use App\AdminMenuItem;
use App\RBAC;
use DB;
use App\Http\Middleware\NotifikasiProyek;
use Auth;
use App\Http\Middleware\StatusProyek;
use App\MobileVersion;
use App\TeksNotifikasi;
use App\ThresholdKontrak;
use App\BorrowerPendanaan;
use App\Http\Controllers\KirimEmailController;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\AuditTrail;
use App\TestimoniPendana;
use App\DokumenBorrower;
use App\RekeningInvestor;
use App\Http\Controllers\DMSController;
use App\Http\Controllers\RDLController;
use App\LogBankRDLTransaction;
use League\Csv\Statement;
use League\Csv\Writer;

class AdminController extends Controller
{
    private $data_json;
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        // $this->middleware(NotifikasiProyek::class);
        $this->middleware(StatusProyek::class);
    }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function dashboard(){
        $jumlah_investor = Investor::all()->count();
        $total_dana = PendanaanAktif::where('status',1)->sum('total_dana');
        $jumlah_marketer = Marketer::all()->count();
        $jumlah_proyek = Proyek::all()->count();
        $initial = Proyek::all()->sum('terkumpul');
        $terkumpul = $initial + $total_dana;
        
        return view('pages.admin.admin_dashboard')->with(compact('jumlah_investor', 'total_dana', 'jumlah_marketer', 'jumlah_proyek','terkumpul'));
    }
    public function manageAdmin(){
        $admins = Admins::all();
        $role = ManageRole::all();
        $menuItem = AdminMenuItem::whereNotIn('id',[\DB::raw('select parent from admin_menu_items where parent != 0')])
                                ->get();
        $cekUser = Admins::leftJoin('roles','roles.id','=','admins.role')->where('admins.id',\Auth::id())->first(['roles.name','admins.id']);

        return view('pages.admin.admin_manage')->with(['admins' => $admins, 'role' => $role, 'menuItem' => $menuItem, 'cekUser' => $cekUser]);
    }

    public function add_investor(){
        $master_provinsi = MasterProvinsi::distinct('kode_provinsi','nama_provinsi')->get(['kode_provinsi','nama_provinsi']);
        $master_agama = MasterAgama::all();
        $master_asset = MasterAsset::all();
        $master_badan_hukum = MasterBadanHukum::all();
        $master_bank = MasterBank::all();
        $master_bidang_pekerjaan = MasterBidangPekerjaan::all();
        $master_jenis_kelamin = MasterJenisKelamin::all();
        $master_jenis_pengguna = MasterJenisPengguna::all();
        $master_kawin = MasterKawin::all();
        $master_kepemilikan_rumah = MasterKepemilikanRumah::all();
        $master_negara = MasterNegara::all();
        $master_online = MasterOnline::all();
        $master_pekerjaan = MasterPekerjaan::all();
        $master_pendapatan = MasterPendapatan::all();
        $master_pendidikan = MasterPendidikan::all();
        $master_pengalaman_kerja = MasterPengalamanKerja::all();

        return view('pages.admin.add_investor',[
                        'master_provinsi' => $master_provinsi,
                        'master_agama' => $master_agama,
                        'master_asset' => $master_asset,
                        'master_badan_hukum' => $master_badan_hukum,
                        'master_bank' => $master_bank,
                        'master_bidang_pekerjaan' => $master_bidang_pekerjaan,
                        'master_jenis_kelamin' => $master_jenis_kelamin,
                        'master_jenis_pengguna' => $master_jenis_pengguna,
                        'master_kawin' => $master_kawin,
                        'master_kepemilikan_rumah' => $master_kepemilikan_rumah,
                        'master_negara' => $master_negara,
                        'master_online' => $master_online,
                        'master_pekerjaan' => $master_pekerjaan,
                        'master_pendapatan' => $master_pendapatan,
                        'master_pendidikan' => $master_pendidikan,
                        'master_pengalaman_kerja' => $master_pengalaman_kerja,
                        'master_provinsi' => $master_provinsi,
                    ]);
    }

    public function get_kota($id_provinsi)
    {
        $kota = MasterProvinsi::where('kode_provinsi',$id_provinsi)
                                ->orderBy('kode_kota','asc')
                                ->get(['kode_kota','nama_kota']);

        return response()->json(['kota' => $kota]);
    }

    public function deleteAdmin($id){
        $deleteUser = Admins::where('id', $id)->delete();

        if ($deleteUser)
        {
            $response = ['status' => 'Sukses'];
        }

         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Pengguna";
        $audit->description = "Hapus pengguna";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return response()->json($response);
    }

    public function createAdmin(Request $request){
        if(Admins::where('email', $request->email)->exists()){
            return redirect()->route('admin.manage')->with('exists', 'User exists!');
        }

        $admin = new Admins;

        $admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;
        $admin->email = $request->email;
        $admin->address = $request->address;
        $admin->password = bcrypt('$request->password');
        $admin->role = $request->role;

        $admin->save();

         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Pengguna";
        $audit->description = "Tambah Pengguna";
        $audit->ip_address =  \Request::ip();
        $audit->save();
		
        return redirect()->route('admin.manage')->with('createdone', 'Create User successfull');
    }

    public function changepassAdmin(Request $request){
        
        $newhash = bcrypt($request->password);

        Admins::where('id', $request->id_user)
                ->update(['password'=>$newhash]);

         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Pengguna";
        $audit->description = "Ubah password pengguna";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->route('admin.manage')->with('changepassdone', 'Change password successfull');       
    }

    public function showBroadcastForm() {
      $data = app('App\Http\Controllers\KirimEmailController')->ListGroup();
      return view('pages.admin.broadcast_email')->with('data',$data);
    }



    public function broadcastEmail(Request $request) {
        $data = [
          'title' => $request->judul_email,
          'content' => $request->deskripsi,
          'list_id' => $request->list_email,

        ];

        app('App\Http\Controllers\KirimEmailController')->BroadcastEmail($data);
         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Pesan";
        $audit->description = "Broadcast Email";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->route('admin.broadcast')->with('broadcastdone', 'Broadcast success');
    }

    public function CreateListGroup()
    {
      $data = app('App\Http\Controllers\KirimEmailController')->ListGroup();

      return view('pages.admin.broadcast_list',compact('data'));
    }
    public function listNew(Request $request)
    {
      $data = [
        'title' => $request->list_kirim,
      ];
      app('App\Http\Controllers\KirimEmailController')->CreateList($data);
      return redirect()->back()->with('broadcastdone','Sukses membuat group list');    ;  
    }
    public function postList(Request $request)
    {
      $data = [
        'id' => $request->id_list,
        'list_id' => $request->nominal_id,
      ];
      app('App\Http\Controllers\KirimEmailController')->CreateSubscriber($data);
      return redirect()->back()->with('broadcastdone','Sukses Import Email');    ;  
    }

    public function showSingleMail() {
        // $user = Investor::all();

        return view('pages.admin.single_email')/*->with('user', $user)*/;
    }

    public function get_email_datatables(Request $request)
    {
        $email = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                            ->where('detil_investor.nama_investor','like','%'.$request->name_email.'%')
                            ->orderBy('investor.id','desc')
                            ->get([
                                'investor.id',
                                'investor.username',
                                'investor.email',
                                'investor.status',
                                'detil_investor.nama_investor'
                            ]);
        
        $response = ['data_email' => $email];

        return response()->json($response);
    }

    public function sendSingleMail(Request $request) {
        $user = Investor::whereIn('id', $request->checked)->get();
        $data = [
            'judul_email' => $request->judul_email,
            'deskripsi' => $request->deskripsi
        ];
        foreach ($user as $users){
            dispatch(new BroadcastEmail($data,$users));
        }
        return redirect()->route('admin.singleMail')->with('singlemail', 'Send Email success');
    }

    public function showNews() {
        return view('pages.admin.news');
    }

    public function postNews(Request $request) {
        $news = new News;
        $news->title = $request->judul;
        $news->writer = $request->writer;
        $news->deskripsi = $request->deskripsi;
        $news->save();
        $news->image = $this->upload('news'.$news->id, $request->image, 'admin/news');
        $news->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Berita";
        $audit->description = "Tambah berita baru";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('success', 'Create News success');
    }

    private function upload($column, $request, $store_path)
    {
            $file = $request;
            $filename = Carbon::now()->toDateString() . $column . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs($store_path, $filename, 'public');
//            save gambar yang di upload di public storage
            return $path;
    }

    public function listNews() {
        $news = News::all();
        return view('pages.admin.listNews')->with('news', $news);
    }

    public function deleteNews(Request $request) {
        $news = News::find($request->id);
        Storage::disk('public')->delete($news->image);
        $news->delete();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Berita";
        $audit->description = "Hapus berita";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('delete', 'News Deleted');
    }

    public function updateNews(Request $request) {
        $news = News::find($request->id);
        $news->title = $request->judul;
        $news->writer = $request->writer;
        $news->deskripsi = $request->deskripsi;
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($news->image);
            $news->image = $this->upload('news'.$news->id, $request->image, 'admin/news');
        }
        $news->save();

         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Berita";
        $audit->description = "Ubah berita";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('delete', 'News Edited');
    }

    private function upload_carousel($column, Request $request)
    {
        if ($request->hasFile($column)) {
            $file = $request->file($column);
            $filename = Carbon::now()->toDateString() . $request->gambar_carousel->getClientOriginalName();
            $store_path = 'carousel';
            $path = $file->storeAs($store_path, $filename, 'public');
    //            save gambar yang di upload di public storage
            return $path;
        }
        else { 
            return null;
        }
    }

    public function manageCarousel(){
        
        return view('pages.admin.manage_carousel');
    }

    public function admin_add_carousel(Request $request) {

        $carousel = new ManageCarousel;
        
        $carousel->gambar = $this->upload_carousel('gambar_carousel', $request);
        
        $carousel->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Karosel";
        $audit->description = "Tambah gambar carausel";
        $audit->ip_address =  \Request::ip();
        $audit->save();
        
        return redirect()->back()->with('success', 'Add Gambar Success');
    }

    public function admin_update_carousel(Request $request){
        
        $carousel = ManageCarousel::where('id_carousel',$request->gambar_id)->first();

        if ($request->hasFile('gambar_carousel')) {
            Storage::disk('public')->delete($carousel->gambar);
            $carousel->gambar = $this->upload_carousel('gambar_carousel', $request);

            $carousel->save();
        }

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Karosel";
        $audit->description = "Ubah gambar Karosel";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('updated', "Update Gambar Success");

    }

    public function admin_delete_carousel($id){
        
        $carousel = ManageCarousel::where('id_carousel',$id)->first();

        Storage::disk('public')->delete($carousel->gambar);

        $carousel_delete = ManageCarousel::where('id_carousel',$id)->delete();

        if ($carousel_delete)
        {
            $response = ['status' => 'Sukses'];
        }

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "kelola Karosel";
        $audit->description = "Hapus gambar Karosel";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return response()->json($response);

    }

    public function get_carousel()
    {
        $gambar = ManageCarousel::all();
        
        $response = ['data' => $gambar];

        return response()->json($response);
    }

    public function e_coll_bni()
    {
        return view('pages.admin.e_coll_bni');
    }

    public function get_ecoll()
    {
        $ecoll = ECollBni::orderBy('id_ecoll','desc')->get();
        
        $response = ['data' => $ecoll];

        return response()->json($response);
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required'
        ]);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $file->storeAs(
                'public/import', $filename
            );
            
            // READ DATA DARI FILE CSV YANG DISIMPAN DIDALAM FOLDER
            // STORAGE > APP > PUBLIC > IMPORT > NAMAFILE.CSV
            $csv = Reader::createFromPath(storage_path('app/public/import/' . $filename), 'r');
            $csv->setDelimiter(';');
            //BARIS PERTAMA DI-SET SEBAGAI KEY DARI ARRAY YANG DIHASILKAN
            $csv->setHeaderOffset(0);
            
            //LOOPING DATA YANG TELAH DI-LOAD
            foreach ($csv as $row) {
                //SIMPAN KE DALAM TABLE USER
                ECollBni::create([
                    'nama' => preg_replace('/[=""]/','',$row['Customer Name']),
                    'no_va' => preg_replace('/[=""]/','',$row['VA Number']),
                    'tgl_payment' => preg_replace('/[=""]/','',$row['Payment Date']),
                ]);
            }
            return redirect()->back()->with(['success' => 'Upload success']);
        }  
        return redirect()->back()->with(['error' => 'Failed to upload file']);
    }

    public function converter()
    {
        return view('pages.admin.convertCSVToJSON', ['data_json' => $this->data_json]);
    }

    public function actConvert(Request $request)
    {
        $this->validate($request, [
            'file' => 'required'
        ]);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $file->storeAs(
                'public/import', $filename
            );
            
            // READ DATA DARI FILE CSV YANG DISIMPAN DIDALAM FOLDER
            // STORAGE > APP > PUBLIC > IMPORT > NAMAFILE.CSV
            $csv = Reader::createFromPath(storage_path('app/public/import/' . $filename), 'r');
            $csv->setDelimiter('|');
            
            //Nama File
            $dataFile = explode(".",$filename);
            $namaFile = $dataFile[0];

            //Inisiasi Array
            $csvData = array();

            $csvData[] = [];
            //LOOPING DATA YANG TELAH DI-LOAD
            foreach ($csv as $row) {
                //Convert To JSON
                if($namaFile == 'Pembayaran_Pinjaman')
                {
                    $csvData[] = 
                                [
                                    'id_penyelenggara' => (integer)$row[0],
                                    'id_pinjaman' => (integer)$row[1],
                                    'id_borrower' => (integer)$row[2],
                                    'id_lender' => (integer)$row[3],
                                    'id_transaksi' => (integer)$row[4],
                                    'id_pembayaran' => (integer)$row[5],
                                    'tgl_pembayaran' => $row[6],
                                    'tgl_pembayaran_borrower' => $row[7],
                                    'tgl_pembayaran_penyelenggara' => $row[8],
                                    'sisa_pinjaman_berjalan' => (integer)$row[9],
                                    'id_status_pinjaman' => (integer)$row[10],
                                    'tgl_pelunasan_borrower' => $row[11],
                                    'tgl_pelunasan_penyelenggara' => $row[12],
                                    'denda' => (integer)$row[13],
                                    'nilai_pembayaran' => (integer)$row[14],
                                    'id_jenis_pembayaran' => (integer)$row[15],
                                ];
                }
                elseif ($namaFile == 'Pengajuan_Pemberian_Pinjaman')
                {
                    $csvData[] = 
                                [
                                    'id_penyelenggara' => (integer)$row[0],
                                    'id_pinjaman' => (integer)$row[1],
                                    'id_borrower' => (integer)$row[2],
                                    'id_lender' => (integer)$row[3],
                                    'no_perjanjian_lender' => $row[4],
                                    'tgl_perjanjian_lender' => $row[5],
                                    'tgl_penawaran_pemberian_pinjaman' => $row[6],
                                    'nilai_penawaran_pinjaman' => (integer)$row[7],
                                    'nilai_penawaran_disetujui' => (integer)$row[8],
                                    'no_va_lender' => $row[9],
                                ];
                }
                elseif ($namaFile == 'Pengajuan_Pinjaman')
                {
                    $csvData[] = 
                                [
                                    'id_penyelenggara' => (integer)$row[0],
                                    'id_pinjaman' => (integer)$row[1],
                                    'id_borrower' => (integer)$row[2],
                                    'id_syariah' => (integer)$row[3],
                                    'id_status_pengajuan_pinjaman' => $row[4],
                                    'nama_pinjaman' => (integer)$row[5],
                                    'tgl_pengajuan_pinjaman' => (integer)$row[6],
                                    'nilai_permohonan_pinjaman' => (integer)$row[7],
                                    'jangka_waktu_pinjaman' => (integer)$row[8],
                                    'satuan_jangka_waktu_pinjaman' => $row[9],
                                    'penggunaan_pinjaman' => $row[10],
                                    'agunan' => (integer)$row[11],
                                    'jenis_agunan' => $row[12],
                                    'rasio_pinjaman_nilai_agunan' => (integer)$row[13],
                                    'permintaan_jaminan' => (integer)$row[14],
                                    'rasio_pinjaman_aset' => (integer)$row[15],
                                    'cicilan_bulan' => (integer)$row[16],
                                    'rating_pengajuan_pinjaman' => (integer)$row[17],
                                    'nilai_plafond' => (integer)$row[18],
                                    'nilai_pengajuan_pinjaman' => (integer)$row[19],
                                    'suku_bunga_pinjaman' => (integer)$row[20],
                                    'satuan_suku_bunga_pinjaman' => (integer)$row[21],
                                    'jenis_bunga' => (integer)$row[22],
                                    'tgl_mulai_publikasi_pinjaman' => (integer)$row[23],
                                    'rencana_jangka_waktu_publikasi' => (integer)$row[24],
                                    'realisasi_jangka_waktu_publikasi' => $row[25],
                                    'tgl_mulai_pendanaan' => (integer)$row[26],
                                    'frekuensi_pinjaman' => (integer)$row[27],
                                ];
                }
                elseif ($namaFile == 'profile_penyelenggara')
                {
                    $csvData[] = 
                                [
                                    'id_penyelenggara' => (integer)$row[0],
                                    'nama_penyelenggara' => $row[1],
                                    'layanan_pinjaman' => (integer)$row[2],
                                    'jumlah_tenaga_kerja_pria' => (integer)$row[3],
                                    'jumlah_tenaga_kerja_wanita' => (integer)$row[4],
                                    'jumlah_kantor_cabang' => (integer)$row[5],
                                ];
                }
                elseif ($namaFile == 'Reg_Borrower')
                {
                    $csvData[] = 
                                [
                                    'id_penyelenggara' => (integer)$row[0],
                                    'id_borrower' => (integer)$row[1],
                                    'kode_penguna' => (integer)$row[2],
                                    'kode_jenis_pengguna' => (integer)$row[3],
                                    'nama_borrower' => $row[4],
                                    'no_ktp' => (integer)$row[5],
                                    'no_npwp' => $row[6],
                                    'id_jenis_badan_hukum' => (integer)$row[7],
                                    'tempat_lahir' => $row[8],
                                    'tgl_lahir' => $row[9],
                                    'id_jenis_kelamin' => (integer)$row[10],
                                    'alamat' => $row[11],
                                    'id_kota' => (integer)$row[12],
                                    'id_provinsi' => (integer)$row[13],
                                    'kode_pos' => (integer)$row[14],
                                    'id_agama' => (integer)$row[15],
                                    'id_status_perkawinan' => (integer)$row[16],
                                    'id_pekerjaan' => (integer)$row[17],
                                    'id_bidang_pekerjaan' => (integer)$row[18],
                                    'id_pekerjaan_online' => (integer)$row[19],
                                    'pendapatan' => (integer)$row[20],
                                    'total_aset' => (integer)$row[21],
                                    'pengalaman_kerja' => (integer)$row[22],
                                    'id_pendidikan' => (integer)$row[23],
                                    'status_kepemilikan_rumah' => (integer)$row[24],
                                    'nama_perwakilan' => $row[25],
                                    'no_ktp_perwakilan' => (integer)$row[26],
                                ];
                }
                elseif ($namaFile == 'Reg_Lender')
                {
                    $csvData[] = 
                                [
                                    'id_penyelenggara' => (integer)$row[0],
                                    'id_lender' => (integer)$row[1],
                                    'kode_penguna' => (integer)$row[2],
                                    'jenis_pengguna' => (integer)$row[3],
                                    'nama_lender' => $row[4],
                                    'no_ktp' => (integer)$row[5],
                                    'no_npwp' => $row[6],
                                    'id_jenis_badan_hukum' => (integer)$row[7],
                                    'id_negara_domisili' => (integer)$row[8],
                                    'tempat_lahir' => $row[9],
                                    'tgl_lahir' => $row[10],
                                    'id_jenis_kelamin' => (integer)$row[11],
                                    'alamat' => $row[12],
                                    'id_kota' => (integer)$row[13],
                                    'id_provinsi' => (integer)$row[14],
                                    'kode_pos' => (integer)$row[15],
                                    'id_agama' => (integer)$row[16],
                                    'id_status_perkawinan' => (integer)$row[17],
                                    'id_pekerjaan' => (integer)$row[18],
                                    'id_bidang_pekerjaan' => (integer)$row[19],
                                    'pendapatan' => (integer)$row[20],
                                    'pengalaman_kerja' => (integer)$row[21],
                                    'id_pendidikan' => (integer)$row[22],
                                    'id_kewarganegaraan' => (integer)$row[23],
                                    'sumber_dana' => (integer)$row[24],
                                    'nama_perwakilan' => $row[25],
                                    'no_ktp_perwakilan' => (integer)$row[26],
                                ];
                }
                elseif ($namaFile == 'Reg_Pengguna')
                {
                    $csvData[] = 
                                [
                                    'id_penyelenggara' => (integer)$row[0],
                                    'id_pengguna' => (integer)$row[1],
                                    'kode_penguna' => $row[2],
                                    'jenis_pengguna' => (integer)$row[3],
                                    'tgl_registrasi' => $row[4],
                                    'nama_pengguna' => $row[5],
                                    'no_ktp' => (integer)$row[6],
                                    'no_npwp' => $row[7],
                                ];
                }
                elseif ($namaFile == 'Rincian_Direksi_Komisaris_PS')
                {
                    $csvData[] = 
                                [
                                    'id_penyelenggara' => (integer)$row[2],
                                    'nama' => $row[3],
                                    'no_ktp' => (integer)$row[4],
                                    'jabatan' => $row[5],
                                    'masa_jabatan' => $row[6],
                                    'npwp/tin' => $row[7],
                                    'jumlah_nilai_saham' => (integer)$row[8],
                                    'jumlah_lebar_saham' => (integer)$row[9],
                                    'presentase_nilai_saham' => $row[10],
                                ];
                }
                elseif ($namaFile == 'Rincian_Escrow')
                {
                    $csvData[] = 
                                [
                                    'kode_bank' => $row[1],
                                    'no_rekening_escrow' => (integer)$row[2],
                                    'id_penyelenggara' => (integer)$row[3],
                                ];
                }
                elseif ($namaFile == 'Rincian_Kerjasama_LJK')
                {
                    $csvData[] = 
                                [
                                    'nama_ljk' => $row[0],
                                    'jenis_ljk' => $row[1],
                                    'domisili_ljk' => $row[2],
                                    'id_penyelenggara' => $row[3],
                                ];
                }
                elseif ($namaFile == 'Rincian_Layanan_Pendukung')
                {
                    $csvData[] = 
                                [
                                    'nama_layanan_pendukung' => $row[1],
                                    'jenis_layanan_pendukung' => (integer)$row[2],
                                    'domisili_layanan_pendukung' => $row[3],
                                ];
                }
                elseif ($namaFile == 'Transaksi_Pinjam_Meminjam')
                {
                    $csvData[] = 
                                [
                                    'id_penyelenggara' => $row[0],
                                    'id_pinjaman' => $row[1],
                                    'id_borrower' => $row[2],
                                    'id_lender' => $row[3],
                                    'id_transaksi' => $row[4],
                                    'no_perjanjian_borrower' => $row[5],
                                    'tgl_perjanjian_borrower' => $row[6],
                                    'nilai_pendanaan' => $row[7],
                                    'suku_bunga_pinjaman' => $row[8],
                                    'satuan_suku_bunga_pinjaman' => $row[9],
                                    'id_jenis_pembayaran' => $row[10],
                                    'id_frekuensi_pembayaran' => $row[11],
                                    'nilai_angsuran' => $row[12],
                                    'objek_jaminan' => $row[13],
                                    'id_provinsi' => $row[14],
                                    'jangka_waktu_pinjaman' => $row[15],
                                    'satuan_jangka_waktu_pinjaman' => $row[16],
                                    'tgl_jatuh_tempo' => $row[17],
                                    'tgl_pendanaan' => $row[18],
                                    'tgl_penyaluran_dana' => $row[19],
                                    'no_ea_transaksi' => $row[20],
                                    'frekuensi_pendanaan' => $row[21],
                                ];
                }
                else
                {
                    $csvData[] = [];
                }   
            }
            $this->data_json = $csvData;
            return view('pages.admin.convertCSVToJSON',['success' => 'Upload success', 'data_json' => $this->data_json]);
        }  
        return redirect()->back()->with(['error' => 'Failed to upload file']);
    }

    public function showMenu()
    {
        return view('pages.admin.edit_menu');
    }

    public function add_role(Request $request)
    {
        $role = new ManageRole;
        $role->name = $request->role;
        $role->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Pengguna";
        $audit->description = "Tambah Peran";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        $getRole = ManageRole::orderBy('id','desc')->first();
        
        for($i = 0;$i<sizeof($request->dataMenu);$i++)
        {
            $rbac= new RBAC;
            $rbac->id_role = $getRole->id;
            $rbac->id_menu = $request->dataMenu[$i];

            $rbac->save();
        }

        return redirect()->back()->with('success', 'Create Success');
    }

    public function get_role()
    {
        $role = ManageRole::orderBy('id','asc')->get();
        
        $response = ['data' => $role];

        return response()->json($response);
    }

    public function edit_role(Request $request)
    {
        $role_edit = ManageRole::where('id',$request->role_id)->first();
        $role_edit->name = $request->role_edit;
        $role_edit->save();

        $rbacDelete = RBAC::where('id_role',$request->role_id)->delete();
        for($i = 0;$i<sizeof($request->dataMenuEdit);$i++)
        {
            $rbac_edit = new RBAC;
            $rbac_edit->id_role = $request->role_id;
            $rbac_edit->id_menu = $request->dataMenuEdit[$i];

            $rbac_edit->save();
        }

         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Pengguna";
        $audit->description = "Ubah data peran";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('updated', 'Update Success');
    }

    public function delete_role($id)
    {
        $role_delete = ManageRole::where('id',$id)->delete();
        $rbacDelete = RBAC::where('id_role',$id)->delete();
        if ($role_delete && $rbacDelete)
        {
            $response = ['status' => 'Sukses'];
        }

         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Pengguna";
        $audit->description = "Hapus data peran";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return response()->json($response);
    }

    public function edit_menu($id)
    {
        $dataMenu = AdminMenuItem::leftJoin('rbac','rbac.id_menu','=','admin_menu_items.id')
                                    ->where('rbac.id_role',$id)
                                    ->orderBy('admin_menu_items.id','asc')
                                    ->get(['rbac.id_role','rbac.id_menu','admin_menu_items.label']);
        $cekMenu = array();
        foreach($dataMenu as $menu)
        {
            $cekMenu[] = $menu->id_menu;
        }
        
        $dataMenuElse = AdminMenuItem::whereNotIn('id',$cekMenu)
                                    ->whereNotIn('id',[\DB::raw('select parent from admin_menu_items where parent != 0')])
                                    ->orderBy('id','asc')
                                    ->get(['id']);
        
        return response()->json(['data' => $dataMenu, 'dataElse' => $dataMenuElse]);
    }

    public function get_users_datatables()
    {
        $users = Admins::leftJoin('roles','roles.id','=','admins.role')
                        ->get(['admins.firstname','admins.lastname','admins.email','admins.id','admins.role','roles.name']);

        return response()->json(['data' => $users]);
    }

    public function editAdmins(Request $request)
    {
        
        $admin_edit = Admins::where('id',$request->id_user)->first();

        if(Auth::user()->email == $request->email){
            return redirect()->route('admin.manage')->with('exists', 'User exists!');
        }

        $admin_edit->firstname = $request->firstname;
        $admin_edit->lastname = $request->lastname;
        $admin_edit->email = $request->email;
        $admin_edit->address = $admin_edit->address;
        $admin_edit->password = $admin_edit->password;
        $admin_edit->role = $request->role;

        $admin_edit->save();

         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Pengguna";
        $audit->description = "Ubah pengguna";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->route('admin.manage')->with('editdone', 'Edit User successfull');
    }

    public function showLink()
    {
        return view('pages.admin.link_verifikasi_register'); 
    }

    public function get_link_investor()
    {
        $link = Investor::where('status','Not Active')
                        ->orderBy('id','desc')
                        ->get();
        return response()->json(['data' => $link]);
    }

    public function upload_penghargaan($column, Request $request)
    {
        if($request->hasFile($column))
            {
                $file = $request->file($column);
                $filename = Carbon::now()->toDateString() . $request->gambar->getClientOriginalName();
                $store_path = 'penghargaan';
                $path = $file->storeAs($store_path, $filename,'public');
                return $path;
                
            }
        else
            {
                return null;
            }
    }

    public function managePenghargaan()
    {
        return view('pages.admin.manage_penghargaan');
    }

    public function get_penghargaan()
    {
        $gambar = ManagePenghargaan::all();
        
        $response = ['data' => $gambar];

        return response()->json($response);
    }

    public function admin_add_penghargaan(Request $request)
    {
        $new = new ManagePenghargaan;
        $new->title = $request->title;
        $new->keterangan = $request->keterangan;
        $new->tgl_publish = Carbon::now()->toDateString();
        $new->author = 'Admin';
        $new->gambar = $this->upload_penghargaan('gambar',$request);

        $new->save();
        
         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Penghargaan";
        $audit->description = "Tambah penghargaan";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('success', 'Add Penghargaan Sukses');
    }

    public function admin_delete_penghargaan($id){
        
        $carousel = ManagePenghargaan::where('id',$id)->first();

        Storage::disk('public')->delete($carousel->gambar);

        $carousel_delete = ManagePenghargaan::where('id',$id)->delete();

        if ($carousel_delete)
        {
            $response = ['status' => 'Sukses'];
        }

         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Penghargaan";
        $audit->description = "Hapus penghargaan";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return response()->json($response);
    }

    public function admin_update_penghargaan(Request $request)
    {
        
        $update = ManagePenghargaan::where('id',$request->id)->first();
        // var_dump($update);
        $update->title = $request->title;
        $update->keterangan = $request->keterangan;
        $update->tgl_publish = Carbon::now()->toDateString();
        $update->author = 'Admin';

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($update->gambar);
            $update->gambar = $this->upload_penghargaan('gambar', $request);
            $update->save();
        }
        
        $update->save();

         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Penghargaan";
        $audit->description = "Ubah penghargaan";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('updated', "Update Gambar Success");

    }



    public function upload_khazanah($column, Request $request)
    {
        if($request->hasFile($column))
            {
                $file = $request->file($column);
                $filename = Carbon::now()->toDateString() . $request->gambar->getClientOriginalName();
                $store_path = 'Khazanah';
                $path = $file->storeAs($store_path,$filename,'public');

                return $path;
            }
    }

    public function manageKhazanah()
    {
        return view('pages.admin.manage_khazanah');
    }

    public function get_khazanah()
    {
        $data = ManageKhazanah::all();
        $response = ['data' => $data];

        return response()->json($response);
    }

    public function addKhazanah(Request $request)
    {
        $new = new ManageKhazanah();

        $new->title = $request->title;
        $new->author = 'Admin';
        $new->tgl_publish = Carbon::now()->toDateString();
        $new->keterangan = $request->keterangan;
        $new->gambar = $this->upload_khazanah('gambar',$request);
        $new->save();

         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Khazanah";
        $audit->description = "Tambah Gambar Khazanah";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('success', 'Add Penghargaan Sukses');
    }

    public function admin_update_khazanah(Request $request)
    {
        $update = ManageKhazanah::where('id',$request->id)->first();
        $update->title = $request->title;
        $update->keterangan = $request->keterangan;
        $update->tgl_publish = Carbon::now()->toDateString();
        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($update->gambar);
            $update->gambar = $this->upload_khazanah('gambar', $request);
            $update->save();
        }
        $update->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Khazanah";
        $audit->description = "Ubah Gambar Khazanah";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('updated', "Update Gambar Success");
    }

    public function admin_delete_khazanah($id)
    {
        $delete = ManageKhazanah::where('id',$id)->first();
        Storage::disk('public')->delete($delete->gambar);

        $delete_khazanah = ManageKhazanah::where('id',$id)->delete();
        if($delete_khazanah)
        {
            $response = ['status' => 'Sukses'];
        }

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Khazanah";
        $audit->description = "Hapus Gambar Khazanah";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return response()->json($response);

    }
	
	public function list_table_mutasi(){ // admin/manage proyek mutasi
		
		$mutasi = DB::table('proyek AS a')
		->selectRaw('a.id, a.nama, a.total_need, a.harga_paket, a.terkumpul + sum(b.nominal_awal) as terkumpul, sum(b.nominal_awal) as terkumpul_dari_investor, count(b.investor_id) as jumlah_investor, sum(b.nominal_awal)/a.total_need*100 as presentasi, b.proyek_id, b.investor_id, b.id as id_pendanaan, b.total_dana, b.nominal_awal')
		->join('pendanaan_aktif AS b', 'a.id', '=', 'b.proyek_id')
		->groupBy('b.proyek_id')
		->where('b.status','=',1)
		->get();
		
		$data = array();
		$no = 1;
		if(!empty($mutasi)){
			foreach($mutasi as $row){
				$column['ID Proyek'] 			= $row->id;
				$column['Nama Proyek'] 			= (string)$row->nama;
				$column['Total Dibutuhkan'] 	= number_format($row->total_need);
				$column['Terkumpul'] 				= number_format($row->terkumpul);
				$column['Terkumpul dari Investor'] 	= number_format($row->terkumpul_dari_investor);
				$column['Jumlah Investor'] 		= $row->jumlah_investor;
				$column['Detail Mutasi'] 		= $row->id_pendanaan;
				$column['Presentasi Terkumpul'] = number_format($row->presentasi, '2');
				
				$data[] = $column;
			}
		}
		$parsingJSON = array(
						"data" => $data
		);
		echo json_encode($parsingJSON);
		
	}
	
	public function detail_table_mutasi($id){ // admin/manage proyek detail mutasi
		
		//$mutasi = DB::table('proyek')->get();
		$detail_mutasi = DB::table('investor as a')
		->selectRaw('a.id, a.email, b.investor_id, b.nama_investor, c.investor_id, c.proyek_id, c.tanggal_invest, d.pendanaanAktif_id, d.nominal')
		->join('detil_investor AS b', 'a.id', '=', 'b.investor_id')
		->join('pendanaan_aktif AS c', 'c.investor_id', '=', 'a.id')
		->join('log_pendanaan AS d', 'd.pendanaanAktif_id', '=', 'c.id')
		//->groupBy('b.proyek_id')
		->where('c.proyek_id','=',$id)
        ->where('c.status',1)
		->get();
		$data = array();
		$no = 1;
		if(!empty($detail_mutasi)){
			foreach($detail_mutasi as $row){
				//var_dump();
                $column['Proyek_id']                = (string)$row->proyek_id;
                $column['Investor_id']              = (string)$row->investor_id;
				$column['Nama Investor Pendana'] 	= (string)$row->nama_investor;
				$column['Email Investor Pendana'] 	= (string)$row->email;
				$column['Nominal Investasi'] 		= (string)number_format($row->nominal);
				$column['Tanggal Investasi'] 		= (string)$row->tanggal_invest;
				
				$data[] = $column;
				
			}
		}
		$parsingJSON = array(
						"data" => $data
		);
		
		
		
		echo json_encode($parsingJSON);
		
    }
  
    public function manageVersion()
    {
        return view('pages.admin.manage_mobile');
    }

    public function tableManageVersion()
    {
        $dataGet = MobileVersion::all();

        $dataArray = array();
        $i = 1;

        if(!empty($dataGet))
        {
            foreach($dataGet as $item)
            {
                $column['no'] = (string) $i++;
                $column['id'] = (string) $item->id;
                $column['versionMobile'] = (string) $item->version_code;
                $column['kodeVersionMobile'] = (string) $item->version;
                $column['tanggalMobile'] = (string)Carbon::parse($item->created_at)->toDateString();
                $column['gambarMobile'] = (string)$item->location;

                $dataArray[] = $column;
            }
        }

        $parsingJson = array('data' => $dataArray);

        echo json_encode($parsingJson);
    
    }

    public function postVersionMobile(Request $request)
    {

        $versi = new MobileVersion;

        $versi->version = $request->version;
        $versi->version_code = $request->version_code;
        // $versi->created_date = $request->created_date;
        $versi->save();
        
        $versi->location = $this->upload('version'.$versi->id, $request->location, 'admin');
        $versi->save();

         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Versi";
        $audit->description = "Tambah mobile version";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('success','Upload New Version Berhasil');

    }

    public function editVersionMobile(Request $request)
    {
        // echo $request->editGmbr;die;
        $updateVersi = MobileVersion::where('id',$request->idVersion)->first();

        $updateVersi->version = $request->editVersion;
        $updateVersi->version_code = $request->editVersion_code;
        // $updateVersi->created_date = $request->editCreated_date;
        // if (Storage::exists($updateVersi->location)) {
        //     Storage::disk('public')->delete($updateVersi->location);
        // }\
        if(!empty($request->editLocation))
        {
          Storage::disk('public')->delete($updateVersi->location);
          $updateVersi->location = $this->uploadVersion('version'.$updateVersi->id, $request->editLocation, 'admin');
        }
        else
        {
          
        }
        $updateVersi->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Versi";
        $audit->description = "Ubah mobile version";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('success','Update Version Berhasil');
    }

    public function deleteVersion($id)

    {
        $deleteVersi = MobileVersion::find($id);
        Storage::disk('public')->delete($deleteVersi->location);
        $deleteVersi->delete();
        
        $response = ['data' => 'sukses'];

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Versi";
        $audit->description = "Hapus mobile version";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return response()->json($response);
    }
  
    private function uploadVersion($column, $request, $store_path)
    {
        $file = $request;
        if(!empty($file))
        {
          $filename = Carbon::now()->toDateString() . $column . '.' . $file->getClientOriginalExtension();

          $path = $file->storeAs($store_path, $filename, 'public');
          return $path;

        }
        else
        {
          return true;
        }
    }

    public function show_menu_teks()
    {
        return view('pages.admin.teks_notifikasi');
    }

    public function datatables_teks()
    {
        $teks = TeksNotifikasi::all();
        
        $response = ['data' => $teks];

        return response()->json($response);
    }

    public function admin_add_teks(Request $request) {

        $teks = new TeksNotifikasi;
        
        $teks->teks_notifikasi = $request->teks_notif;
        $teks->tipe = $request->tipe;
        
        $teks->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Teks Notifikasi";
        $audit->description = "Tambah teks notifikasi data kontrak";
        $audit->ip_address =  \Request::ip();
        $audit->save();
        
        return redirect()->back()->with('success', 'Tambah Teks Berhasil');
    }
    
    public function admin_update_teks(Request $request){
        
        $teks = TeksNotifikasi::where('id_teks_notifikasi',$request->id_teks_notifikasi)->first();
        // echo $request->edit_tipe;die;

        $teks->teks_notifikasi = $request->edit_teks_notif;
        $teks->tipe = $request->edit_tipe;

        $teks->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Teks Notifikasi";
        $audit->description = "Ubah teks notifikasi data kontrak";
        $audit->ip_address =  \Request::ip();
        $audit->save();
        

        return redirect()->back()->with('updated', "Ubah Teks Berhasil");

    }

    public function admin_delete_teks($id){
        
        $teks = TeksNotifikasi::where('id_teks_notifikasi',$id)->first();

        $teks_delete = TeksNotifikasi::where('id_teks_notifikasi',$id)->delete();

        if ($teks_delete)
        {
            $response = ['status' => 'Sukses'];
        }

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Teks Notifikasi";
        $audit->description = "Hapus teks notifikasi data kontrak";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return response()->json($response);

    }

    public function show_menu_threshold()
    {
        return view('pages.admin.threshold_kontrak');
    }

    public function datatables_threshold()
    {
        $threshold = ThresholdKontrak::all();
        
        $response = ['data' => $threshold];

        return response()->json($response);
    }

    public function admin_add_threshold(Request $request) {

        $threshold = new ThresholdKontrak;
        
        $threshold->threshold_kontrak = $request->threshold;
        $threshold->tipe = $request->tipe;
        
        $threshold->save();

         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Threshold Kontrak";
        $audit->description = "Tambah threshold kontrak";
        $audit->ip_address =  \Request::ip();
        $audit->save();
        
        return redirect()->back()->with('success', 'Tambah Threshold Berhasil');
    }
    
    public function admin_update_threshold(Request $request){
        
        $threshold = ThresholdKontrak::where('id_threshold',$request->id_threshold)->first();
        // echo $request->edit_tipe;die;

        $threshold->threshold_kontrak = $request->edit_threshold;
        $threshold->tipe = $request->edit_tipe;

        $threshold->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Threshold Kontrak";
        $audit->description = "ubah threshold kontrak";
        $audit->ip_address =  \Request::ip();
        $audit->save();
        

        return redirect()->back()->with('updated', "Ubah Threshold Berhasil");

    }

    public function admin_delete_threshold($id){
        
        $threshold = ThresholdKontrak::where('id_threshold',$id)->first();

        $threshold_delete = ThresholdKontrak::where('id_threshold',$id)->delete();

        if ($threshold_delete)
        {
            $response = ['status' => 'Sukses'];
        }

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Threshold Kontrak";
        $audit->description = "Hapus threshold kontrak";
        $audit->ip_address =  \Request::ip();
        $audit->save();
        
        return response()->json($response);

    }

    public function showaddSyaratKetentuan()
    {
        return view('pages.admin.add_syarat_ketentuan');
    }

    public function listSyaratKetentuan() {
        $term_condition = TermCondition::all();
        return view('pages.admin.listSyaratKetentuan')->with('term_condition', $term_condition);
    }

    public function postSyaratKetentuan(Request $request) {
        $news = new TermCondition;
        $news->title = $request->judul;
        $news->writer = $request->writer;
        $news->deskripsi = $request->deskripsi;
        $news->save();

        return redirect()->back()->with('success', 'Sukses menyimpan data');
    }

    public function updateSyaratKetentuan(Request $request){
        $term_condition = TermCondition::find($request->id);
        $term_condition->title = $request->judul;
        $term_condition->writer = $request->writer;
        $term_condition->deskripsi = $request->deskripsi;
        
        $term_condition->save();

        return redirect()->back()->with('Edit', 'Edit berhasil');
    }

    public function deleteSyaratKetentuan(Request $request){
        $delete = TermCondition::find($request->id)->delete();
        return redirect()->back()->with('delete', 'Berhasil hapus Syarat Ketentuan');
    }

    public function managePendanaanBorower()
    {
        // echo Config::get('constan.url');die;
        return view('pages.admin.pendanaanBorrower');
    }
	
	public function listBorrower()
    {
        // echo Config::get('constan.url');die;
        return view('pages.admin.list_borrower');
    }
	public function list_pendanaan_borrower($id)
    {
        $dataGet = BorrowerPendanaan::leftJoin('brw_users_details','brw_users_details.brw_id','=','brw_pendanaan.brw_id')
                                    ->where('brw_pendanaan.brw_id', $id)
                                    ->get([
                                            'brw_pendanaan.*',
                                            'brw_users_details.brw_type'
                                        ]);

        $dataArray = array();

        if(!empty($dataGet))
        {
            foreach($dataGet as $item)
            {
                $column = array();
				$column[] = (string)$item->pendanaan_id;
                $column[] = (string)$item->brw_id;
                $column[] = (string)$item->brw_type;
                $column[] = (string)$item->pendanaan_nama;
                $column[] = (string)$item->pendanaan_dana_dibutuhkan;
                $column[] = (string)Carbon::parse($item->estimasi_mulai)->toDateString();
                $column[] = (string)$item->status;
                $column[] = (string)$item->id_proyek;
                $column[] = '';

                $dataArray[] = $column;
            }
        }

        $parsingJson = array('data' => $dataArray);

        echo json_encode($parsingJson);
    }
	
    public function manageScorringBorower()
    {
        return view('pages.admin.scorringBorrower');
    }
      
    public function manageVerifikasiBorrower()
    {
        return view('pages.admin.verifikasiBorrower');
    }
	
	public function edit_poto_1(Request $request){
		if ($request->file('file')) {
            $file = $request->file('file');
            $filename = 'pic_brw' . '.' . $file->getClientOriginalExtension();
            // $resize = Image::make($file)->resize(480,640, function ($constraint) {
                // $constraint->aspectRatio();
            // })->save();
			
			
			$resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save($filename);
			// save nama file berdasarkan tanggal upload+nama file
            $store_path = 'borrower/' . $brw_id; 
            $path = $file->storeAs($store_path, $filename, 'public');
			// save gambar yang di upload di public storage
            
			// Storage::disk('public')->delete('user/'.$investor_id.'/'.$filename);

			if(Storage::disk('public')->exists('borrower/'.$brw_id.'/'.$filename)){
				return response()->json([
					'success' => 'Berhasil di upload',
					'url' => "borrower/".$brw_id."/".$filename,
					'filename' => $filename
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
	
	public function update_borrower(Request $request){
		
		if($brw_users->type_borrower == 1 || $brw_users->type_borrower == 3){
			// proses individu
			$Borrower = BorrowerDetails::where('brw_id',$brw_users->brw_id)->first();

            $Borrower->nama = $brw_users->txt_nm_individu;
            $Borrower->nm_ibu = $brw_users->txt_nm_ibu_individu;
            $Borrower->ktp = $brw_users->txt_no_ktp_individu;
            $Borrower->npwp = $brw_users->txt_no_npwp_individu;
            $Borrower->tgl_lahir = $brw_users->txt_thn_lahir.'-'.$brw_users->txt_bln_lahir.'-'.$brw_users->txt_tgl_lahir;
            $Borrower->no_tlp = $brw_users->txt_no_telp_individu; 
            $Borrower->jns_kelamin = $brw_users->txt_jns_kelamin;
            $Borrower->status_kawin = $brw_users->txt_sts_nikah;
            $Borrower->alamat = $brw_users->txt_alamat_individu;

            $Borrower->domisili_alamat = $brw_users->txt_alamat_domisili_individu;
            $Borrower->domisili_provinsi = $brw_users->txt_provinsi_domisili_individu;
            $Borrower->domisili_kota = $brw_users->txt_kota_domisili_individu;
            $Borrower->domisili_kecamatan = $brw_users->txt_kecamatan_domisili_individu;
            $Borrower->domisili_kelurahan = $brw_users->txt_kelurahan_domisili_individu;
            $Borrower->domisili_kd_pos = $brw_users->txt_kd_pos_domisili_individu;

            $Borrower->provinsi = $brw_users->txt_provinsi_individu;
            $Borrower->kota = $brw_users->txt_kota_individu;
            $Borrower->kecamatan = $brw_users->txt_kecamatan_individu;
            $Borrower->kelurahan = $brw_users->txt_kelurahan_individu;
            $Borrower->kode_pos = $brw_users->txt_kd_pos_individu;
            $Borrower->status_rumah = $brw_users->txt_pemilik_rumah;

            $Borrower->agama = $brw_users->txt_agama;
            $Borrower->tempat_lahir = $brw_users->txt_tmpt_lahir_individu; 
            $Borrower->pendidikan_terakhir = $brw_users->txt_pendidikan_pribadi; 
            $Borrower->pekerjaan = $brw_users->txt_pekerjaan_individu;
            $Borrower->bidang_pekerjaan = $brw_users->txt_bidang_pekerjaan_individu;
            $Borrower->bidang_online = $brw_users->txt_bidang_online_individu;
            $Borrower->pengalaman_pekerjaan = $brw_users->txt_pengalaman_individu; 
            $Borrower->pendapatan = $brw_users->txt_pendapatan_bulan_individu; 
           
			// poto
			// $Borrower->brw_pic = $brw_users->url_pic_brw;
            // $Borrower->brw_pic_ktp = $brw_users->url_pic_brw_ktp;
            // $Borrower->brw_pic_user_ktp = $brw_users->url_pic_brw_dengan_ktp;
            // $Borrower->brw_pic_npwp = $brw_users->url_pic_brw_npwp;
			
            $Borrower->update();

            // insert data Ahli Waris
			$BorrowerAW = BorrowerAhliWaris::where('brw_id',$brw_users->brw_id)->first();
            $BorrowerAW->nama_ahli_waris = $brw_users->txt_nm_aw; 
            $BorrowerAW->nik = $brw_users->txt_nik_aw; 
            $BorrowerAW->no_tlp = $brw_users->txt_no_hp_aw; 
            $BorrowerAW->email = $brw_users->txt_email_aw;
            $BorrowerAW->alamat = $brw_users->txt_alamat_aw;  
            $BorrowerAW->provinsi = $brw_users->txt_provinsi_aw;
            $BorrowerAW->kota = $brw_users->txt_kota_aw;
            $BorrowerAW->kecamatan = $brw_users->txt_kecamatan_aw;
            $BorrowerAW->kelurahan = $brw_users->txt_kelurahan_aw_pribadi;
            $BorrowerAW->kd_pos = $brw_users->txt_kd_pos_aw;
            $BorrowerAW->update();  

            //insert data REkening
            $BorrowerRek = BorrowerRekening::where('brw_id',$brw_users->brw_id)->first();  
            $BorrowerRek->brw_norek = $brw_users->txt_no_rek_individu; 
            $BorrowerRek->brw_nm_pemilik = $brw_users->txt_nm_pemilik_individu; 
            $BorrowerRek->brw_kd_bank = $brw_users->txt_bank_individu; 
            $BorrowerRek->update();
			
			echo "sukses";
			
		}else{
			
			// proses badan hukum
				$Borrower = BorrowerDetails::where('brw_id',$brw_users->brw_id)->first();  
                $Borrower->nama = $brw_users->txt_nm_anda_bdn_hukum;
                $Borrower->nm_bdn_hukum = $brw_users->txt_nm_bdn_hukum; 
                $Borrower->jabatan = $brw_users->txt_jabatan_bdn_hukum; 
                $Borrower->brw_type = $brw_users->type_borrower;
                $Borrower->ktp = $brw_users->txt_nik_bdn_hukum;
                $Borrower->npwp = $brw_users->txt_npwp_bdn_hukum;
                $Borrower->no_tlp = $brw_users->txt_no_hp_bdn_hukum; 
                $Borrower->alamat = $brw_users->txt_alamat_bdn_hukum;
                $Borrower->provinsi = $brw_users->txt_provinsi_bdn_hukum;
                $Borrower->kota = $brw_users->txt_kota_bdn_hukum;
                $Borrower->kecamatan = $brw_users->txt_kecamatan_bdn_hukum;
                $Borrower->kelurahan = $brw_users->txt_kelurahan_bdn_hukum;
                $Borrower->kode_pos = $brw_users->txt_kd_pos_bdn_hukum;
                $Borrower->bidang_perusahaan = $brw_users->txt_bidang_pekerjaan_bdn_hukum;
                $Borrower->bidang_online = $brw_users->txt_bidang_online_bdn_hukum;
                $Borrower->pendapatan = $brw_users->txt_revenue_bulanan_bdn_hukum; 
                $Borrower->total_aset = $brw_users->txt_total_asset_bdn_hukum; 
                // $Borrower->brw_pic = $brw_users->url_pic_brw_bdn_hukum;
                // $Borrower->brw_pic_ktp = $brw_users->url_pic_brw_ktp_bdn_hukum;
                // $Borrower->brw_pic_user_ktp = $brw_users->url_pic_brw_dengan_ktp_bdn_hukum;
                // $Borrower->brw_pic_npwp = $brw_users->url_pic_brw_npwp_bdn_hukum;
                $Borrower->update();

                 // insert data pengurus
                 $ahliWaris = BorrowerPengurus::where('brw_id',$brw_users->brw_id)->first();  
                 $ahliWaris->nm_pengurus = $brw_users->txt_nm_pengurus; 
                 $ahliWaris->nik_pengurus = $brw_users->txt_nik_pengurus; 
                 $ahliWaris->no_tlp = $brw_users->txt_no_hp_pengurus; 
                 $ahliWaris->jabatan = $brw_users->txt_jabatan_pengurus;
                 $ahliWaris->update();
                
                // insert data Rekening
                $ahliWaris =  BorrowerRekening::where('brw_id',$brw_users->brw_id)->first();  
                $ahliWaris->brw_norek = $brw_users->txt_no_rek_bdn_hukum; 
                $ahliWaris->brw_nm_pemilik = $brw_users->txt_nm_pemilik_bdn_hukum; 
                $ahliWaris->brw_kd_bank = $brw_users->txt_bank_bdn_hukum; 
                $ahliWaris->update();
				
				echo "sukses";
        }
         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Daftar Penerima Pendanaan";
        $audit->description = "Ubah data Penerima pendanaan";
        $audit->ip_address =  \Request::ip();
        $audit->save();
		
	}
	
	public function ListTableApproveDana(){
		return view('pages.admin.list_approve_dana');
	}
	
	public function listApproveDana(){
		
		// $listApproveDana = DB::table('brw_pendanaan AS a')
        // ->join('log_akad_digisign_borrower AS b', 'a.id_proyek', '=', 'b.id_proyek')
        // ->join('brw_rekening AS c', 'a.brw_id', '=', 'c.brw_id')
		// //->selectRaw('a.brw_id, a.id_proyek, a.pendanaan_nama, a.pendanaan_dana_dibutuhkan, a.status as status_pendanaan, a.metode_pembayaran, a.dana_dicairkan, a.status_dana, b.brw_id, b.id_proyek, b.status as status_akad, c.brw_norek, c.brw_kd_bank, sum(b.total_pendanaan) as total_dana_terkumpul')
		// //->join('log_akad_digisign_borrower AS b', 'a.id_proyek', '=', 'b.id_proyek')
		// ->join('pendanaan_aktif AS d', 'd.proyek_id', '=', 'a.id_proyek')
		// ->selectRaw('a.brw_id, a.id_proyek, a.pendanaan_nama, a.pendanaan_dana_dibutuhkan, a.status as status_pendanaan, a.status_dana, a.dana_dicairkan, b.status as status_akad, c.brw_norek, c.brw_kd_bank, sum(d.total_dana) as total_dana_terkumpul')
		// ->where('b.status','=', "complete")
		// ->where('a.status_dana','=', 2)
		// ->get();
		
		$listApproveDana = DB::table('brw_pendanaan AS a')
			->join('log_akad_digisign_borrower AS b', 'a.id_proyek', '=', 'b.id_proyek')
			//->join('pendanaan_aktif AS c', 'c.proyek_id', '=', 'a.id_proyek')
			->selectRaw('a.brw_id, a.id_proyek, a.pendanaan_nama, a.pendanaan_dana_dibutuhkan, a.status_dana, a.dana_dicairkan, b.status as status_akad')
			->where(\DB::raw('substr(b.document_id, 1, 10)'), '=' , 'kontrakAll')
			->where('b.status','=', "complete")
			->where('a.status_dana','=', 2)->get();
		
		
		$dataArray = array();

        if(!empty($listApproveDana))
        {
            foreach($listApproveDana as $item)
            {
				$sumPendanaanAktif = PendanaanAktif::where('proyek_id', $item->id_proyek)->sum('total_dana');
				
                $column = array();
				$column[] = (string)$item->brw_id;
				$column[] = (string)$item->id_proyek;
                $column[] = (string)$item->pendanaan_nama;
                $column[] = (string)$item->pendanaan_dana_dibutuhkan;
                //$column[] = (string)$item->metode_pembayaran;
                $column[] = (string)$sumPendanaanAktif;
                //$column[] = (string)$item->status_pendanaan;
                //$column[] = (string)$item->status_dana;
                //$column[] = (string)$item->status_akad;
                //$column[] = (string)$item->dana_dicairkan;
                //$column[] = (string)$item->brw_norek;
                //$column[] = (string)$item->brw_kd_bank;

                $dataArray[] = $column;
            }
        }

        $parsingJson = array('data' => $dataArray);

        echo json_encode($parsingJson);
	}
	
	public function prosesCairDana(Request $request){
		
		$Rekening = DB::table('brw_rekening')
		->where('brw_rekening.brw_id','=', $request->brw_id)
		->first();
		
		$total_plafon = $Rekening->total_plafon;
		$total_sisa = $Rekening->total_sisa;
		$total_terpakai = $Rekening->total_terpakai;
		
		  // insert data pengurus
		$pendanaan = BorrowerPendanaan::where('brw_id',$request->brw_id)->where('id_proyek',$request->id_proyek)->first();  
		$pendanaan->status = 7; 
		$pendanaan->status_dana = 1; 
		$pendanaan->update();
		
		// summary pendaan
		$pendanaanAktif = DB::table('pendanaan_aktif')
                ->where('proyek_id', $request->id_proyek)->sum('total_dana');
				
		// update plafon
		$plafon_terpakai 		= $total_terpakai + $pendanaanAktif;
		$plafon_sisa		 	= $total_plafon -  $plafon_terpakai;

        // update plafon
		$Rekening_update = BorrowerRekening::where('brw_id',$request->brw_id)->first();  
		$Rekening_update->total_terpakai = $plafon_terpakai; 
		$Rekening_update->total_sisa = $plafon_sisa; 
		$Rekening_update->update();

		return response()->json(['status' => "sukses"]);
		
		//$client = new Client();
		//$request = $client->post(config('app.apilink')."/borrower/proses_pendanaan",[
		//	'form_params' =>
		//	[
		//		"brw_id"			=> $request->brw_id,
		//		"proyek_id"			=> $request->proyek_id
		//  ]
		//]);

		//$response = json_decode($request->getBody()->getContents());
	
		//dd($response);
		//echo $request->getBody();
		
		
		
    }

    // public function inquiryTransfer($bank_rdl_code,$accno_src,$accno_dest,$currency,$amount,$berita_transfer,$bank_code_dest){
    public function inquiryTransfer(Request $request){
        
		
        
		$accno_src = config('app.bnik_main_account');
		// proses update
		$Rekening = DB::table('brw_rekening')
		->where('brw_rekening.brw_id','=', $request->brw_id)
		->first();
		
		$total_plafon = $Rekening->total_plafon;
		$total_sisa = $Rekening->total_sisa;
		$total_terpakai = $Rekening->total_terpakai;
		
        $accno_dest = $Rekening->brw_norek;
        $amount = $request->dana_dicairkan;
        $currency = 'IDR';
        $berita_transfer = 'test';
        $bank_code_dest = $Rekening->brw_kd_bank;
        $bank_rdl_code = '009';
		
        $client = new RDLController();
		
        if($bank_rdl_code == $bank_code_dest){
			
            // insert data pengurus
			$pendanaan = BorrowerPendanaan::where('brw_id',$request->brw_id)->where('id_proyek',$request->id_proyek)->first();  
			$pendanaan->status = 7; 
			$pendanaan->status_dana = 1; 
			$pendanaan->update();
			
					
			// update plafon
			$plafon_terpakai 		= $total_terpakai + $amount ;
			$plafon_sisa		 	= $total_plafon -  $plafon_terpakai;
			
			// update plafon
			BorrowerRekening::where('brw_id', $request->brw_id)->update(['total_terpakai'=>$plafon_terpakai,'total_sisa'=>$plafon_sisa]);
			
			return $client->inquiryAccountInfo($bank_rdl_code,$accno_dest); // proses transfer
			
        }else{
			
			  // insert data pengurus
			$pendanaan = BorrowerPendanaan::where('brw_id',$request->brw_id)->where('id_proyek',$request->id_proyek)->first();  
			$pendanaan->status = 7; 
			$pendanaan->status_dana = 1; 
			$pendanaan->update();
			
			
			// update plafon
			$plafon_terpakai 		= $total_terpakai + $amount ;
			$plafon_sisa		 	= $total_plafon -  $plafon_terpakai;
			
			// update plafon
			BorrowerRekening::where('brw_id', $request->brw_id)->update(['total_terpakai'=>$plafon_terpakai,'total_sisa'=>$plafon_sisa]);
			
            return $client->inquiryTransferTransactionOnline($bank_rdl_code,$accno_src,$bank_code_dest,$accno_dest);
        
		}
        
    }
    
    public function executeTransfer($bank_rdl_code,$accno_src,$accno_dest,$currency,$amount,$berita_transfer,$bank_code_dest){
        $client = new RDLController();
        if($bank_rdl_code == $bank_code_dest){
            return $client->executeTransferTransactionOverbooking($bank_rdl_code,$accno_src,$accno_dest,$currency,$amount,$berita_transfer);
        }else{
            // 0 sd 20jt online
            // 20jt > 1m Sistem Kliring Nasional
            // 1m > RTGS
            $limit1 = 20000000;
            $limit2 = 1000000000;
         
            if($amount <= $limit1){
                return $client->executeTransferTransactionOnline($bank_rdl_code,$accno_src,$bank_code_dest,$accno_dest,$accname_dest,$currency,$amount);
            }elseif($amount > $limit1 && $amount <= $limit2){
                return $client->executeTransferTransactionKliring($bank_rdl_code,$accno_src,$bank_code_dest,$accno_dest,$accname_dest,$beneficiaryAddress1,$beneficiaryAddress2,$beneficiaryAddress3,$currency,$amount,$berita_transfer);
            }elseif($amount > $limit2){
                return $client->executeTransferTransactionRTGS($bank_rdl_code,$accno_src,$bank_code_dest,$accno_dest,$accname_dest,$beneficiaryAddress1,$beneficiaryAddress2,$currency,$amount,$berita_transfer);
            }
        }
    }    
    
    public function show_menu_audit_trail()
    {
        return view('pages.admin.audit_trail');
    }

    public function datatables_audit_trail()
    {
        $audit = AuditTrail::all();
        
        $response = ['data' => $audit];

        return response()->json($response);
    }

    public function ManageTestimoniPendana()
    {
        return view('pages.admin.manage_testimoni_pendana');
    }

    public function ManageMediaOnline()
    {
        return view('pages.admin.manage_media_online');
    }

    public function ManageInformasiPerusahaan()
    {
        return view('pages.admin.manage_informasi_perusahaan');
    }

    public function ManageDisclaimerOJK()
    {
        return view('pages.admin.manage_disclaimer_ojk');
    }

    public function ManageTermCondition()
    {
        return view('pages.admin.manage_term_condition');
    }

    public function ManagePrivacyPolicy()
    {
        return view('pages.admin.manage_privacy_policy');
    }

    public function ManageFAQ()
    {
        return view('pages.admin.manage_faq');
    }

    public function admin_add_testimoni(Request $request) {

        $testimoni = new TestimoniPendana;
        
        $testimoni->nama = $request->nama_pendana;
        $testimoni->content = $request->testimoni;
        $testimoni->link = $request->link_testimoni;
        $testimoni->gambar = $this->upload_foto_pendana('foto_pendana', $request);
        $testimoni->type = 1;
        $testimoni->author = Auth::guard('admin')->user()->firstname;
        $testimoni->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Kontent Manajemen Website";
        $audit->description = "Tambah Testimoni Pendana";
        $audit->ip_address =  \Request::ip();
        $audit->save();
        
        return redirect()->back()->with('success', 'Tambah Testimoni Pendana Berhasil');
    }

    private function upload_foto_pendana($column, Request $request)
    {
        if ($request->hasFile($column)) {
            $file = $request->file($column);
            $filename = Carbon::now()->toDateString() . $request->foto_pendana->getClientOriginalName();
            $store_path = 'pendana';
            $path = $file->storeAs($store_path, $filename, 'public');
            // save gambar yang di upload di public storage
            return $path;
        }
        else {
            return null;
        }
    }

    public function datatables_testimoni()
    {
        $testimoni = TestimoniPendana::where('type',1)->get();
        
        $response = ['data' => $testimoni];

        return response()->json($response);
    }

    public function admin_update_testimoni(Request $request){
        
        $testimoni = TestimoniPendana::where('id',$request->id)->first();
        // echo $request->edit_tipe;die;

        $testimoni->nama = $request->edit_nama;
        $testimoni->content = $request->edit_content;
        $testimoni->link = $request->edit_link;
        if ($request->hasFile('foto_pendana')) {
            Storage::disk('public')->delete($testimoni->gambar);
            $testimoni->gambar = $this->upload_foto_pendana('foto_pendana', $request);

            $testimoni->save();
        }
        $testimoni->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Kontent Manajemen Website";
        $audit->description = "Edit Testimoni Pendana";
        $audit->ip_address =  \Request::ip();
        $audit->save();
        
        return redirect()->back()->with('updated', "Ubah Testimoni Berhasil");

    }

    public function admin_delete_testimoni($id){
        
        $testimoni = TestimoniPendana::where('id',$id)->first();

        $testimoni_delete = TestimoniPendana::where('id',$id)->delete();

        if ($testimoni_delete)
        {
            $response = ['status' => 'Sukses'];
        }

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Kontent Manajemen Website";
        $audit->description = "Hapus Testimoni Pendana";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return response()->json($response);

    }

    public function admin_add_media_online(Request $request) {

        $media = new TestimoniPendana;
        $media->gambar = $this->upload_media_online('gambar', $request);
        $media->type = 2;
        $media->author = Auth::guard('admin')->user()->firstname;
        $media->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Kontent Manajemen Website";
        $audit->description = "Tambah Media Online";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('success', 'Tambah Media Online Berhasil');
    }

    private function upload_media_online($column, Request $request)
    {
        if ($request->hasFile($column)) {
            $file = $request->file($column);
            $filename = Carbon::now()->toDateString() . $request->gambar->getClientOriginalName();
            $store_path = 'media';
            $path = $file->storeAs($store_path, $filename, 'public');
            return $path;
        }
        else {
            return null;
        }

    }

    public function datatables_media_online()
    {
        $media = DB::table('cms')->where('type',2)->get();
        
        $response = ['data' => $media];

        return response()->json($response);
    }

    public function admin_update_media_online(Request $request){
        
        $media = TestimoniPendana::where('id',$request->id)->first();
        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($media->gambar);
            $media->gambar = $this->upload_media_online('gambar', $request);

            $media->save();
        }

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Kontent Manajemen Website";
        $audit->description = "Edit Media Online";
        $audit->ip_address =  \Request::ip();
        $audit->save();


        return redirect()->back()->with('updated', "Ubah Media Online Berhasil");

    }

    public function admin_delete_media_online($id){
        
        $media = TestimoniPendana::where('id',$id)->first();

        $media_delete = TestimoniPendana::where('id',$id)->delete();

        if ($media_delete)
        {
            $response = ['status' => 'Sukses'];
        }

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Kontent Manajemen Website";
        $audit->description = "Hapus Media Online";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return response()->json($response);

    }

    public function admin_add_company(Request $request)
    {
        
        $company = new TestimoniPendana;
        
        $company->nama = $request->nama_perusahaan;
        $company->content = $request->deskripsi;
        $company->alamat = $request->alamat;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $count_whatsapp = implode('|', $request->whatsapp);
        $company->handphone .='|'.$count_whatsapp;
        $company->type = 3;
        $company->author = Auth::guard('admin')->user()->firstname;
        //echo"<pre>";print_r($company);"</pre>";die();
        $company->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Kontent Manajemen Website";
        $audit->description = "Tambah Informasi Perusahaan";
        $audit->ip_address =  \Request::ip();
        $audit->save();
        
        return redirect()->back()->with('success', 'Tambah Informasi Perusahaan Berhasil');
    }

    public function datatables_company()
    {
        $company = DB::table('cms')->where('type',3)->get();
        
        $response = ['data' => $company];

        return response()->json($response);
    }

    public function admin_delete_company($id)
    {
        
        $company = TestimoniPendana::where('id',$id)->first();

        $company_delete = TestimoniPendana::where('id',$id)->delete();

        if ($company_delete)
        {
            $response = ['status' => 'Sukses'];
        }

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Kontent Manajemen Website";
        $audit->description = "Hapus Informasi Perusahaan";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return response()->json($response);

    }

    public function admin_update_company(Request $request)
    {
        
        $company = TestimoniPendana::where('id',$request->id)->first();
        $company->nama = $request->edit_nama_perusahaan;
        $company->content = $request->edit_deskripsi;
        $company->alamat = $request->edit_alamat;
        $company->email = $request->edit_email;
        $company->phone = $request->edit_phone;
        $company->handphone = $request->edit_handphone;
        $company->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Kontent Manajemen Website";
        $audit->description = "Edit Informasi Perusahaan";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('updated', "Ubah Informasi Perusahaan Berhasil");

    }

    public function admin_add_disclaimer(Request $request)
    {

        $disclaimer = new TestimoniPendana;
        
        $disclaimer->content = $request->deskripsi;
        $disclaimer->type = 4;
        $disclaimer->author = Auth::guard('admin')->user()->firstname;;
        $disclaimer->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Kontent Manajemen Website";
        $audit->description = "Tambah Disclaimer";
        $audit->ip_address =  \Request::ip();
        $audit->save();
        
        return redirect()->back()->with('success', 'Tambah Disclaimer Berhasil');
    }

    public function datatables_disclaimer()
    {
        $disclaimer = DB::table('cms')->where('type',4)->get();
        
        $response = ['data' => $disclaimer];

        return response()->json($response);
    }

    public function admin_update_disclaimer(Request $request)
    {
        
        $disclaimer = TestimoniPendana::where('id',$request->id)->first();
        $disclaimer->content = $request->edit_deskripsi;
        $disclaimer->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Kontent Manajemen Website";
        $audit->description = "Edit Disclaimer";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('updated', "Ubah Disclaimer Berhasil");

    }

    public function admin_delete_disclaimer($id)
    {
        
        $disclaimer = TestimoniPendana::where('id',$id)->first();

        $disclaimer_delete = TestimoniPendana::where('id',$id)->delete();

        if ($disclaimer_delete)
        {
            $response = ['status' => 'Sukses'];
        }

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Kontent Manajemen Website";
        $audit->description = "Hapus Disclaimer";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return response()->json($response);

    }

    public function admin_add_term_condition(Request $request)
    {

        $term = new TestimoniPendana;
        $term->title = $request->title;
        $term->content = $request->deskripsi;
        $term->type = 5;
        
        $term->save();
        
        return redirect()->back()->with('success', 'Tambah Term & Condition Berhasil');
    }

    public function datatables_termcondition()
    {
        $term = DB::table('cms')->where('type',5)->get();
        
        $response = ['data' => $term];

        return response()->json($response);
    }

    public function admin_update_term_condition(Request $request)
    {
        
        $term = TestimoniPendana::where('id',$request->id)->first();
        $term->title = $request->edit_title;
        $term->content = $request->edit_deskripsi;
        $term->save();
        return redirect()->back()->with('updated', "Ubah Term & Condition Berhasil");

    }

    public function admin_delete_term_condition($id)
    {
        
        $term = TestimoniPendana::where('id',$id)->first();

        $term_delete = TestimoniPendana::where('id',$id)->delete();

        if ($term_delete)
        {
            $response = ['status' => 'Sukses'];
        }

        return response()->json($response);

    }

    public function VerifikasiPembayaran(){
        $client = new client();

        $response_getDataPendana = $client->request('GET', config('app.apilink')."/borrower/dataCair");
        $body_getDataPendana = json_decode($response_getDataPendana->getBody());
        $data = (array) $body_getDataPendana->data;
        // dd($body_getDataPendana);
        
        return view('pages.admin.verifikasipembayaran')->with('dataPendanaan', $data);;
    }

    // public function pendanaanVerifikasiPembayaran(){

    // }

    public function admin_add_privacy(Request $request) {

        $privacy = new TestimoniPendana;
        $privacy->title = $request->title;
        $privacy->file = $this->upload_kebijakan_privacy('file', $request);
        $privacy->type = 6;
        $privacy->publish = $request->publish;
        $privacy->author = Auth::guard('admin')->user()->firstname;
        //echo"<pre>";print_r($privacy);echo"</pre>";die();
        $privacy->save();

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Konten Manajemen Website";
        $audit->description = "Tambah Kebijakan Privacy";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('success', 'Tambah Kebijakan Privacy Berhasil');
    }

    public function datatables_privacy()
    {
        $privacy = DB::table('cms')->where('type',6)->get();
        
        $response = ['data' => $privacy];

        return response()->json($response);
    }

    private function upload_kebijakan_privacy($column, Request $request)
    {
        if ($request->hasFile($column)) {
            $file = $request->file($column);
            $filename = $request->file->getClientOriginalName();
            $store_path = 'footer';
            $path = $file->storeAs($store_path, $filename, 'public');
            return $path;
        }
        else {
            return null;
        }

    }

    public function admin_update_privacy(Request $request){
        
        $privacy = TestimoniPendana::where('id',$request->id)->first();
        $privacy->title = $request->title;
        $privacy->publish = $request->publish;
        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($privacy->file);
            $privacy->file = $this->upload_kebijakan_privacy('file', $request);

            $privacy->save();
        }
        $privacy->save();


        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Konten Manajemen Website";
        $audit->description = "Edit Kebijakan Privacy";
        $audit->ip_address =  \Request::ip();
        $audit->save();


        return redirect()->back()->with('updated', "Ubah Kebijakan Privacy Berhasil");

    }

    public function admin_delete_privacy($id){
        
        $privacy = TestimoniPendana::where('id',$id)->first();

        $privacy_delete = TestimoniPendana::where('id',$id)->delete();

        if ($privacy_delete)
        {
            $response = ['status' => 'Sukses'];
        }

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Konten Manajemen Website";
        $audit->description = "Hapus Kebijakan Privacy";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return response()->json($response);

    }

    public function admin_upload_dokumen(Request $request) {

        

        $a = count($request->dokumen);
        $author = Auth::guard('admin')->user()->firstname;
        $uploads = $this->upload_dokumen_brw('file', $request);
        
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Data Penerima Pendanaan";
        $audit->description = "Unggah Dokumen Penerima Pendanaan";
        $audit->ip_address =  \Request::ip();
        $audit->save();
        
        if ($uploads['status_code'] == "00") {
            return redirect()->back()->with('success', 'Unggah '.$uploads['num_uploaded_file'].' Dokumen Penerima Pendanaan Berhasil');
        } else {
            return redirect()->back()->with('success', 'Unggah Dokumen Penerima Pendanaan Gagal');
        }
    }


    private function upload_dokumen_brw($column, Request $request)
    {

        $cnt = 0;
        
        $return1 = array(
                            "status_code" => "00",
                            "status_message" => 'Upload File',
                            "num_uploaded_file" => $cnt

                        );
        
        if($request->hasFile(($column)))
        {

            $files = $request->file($column);
            $client = new DMSController();
            $id_brw = $request->brw_id[0];
            $author = Auth::guard('admin')->user()->firstname;
            $brw_type =  $request->brw_type;
             
            if($brw_type == 1)
            {
                /* METHODE UNTUK FOLDER */
                $client->createFolder("BORROWER","PERSONAL","WNI",$request->ktp);
                $client->createFolder("BORROWER","PERSONAL","WNI","$request->ktp/BRW_$id_brw");
                $client->createFolder("BORROWER","PERSONAL","WNI","$request->ktp/BRW_$id_brw/DOKUMEN");
                $jmlhFile = count($files);
            }
            elseif($brw_type == 2)
            {
                /* METHODE UNTUK FOLDER */
                $client->createFolder("BORROWER","CORPORATE","LOCAL",$request->ktp_bdn_hukum);
                $client->createFolder("BORROWER","CORPORATE","LOCAL","$request->ktp_bdn_hukum/BRW_$id_brw");
                $client->createFolder("BORROWER","CORPORATE","LOCAL","$request->ktp_bdn_hukum/BRW_$id_brw/DOKUMEN");
                $jmlhFile = count($files);
            }

            // foreach($files as $file)
            for($x=0;$x<$jmlhFile;$x++)
            {
                if ($brw_type == 1)
                {
                    $result_uploads = $client->uploadFile("BORROWER","PERSONAL","WNI","$request->ktp/BRW_$id_brw/DOKUMEN",$files[$x]->getClientOriginalName(),file_get_contents($files[$x]->path()));
                    $r = json_decode($result_uploads);
                }
                elseif($brw_type == 2)
                {
                    $result_uploads = $client->uploadFile("BORROWER","CORPORATE","LOCAL","$request->ktp_bdn_hukum/BRW_$id_brw/DOKUMEN",$files[$x]->getClientOriginalName(),file_get_contents($files[$x]->path()));
                    $r = json_decode($result_uploads);
                }
                
                
                if ($r->status_code == '00') {

                    $upload = new DokumenBorrower;
                    $upload->brw_id =  $request->brw_id[0];
                    $upload->jenis_dokumen =  $request->dokumen[$x];
                    $upload->nama_dokumen = $files[$x]->getClientOriginalName();
                    $upload->path_file =  $r->uuid;
                    $upload->author = $author;
                    //echo"<pre>";print_r($upload);echo"</pre>";die();
                    $upload->save();
                    $cnt++;
                    
                        $return1 = array(
                            "status_code" => "00",
                            "status_message" => 'Upload File',
                            "num_uploaded_file" => $cnt

                        );
                }
            }

            return $return1;
        }
        else
        {
            return null;
        }

    }

    public function datatables_list_dokumen($id)
    {
        
        
        $dokumen = DokumenBorrower::where('brw_id',$id)->get();
        $response = ['data' => $dokumen];

        return response()->json($response);
    }

    public function admin_get_dokumen($id)
    {
        $client = new DMSController();
        $response = json_decode($client->downloadFile($id));
        $content = $response->content;
        $content_decode = base64_decode($content);

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Data Penerima Pendanaan";
        $audit->description = "Download Dokumen Penerima Pendanaan";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        
        return response($content_decode)->header('Content-Type','application/pdf');
    }
    
    public function tarik_dana_investor(){
        return view('pages.admin.list_tarik_dana');
    }

    public function list_tarik_dana_investor(){ // admin/manage proyek mutasi				
        
        // $list_proyek = Proyek::whereIn('status', [2,3])->orderBy('tgl_selesai_penggalangan', 'desc')->get();

        $list_proyek = Proyek::select('proyek.id', 'proyek.nama', 'proyek.total_need', 'proyek.tgl_mulai_penggalangan', 'proyek.tgl_selesai_penggalangan', 'proyek.status')
        ->join('brw_pendanaan', 'brw_pendanaan.id_proyek', '=', 'proyek.id')
        ->whereIn('proyek.status', [2,3])
        ->where('brw_pendanaan.status_dana', 0)
        ->orderBy('tgl_selesai_penggalangan', 'desc')->get();
        

		$data = array();
		$no = 1;
		if(!empty($list_proyek)){
			foreach($list_proyek as $row){
                if($row->status == 3){
                    $status_proyek = 'Pendanaan Terpenuhi';
                }else{
                    $status_proyek = 'Penggalangan Selesai';
                }

				$column['ID Proyek'] 			        = $row->id;
				$column['Nama Proyek'] 			        = (string)$row->nama;
                $column['Total Dibutuhkan'] 	        = number_format($row->total_need);
                $column['Tanggal Mulai Penggalangan'] 	= $row->tgl_mulai_penggalangan;
                $column['Tanggal Selesai Penggalangan'] = $row->tgl_selesai_penggalangan;
                $column['Status Proyek'] 	            = $status_proyek;
                $column['Detil Tarik Dana'] 			= $row->id;
				
				$data[] = $column;
			}
        }
        
		$parsingJSON = array(
						"data" => $data
		);
		echo json_encode($parsingJSON);
		
    }
    
    public function list_detail_investor($id_proyek){ 
        
		$detail_investor = DB::table('pendanaan_aktif as a')
		->selectRaw('a.investor_id, a.proyek_id, SUM(a.total_dana) as total_investasi, b.nama_investor, c.email')
        ->join('detil_investor AS b', 'a.investor_id', '=', 'b.investor_id')
        ->join('investor AS c', 'c.id', '=', 'a.investor_id')
		->where('proyek_id','=',$id_proyek)
        ->groupBy('investor_id')
        ->get();

		$data = array();
		$no = 1;
		if(!empty($detail_investor)){
			foreach($detail_investor as $row){
				//var_dump();
                $column['Proyek_id']                = (string)$row->proyek_id;
                $column['Investor_id']              = (string)$row->investor_id;
                $column['Nama Investor Pendana'] 	= (string)$row->nama_investor;
                $column['Email Pendana'] 	        = (string)$row->email;
				$column['Total Pendanaan']      	= (string)number_format($row->total_investasi);
				
				$data[] = $column;
				
			}
		}
		$parsingJSON = array(
						"data" => $data
		);
		
		echo json_encode($parsingJSON);
    }

    public function tarik_dana(Request $request, $id)
    {
        $client = new RDLController();

        $detail_investor = DB::table('pendanaan_aktif as a')
		->selectRaw('a.investor_id, a.proyek_id, SUM(a.total_dana) as total_investasi, b.nama_investor, c.va_number, d.account_number')
        ->join('detil_investor AS b', 'a.investor_id', '=', 'b.investor_id')
        ->join('rekening_investor AS c', 'c.investor_id', '=', 'a.investor_id')
        ->join('rdl_acount_number AS d', 'd.investor_id', '=', 'a.investor_id')
		->where('proyek_id','=',$id)
        ->groupBy('investor_id')
        ->get();

        $berita_transfer = 'Penarikan dana Pendana Proyek '.$id;
        
        for($i = 0;$i<sizeof($detail_investor);$i++)
        {
            $withdraw_investor = $client->ExecuteTransferTransactionOverbooking((string)$detail_investor[$i]->account_number, (string)'009', (string)$detail_investor[$i]->va_number, (string)number_format($detail_investor[$i]->total_investasi,0,'',''), (string)$berita_transfer);
        }

        // $withdraw_investor = $client->ExecuteTransferTransactionOverbooking((string)$detail_investor[0]->account_number, (string)'009', (string)$detail_investor[0]->va_number, (string)number_format($detail_investor[0]->total_investasi,0,'',''), (string)$berita_transfer);

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu= "Tarik Dana Pendana";
        $audit->description = "Tarik Dana Pendana ke VA Proyek ".$id;
        $audit->ip_address =  \Request::ip();
        $audit->save();

        $pendanaan = BorrowerPendanaan::where('id_proyek',$id)->first();  
		$pendanaan->status_dana = 2; 
		$pendanaan->update();

        return redirect()->back()->with('success', 'Tarik Dana Berhasil');
        // $response = [
        //     'status' => 'Sukses'
        // ];
        // return response()->json($response);
    }

    public function transfer_dana_pendana(){
        return view('pages.admin.list_transfer_dana');
    }

    public function list_transfer_dana_investor(){ // admin/manage proyek mutasi				
        
        $list_proyek = Proyek::where('status', 4)->orderBy('tgl_selesai_penggalangan', 'desc')
        ->whereNotIn('proyek.id',[\DB::raw('select proyek_id from log_pengembalian_dana group by proyek_id')])
        ->get();
        

		$data = array();
		$no = 1;
		if(!empty($list_proyek)){
			foreach($list_proyek as $row){
                $status_proyek = 'Proyek Selesai';

				$column['ID Proyek'] 			        = $row->id;
				$column['Nama Proyek'] 			        = (string)$row->nama;
                $column['Total Dibutuhkan'] 	        = number_format($row->total_need);
                $column['Tanggal Mulai Penggalangan'] 	= $row->tgl_mulai_penggalangan;
                $column['Tanggal Selesai Penggalangan'] = $row->tgl_selesai_penggalangan;
                $column['Status Proyek'] 	            = $status_proyek;
                $column['Detil Tarik Dana'] 			= $row->id;
				
				$data[] = $column;
			}
        }
        
		$parsingJSON = array(
						"data" => $data
		);
		echo json_encode($parsingJSON);
		
    }
    
    public function list_detail_transfer_investor($id_proyek){ 
        
		$detail_investor = DB::table('pendanaan_aktif as a')
		->selectRaw('a.investor_id, a.proyek_id, SUM(a.total_dana) as total_investasi, b.nama_investor, c.email')
        ->join('detil_investor AS b', 'a.investor_id', '=', 'b.investor_id')
        ->join('investor AS c', 'c.id', '=', 'a.investor_id')
		->where('proyek_id','=',$id_proyek)
        ->groupBy('investor_id')
        ->get();

		$data = array();
		$no = 1;
		if(!empty($detail_investor)){
			foreach($detail_investor as $row){
				//var_dump();
                $column['Proyek_id']                = (string)$row->proyek_id;
                $column['Investor_id']              = (string)$row->investor_id;
                $column['Nama Investor Pendana'] 	= (string)$row->nama_investor;
                $column['Email Pendana'] 	        = (string)$row->email;
				$column['Total Pendanaan']      	= (string)number_format($row->total_investasi);
				
				$data[] = $column;
				
			}
		}
		$parsingJSON = array(
						"data" => $data
		);
		
		echo json_encode($parsingJSON);
    }

    public function transfer_dana(Request $request, $id)
    {
        $client = new RDLController();
        $accno_src = config('app.bnik_main_account');

        $detail_investor = DB::table('pendanaan_aktif as a')
		->selectRaw('a.investor_id, a.proyek_id, SUM(a.total_dana) as total_investasi, b.nama_investor, c.va_number, d.account_number')
        ->join('detil_investor AS b', 'a.investor_id', '=', 'b.investor_id')
        ->join('rekening_investor AS c', 'c.investor_id', '=', 'a.investor_id')
        ->join('rdl_acount_number AS d', 'd.investor_id', '=', 'a.investor_id')
		->where('proyek_id','=',$id)
        ->groupBy('investor_id')
        ->get();

        $berita_transfer = 'Transfer dana ke Account Number Pendana Proyek '.$id;
        
        for($i = 0;$i<sizeof($detail_investor);$i++)
        {
            $withdraw_investor = $client->ExecuteTransferTransactionOverbooking((string)$accno_src,  (string)'009', (string)$detail_investor[$i]->account_number, (string)number_format($detail_investor[$i]->total_investasi,0,'',''), (string)$berita_transfer);
            
            $log_pengembalian_dana = new LogPengembalianDana;
            $log_pengembalian_dana->proyek_id = $id;
            $log_pengembalian_dana->investor_id = $detail_investor[$i]->investor_id;
            $log_pengembalian_dana->nominal = $detail_investor[$i]->total_investasi;
            $log_pengembalian_dana->save();
            
            $update_rekening = RekeningInvestor::where('investor_id',$detail_investor[$i]->investor_id)->first();
            $update_rekening->unallocated += $detail_investor[$i]->total_investasi;
            $update_rekening->update();
        }

        // $withdraw_investor = $client->ExecuteTransferTransactionOverbooking((string)$detail_investor[0]->account_number, (string)'009', (string)$detail_investor[0]->va_number, (string)number_format($detail_investor[0]->total_investasi,0,'',''), (string)$berita_transfer);

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu= "Transfer Dana Pendana";
        $audit->description = "Transfer dana ke Account Number Pendana Proyek ".$id;
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('success', 'Transfer Dana Berhasil');
        // $response = [
        //     'status' => 'Sukses'
        // ];
        // return response()->json($response);
    }

    public function admin_upload_dokumen_scoring_pendanaan(Request $request) {

        
        $author = Auth::guard('admin')->user()->firstname;
        $uploads = $this->upload_dokumen_scoring_pendanaan('file', $request);

        
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Penilaian Penerima Pendanaan";
        $audit->description = "Unggah Dokumen Penilaian Pendanaan Penerima Pendana";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        if ($uploads['status_code'] == "00") {
            return redirect()->back()->with('success', 'Unggah Dokumen Penilaian Pendanaan Berhasil');
        } else {
            return redirect()->back()->with('success', 'Unggah Dokumen Penilaian Pendanaan Gagal');
        }
    }


    private function upload_dokumen_scoring_pendanaan($column, Request $request)
    {
        $return1 = array(
            "status_code" => "00",
            "status_message" => 'Upload File'
           
        );

        if($request->hasFile(($column)))
        {
           
            $client = new DMSController();
            $file = $request->file($column);
            $author = Auth::guard('admin')->user()->firstname;
            $brw_type = $request->brw_type;
            if($brw_type == 1)
            {
                /* METHODE UNTUK CREATE FOLDER */
                $client->createFolder("BORROWER","PERSONAL","WNI",$request->ktp);
                $client->createFolder("BORROWER","PERSONAL","WNI","$request->ktp/BRW_$request->brw_id");
                $client->createFolder("BORROWER","PERSONAL","WNI","$request->ktp/BRW_$request->brw_id/SCORING_PENDANAAN_$request->pendanaan_id");
                
                $upload = $client->uploadFile("BORROWER","PERSONAL","WNI","$request->ktp/BRW_$request->brw_id/SCORING_PENDANAAN_$request->pendanaan_id",$file->getClientOriginalName(),file_get_contents($file->path()));
                $r = json_decode($upload);
            }
            else
            {
                /* METHODE UNTUK CREATE FOLDER */
                $client->createFolder("BORROWER","CORPORATE","LOCAL",$request->ktp);
                $client->createFolder("BORROWER","CORPORATE","LOCAL","$request->ktp/BRW_$request->brw_id");
                $client->createFolder("BORROWER","CORPORATE","LOCAL","$request->ktp/BRW_$request->brw_id/SCORING_PENDANAAN_$request->pendanaan_id");
                
                $upload = $client->uploadFile("BORROWER","CORPORATE","LOCAL","$request->ktp/BRW_$request->brw_id/SCORING_PENDANAAN_$request->pendanaan_id",$file->getClientOriginalName(),file_get_contents($file->path()));
                $r = json_decode($upload);
            }

            if ($r->status_code == '00') {

                $upload = new DokumenBorrower;
                $upload->brw_id =  $request->brw_id;
                $upload->pendanaan_id =  $request->pendanaan_id;
                $upload->scoring_type =  2;
                $upload->jenis_dokumen =  $request->nama_dokumen;
                $upload->nama_dokumen = $file->getClientOriginalName();
                $upload->path_file =  $r->uuid;
                $upload->author = $author;
                $upload->save();
                
                    $return1 = array(
                        "status_code" => "00",
                        "status_message" => 'Upload File'

                    );
            }

            return $return1;
        }
        else 
        {
            return null;
        }
    }

    public function admin_get_dokumen_scoring($id)
    {
        $check_file_scoring = DB::table('brw_dokumen as a')
		->selectRaw('a.brw_id, a.pendanaan_id, a.path_file')
        ->where('pendanaan_id','=',$id)
        ->where('scoring_type','=',2)
        ->count();

        if($check_file_scoring > 0)
        {
            $file_scoring = DB::table('brw_dokumen as a')
            ->selectRaw('a.brw_id, a.pendanaan_id, a.path_file')
            ->where('pendanaan_id','=',$id)
            ->where('scoring_type','=',2)
            ->get();

            $scoring_file = $file_scoring[0]->path_file;

            $client = new DMSController();
            $response = json_decode($client->downloadFile($scoring_file));
            $content = $response->content;
            $content_decode = base64_decode($content);

            $audit = new AuditTrail;
            $username = Auth::guard('admin')->user()->firstname;
            $audit->fullname = $username;
            $audit->menu = "Penilaian Penerima Pendanaan";
            $audit->description = "Unduh Dokumen Penilaian Pendanaan Penerima Pendana";
            $audit->ip_address =  \Request::ip();
            $audit->save();

            return response($content_decode)->header('Content-Type','application/pdf');
        }
        else{
            return redirect()->back()->with('error', 'Maaf, tidak ada data yang tersedia. Silahkan anda unggah kembali');
        }
        
    }

    public function admin_upload_dokumen_scoring_personal(Request $request) {

        
        $author = Auth::guard('admin')->user()->firstname;
        //$uploads = json_decode($this->upload_dokumen_scoring_personal('file', $request));
        //$result_uploads = $uploads->uuid;
        $uploads = $this->upload_dokumen_scoring_personal('file', $request);
      
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Penilaian Penerima Pendanaan";
        $audit->description = "Unggah Dokumen Penilaian Personal Penerima Pendana";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        //return redirect()->back()->with('success', 'Unggah Dokumen Penilaian Personal Berhasil');
        if ($uploads['status_code'] == "00") {
            return redirect()->back()->with('success', 'Unggah Dokumen Penilaian Personal Berhasil');
        } else {
            return redirect()->back()->with('success', 'Unggah Dokumen Penilaian Personal Gagal');
        }
    }

    private function upload_dokumen_scoring_personal($column, Request $request)
    {
        $return1 = array(
            "status_code" => "00",
            "status_message" => 'Upload File'

        );

        if($request->hasFile(($column)))
        {
           
            $client = new DMSController();
            $file = $request->file($column);
            $author = Auth::guard('admin')->user()->firstname;
            $brw_type = $request->brw_type;

            if($brw_type == 1)
            {

                /* METHODE UNTUK CREATE FOLDER */
                $client->createFolder("BORROWER","PERSONAL","WNI",$request->ktp);
                $client->createFolder("BORROWER","PERSONAL","WNI","$request->ktp/BRW_$request->brw_id");
                $client->createFolder("BORROWER","PERSONAL","WNI","$request->ktp/BRW_$request->brw_id/SCORING_PERSONAL_$request->pendanaan_id");
                
                $upload = $client->uploadFile("BORROWER","PERSONAL","WNI","$request->ktp/BRW_$request->brw_id/SCORING_PERSONAL_$request->pendanaan_id",$file->getClientOriginalName(),file_get_contents($file->path()));
                $r = json_decode($upload);
            }
            else
            {
                /* METHODE UNTUK CREATE FOLDER */
                $client->createFolder("BORROWER","CORPORATE","LOCAL",$request->ktp);
                $client->createFolder("BORROWER","CORPORATE","LOCAL","$request->ktp/BRW_$request->brw_id");
                $client->createFolder("BORROWER","CORPORATE","LOCAL","$request->ktp/BRW_$request->brw_id/SCORING_PERSONAL_$request->pendanaan_id");
                
                $upload = $client->uploadFile("BORROWER","CORPORATE","LOCAL","$request->ktp/BRW_$request->brw_id/SCORING_PERSONAL_$request->pendanaan_id",$file->getClientOriginalName(),file_get_contents($file->path()));
                $r = json_decode($upload);
            }

            if ($r->status_code == '00') {

                $upload = new DokumenBorrower;
                $upload->brw_id =  $request->brw_id;
                $upload->pendanaan_id =  $request->pendanaan_id;
                $upload->scoring_type =  1;
                $upload->jenis_dokumen =  $request->nama_dokumen;
                $upload->nama_dokumen = $file->getClientOriginalName();
                $upload->path_file =  $r->uuid;
                $upload->author = $author;
                $upload->save();
                
                $return1 = array(
                    "status_code" => "00",
                    "status_message" => 'Upload File'

                );
            }

            return $return1;
        }
        else 
        {
            return null;
        }
    }

    public function admin_get_dokumen_scoring_personal($id)
    {
        $check_file_scoring = DB::table('brw_dokumen as a')
		->selectRaw('a.brw_id, a.pendanaan_id, a.path_file')
        ->where('pendanaan_id','=',$id)
        ->where('scoring_type','=',1)
        ->count();

        if($check_file_scoring > 0)
        {
            $file_scoring = DB::table('brw_dokumen as a')
            ->selectRaw('a.brw_id, a.pendanaan_id, a.path_file')
            ->where('pendanaan_id','=',$id)
            ->where('scoring_type','=',1)
            ->get();

            $scoring_file = $file_scoring[0]->path_file;

            $client = new DMSController();
            $response = json_decode($client->downloadFile($scoring_file));
            $content = $response->content;
            $content_decode = base64_decode($content);

            $audit = new AuditTrail;
            $username = Auth::guard('admin')->user()->firstname;
            $audit->fullname = $username;
            $audit->menu = "Penilaian Penerima Pendanaan";
            $audit->description = "Unduh Dokumen Penilaian Personal Penerima Pendana";
            $audit->ip_address =  \Request::ip();
            $audit->save();

            return response($content_decode)->header('Content-Type','application/pdf');
        }
        else{
            return redirect()->back()->with('error', 'Maaf, tidak ada data yang tersedia. Silahkan anda unggah kembali');
        }
        
    }
	
	public function show_menu_RDLBank_transaction()
    {
        return view('pages.admin.LogBankRDLTransaction');
    }

    public function datatables_RDLBank_transaction()
    {
        $log = LogBankRDLTransaction::all();

        $data = array();
		$no = 1;
		if(!empty($log)){
			foreach($log as $row){

				$column['id'] 			        = (string)$row->id;
				$column['bank_rdl_code'] 	    = (string)$row->bank_rdl_code;
                $column['category'] 	        = (string)$row->category;
                $column['request_content'] 	    = (string)$row->request_content;
                $column['request_response']     = (string)$row->request_response;
                $column['nominal_transaction'] 	= (string)$row->nominal_transaction;
                $column['status'] 			    = (string)$row->status;
                $column['bank_reference'] 	    = (string)$row->bank_reference;
                $column['created_at'] 			= (string)$row->created_at;
				
				$data[] = $column;
			}
        }
        
		$parsingJSON = array(
						"data" => $data
		);
		echo json_encode($parsingJSON);
    }

    

    

}
