<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\CheckUserSign;
use App\Investor;
use App\DetilInvestor;
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
use App\RekeningInvestor;
use App\PendanaanAktif;
use App\Proyek;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\LogAkadDigiSignInvestor;
use App\MasterNoAkadInvestor;
use Illuminate\Support\Facades\Storage;
use App\MasterNoAkadBorrower;
use App\BorrowerJaminan;
use App\MasterJenisJaminan;
use App\Borrower;
use App\BorrowerDetails;
use App\BorrowerPendanaan;
use App\BorrowerTipePendanaan;
use App\BorrowerRekening;
use App\LogAkadDigiSignBorrower;
use App\Http\Controllers\RekeningController;
use App\TmpSelectedProyek;
use App\AhliWarisInvestor;
use App\MasterNoSP3;
use App\LogSP3Borrower;
// use App\LogDigiSignResponse;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007\Element\Section;
use Terbilang;


class DigiSignController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // public function __construct()
    // {
        // //
    // }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    //API Redirect
    private function decryptDigiSign($data, $key)
    {
        $output = false;
            $output = openssl_decrypt(base64_decode($data), 'aes-128-ecb', $key, OPENSSL_PKCS1_PADDING);
        return $output;

    }

    public function callbackRegisterInvestor(Request $req)
    {
        $getDataTableInvestor = CheckUserSign::where('investor_id',$req->user_id)
                                    ->where('provider_id',$req->provider_id)
                                    ->first();

        $cekUser = $getDataTableInvestor;

        if ($cekUser === NULL || $req->step == 'register')
        {
            $checkUserSignInvestor = new CheckUserSign;
            $checkUserSignInvestor->investor_id = $req->user_id;
            $checkUserSignInvestor->provider_id = $req->provider_id;
            $checkUserSignInvestor->status = $req->status;
            $checkUserSignInvestor->link_aktifasi = $req->url;
            $checkUserSignInvestor->tgl_register = date("Y-m-d");
            $checkUserSignInvestor->tgl_aktifasi = NULL;

            $checkUserSignInvestor->save();

            $response = ['status' => 'Data Berhasil di Update'];
            
        }
        else
        {

            $response = ['status' => 'Data Gagal di Update'];
            
        }
        return $response;
    }

    public function callbackRegisterBorrower(Request $req)
    {
        
        $getDataTableBorrower = CheckUserSign::where('brw_id',$req->brw_id)
                                    ->where('provider_id',$req->provider_id)
                                    ->first();

        $cekBrw = $getDataTableBorrower;

        if($cekBrw === NULL || $req->step == 'register')
        {
            $checkUserSignBorrower = new CheckUserSign;
            $checkUserSignBorrower->brw_id = $req->brw_id;
            $checkUserSignBorrower->provider_id = $req->provider_id;
            $checkUserSignBorrower->status = $req->status;
            $checkUserSignBorrower->link_aktifasi = $req->url;
            $checkUserSignBorrower->tgl_register = date("Y-m-d");
            $checkUserSignBorrower->tgl_aktifasi = NULL;

            $checkUserSignBorrower->save();

            $response = ['status' => 'Data Berhasil di Update'];
        }
        else
        {

            $response = ['status' => 'Data Gagal di Update'];
        }
        return $response;
    }

    public function redirectDigisignAktifasi(Request $req)
    {
        $msg = $req->msg;
        $key = '66ORCTCQBliLJaCa';
//syslog(0,"msg=".$msg);
        $cobaDecrypt = $this->decryptDigiSign($msg,$key);
        $dataArray = json_decode($cobaDecrypt,true);
//syslog(0,"array = ".$cobaDecrypt);
        $result = $dataArray['result'];
        $email = $dataArray['email_user'];
        $status = $dataArray['notif'];
        if ($result == '00')
        {
            $getIdInvestor = Investor::where('email',$email)->first();

            if (!empty($getIdInvestor->id))
            {
                $checkUserSignInvestor = CheckUserSign::where('investor_id', $getIdInvestor->id)
                                                    ->where('provider_id',1)
                                                    ->first();

                $checkUserSignInvestor->status = $status;
                $checkUserSignInvestor->tgl_aktifasi = date("Y-m-d");

                $checkUserSignInvestor->save();

                $response = 'Sukses';
            }
            else
            {
                $getIdBorrower = Borrower::where('email',$email)->first();

                if (!empty($getIdBorrower->brw_id))
                {
                    $checkUserSignBorrower = CheckUserSign::where('brw_id', $getIdBorrower->brw_id)
                                                        ->where('provider_id',1)
                                                        ->first();

                    $checkUserSignBorrower->status = $status;
                    $checkUserSignBorrower->tgl_aktifasi = date("Y-m-d");

                    $checkUserSignBorrower->save();

                    $response = 'Sukses';
                }
                else
                {
                    $response = 'Gagal';
                }
            }
        }
        else
        {
            $response = 'Gagal';
        }

        return $response;
    }

    private function logAkadDigiSignInvestor($user_id,$proyek_id,$provider_id,$total_aset,$status,$doc_id)
    {       
        if ($user_id)
        {
            $cekLog = LogAkadDigiSignInvestor::where('document_id',$doc_id)->count();
            if ($cekLog != 0)
            {
                $dataLog = LogAkadDigiSignInvestor::where('document_id',$doc_id)->first();
                
                $dataLog->status = $status;
                $dataLog->tgl_sign = date("Y-m-d");

                $dataLog->save();
            }
            else
            {
                $logAkadDigiSign = new LogAkadDigiSignInvestor;
                $logAkadDigiSign->investor_id = $user_id;
                $logAkadDigiSign->proyek_id = $proyek_id;
                $logAkadDigiSign->provider_id = $provider_id;
                $logAkadDigiSign->total_aset = $total_aset;
                $logAkadDigiSign->document_id = $doc_id;
                $logAkadDigiSign->status = $status;
                $logAkadDigiSign->tgl_sign = date("Y-m-d");

                $logAkadDigiSign->save();
            }

            $response = ['status' => 'Data Berhasil di Update'];
        }
        else
        {

            $response = ['status' => 'Data Gagal di Update'];
        }
        return $response;
    }

    private function logAkadDigiSignInvestorNonDigital($user_id,$proyek_id,$provider_id,$total_aset,$status,$doc_id)
    {       
        if ($user_id)
        {
            
                $logAkadDigiSign = new LogAkadDigiSignInvestor;
                $logAkadDigiSign->investor_id = $user_id;
                $logAkadDigiSign->proyek_id = $proyek_id;
                $logAkadDigiSign->provider_id = $provider_id;
                $logAkadDigiSign->total_aset = $total_aset;
                $logAkadDigiSign->document_id = $doc_id;
                $logAkadDigiSign->status = $status;
                $logAkadDigiSign->tgl_sign = date("Y-m-d");

                $logAkadDigiSign->save();

            $response = ['status' => 'Data Berhasil di Update'];
        }
        else
        {

            $response = ['status' => 'Data Gagal di Update'];
        }
        return $response;
    }

    private function logAkadDigiSignBorrower($user_id,$investor_id,$proyek_id,$provider_id,$total_pendanaan,$status,$doc_id)
    {       
        if ($user_id)
        {
            $cekLog = LogAkadDigiSignBorrower::where('document_id',$doc_id)->count();
            if ($cekLog != 0)
            {
                $dataLog = LogAkadDigiSignBorrower::where('document_id',$doc_id)->first();
                
                $dataLog->status = $status;
                $dataLog->tgl_sign = date("Y-m-d");

                $dataLog->save();
            }
            else
            {
                $logAkadDigiSign = new LogAkadDigiSignBorrower;
                $logAkadDigiSign->brw_id = $user_id;
                $logAkadDigiSign->investor_id = $investor_id;
                $logAkadDigiSign->id_proyek = $proyek_id;
                $logAkadDigiSign->provider_id = $provider_id;
                $logAkadDigiSign->total_pendanaan = $total_pendanaan;
                $logAkadDigiSign->document_id = $doc_id;
                $logAkadDigiSign->status = $status;
                $logAkadDigiSign->tgl_sign = date("Y-m-d");

                $logAkadDigiSign->save();
            }

            $response = ['status' => 'Data Berhasil di Update'];
        }
        else
        {

            $response = ['status' => 'Data Gagal di Update'];
        }
        return $response;
    }

    public function redirectDigisignSign(Request $req)
    {
        $msg = $req->msg;
        $key = '66ORCTCQBliLJaCa';

//syslog(0,"msg redirectDigisignSign=".$msg);

        $cobaDecrypt = $this->decryptDigiSign($msg,$key);

//syslog(0,"array = ".$cobaDecrypt);

        $dataArray = json_decode($cobaDecrypt,true);
        $result = $dataArray['result'];
        $email = $dataArray['email_user'];
        $status_doc = $dataArray['status_document'];
        $doc_id = $dataArray['document_id'];

        if ($result == '00')
        {
            $splitDoc = explode('_', $doc_id);
            $labelDoc = $splitDoc[0];
            if ($labelDoc == 'investorKontrak')
            {
                
                $logAkadDigiSign = LogAkadDigiSignInvestor::where('document_id',$doc_id)->first();
                $logAkadDigiSign->status = $status_doc;

                $logAkadDigiSign->save();

                $response = 'Sukses';

            }
            elseif ($labelDoc == 'borrowerKontrak')
            {
                
                $logAkadDigiSign = LogAkadDigiSignBorrower::where('document_id',$doc_id)->first();
                $logAkadDigiSign->status = $status_doc;

                $logAkadDigiSign->save();

                $response = 'Sukses';
                
            }
            elseif ($labelDoc == 'kontrakAll')
            {
                
                $logAkadDigiSignBorrower = LogAkadDigiSignBorrower::where('document_id',$doc_id)->first();
                $logAkadDigiSignBorrower->status = $status_doc;

                $logAkadDigiSignBorrower->save();

                $logAkadDigiSignInvestor = LogAkadDigiSignInvestor::where('document_id',$doc_id)->first();
                $logAkadDigiSignInvestor->status = $status_doc;

                $logAkadDigiSignInvestor->save();

                    
                    /************************* REQUEST OJK ************************/
                    // $rekeningController = new RekeningController;
        
     //                $getIdInvestor = Investor::where('email',$email)->first();
                    
     //                $getDataGenerateVA = TmpSelectedProyek::where('investor_id', $getIdInvestor->id)->orderBy('id', 'desc')->first();
     //                $return_generate_va = $rekeningController->generateVA_new($getIdInvestor->username, $getDataGenerateVA->proyek_id, $getDataGenerateVA->total_price);
                    
     //                if($return_generate_va){
     //                    $getDataGenerateVA = TmpSelectedProyek::where('investor_id', $getIdInvestor->id)->orderBy('id', 'desc')->first();
     //                    $response = 'Sukses, Silahkan melakukan pembayaran ke No. VA '.$getDataGenerateVA->no_va;
     //                }else{
     //                    $response = 'Gagal, gagal generate No VA';
     //                }
                    
                    
                    $response = 'Sukses';
            }
            else
            {
                $response = 'Gagal';
            }
            
        }
        else
        {
            $response = 'Gagal';
        }

        return $response;
    }

    private function logDigiSignResponse($email,$notif)
    {
        $emailUser = $email;
        $notifDigisign = $notif;

        $logDigiSignResponse = new LogDigiSignResponse;
        $logDigiSignResponse->email = $emailUser;
        $logDigiSignResponse->notif_digisign = $notifDigisign;

        $logDigiSignResponse->save();

    }





    //Aktivasi
    public function aktivasiDigiSign($email){
        $email = $email;

        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                                'userid' => config('app.userid'),
                                'email_user' => $email
                            ]
                    ];

        $jsonFile = json_encode($data_json);
    
        $multipart_form =   [
                                [
                                    'name' => 'jsonfield',
                                    'contents' => $jsonFile
                                ],
                            ];
        $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
        $cek = $client->post(config('app.api_digisign').'gen/genACTPage.html',[
                'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                'Authorization' => config('app.authorization').' '.config('app.token')
                            ],
                
                'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                'verify' => false
            ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        //var_dump($response_API);die;
    //$getResponse = json_decode($response_API['status_all'],true);
        //if (array_key_exists("JSONFile",$getResponse))
        //{
           //$getResponse2 = $getResponse['JSONFile'];
       //var_dump($getResponse2);die;
       //if (array_key_exists("JSONFile",$getResponse2))
           //{
             // $getNotif = $getResponse['JSONFile']['JSONFile']['notif'];
       //}
       //else
       //{
         //$getNotif = $getResponse['JSONFile']['notif'];
           //}
       //$getNotif = $getResponse['JSONFile']['notif'];
        //}
        //else
        //{
           //$getNotif = $getResponse['notif'];
        //}
        
        //$this->logDigiSignResponse($email,$getNotif);

        return response()->json($response_API);
        
    }




    //Investor
    private function cekUserSign($user_id,$provider_id)
    {
        $getDataTable = CheckUserSign::where('user_id',$user_id)
                                    ->where('provider_id',$provider_id)
                                    ->first();
        $dataExist = $getDataTable;
        if ($dataExist !== null)
        {
            $response = '00';
        }
        else
        {
            $response = '01';
        }

        return $response;
    }

    private function cekFotoDiriExist($userId)
    {
        $link1 = '../storage/app/public/user/'.$userId.'/*pic_investor.jpeg';
        $link2 = '../storage/app/public/user/'.$userId.'/*pic_investor.jpg';
        $link3 = '../storage/app/public/user/'.$userId.'/*pic_investor.bmp';
        $link4 = '../storage/app/public/user/'.$userId.'/*pic_investor.png';
        $link5 = '../storage/app/public/user/'.$userId.'/*pic_investor.JPG';
        $link6 = '../storage/app/public/user/'.$userId.'/*pic_investor.JPEG';

        $file1 = glob($link1);
        $file2 = glob($link2);
        $file3 = glob($link3);
        $file4 = glob($link4);
        $file5 = glob($link5);
        $file6 = glob($link6);

        $arrayFile1 = [];
        $arrayFile2 = [];
        $arrayFile3 = [];
        $arrayFile4 = [];
        $arrayFile5 = [];
        $arrayFile6 = [];

        foreach($file1 as $dataFile1)
        {
            $mod_date=date("Y-m-d", filemtime($dataFile1));
            $newLink1 = '../storage/app/public/user/'.$userId.'/'.$mod_date.'pic_investor.jpeg';
            array_push($arrayFile1, $newLink1);
        }

        foreach($file2 as $dataFile2)
        {
            $mod_date=date("Y-m-d", filemtime($dataFile2));
            $newLink2 = '../storage/app/public/user/'.$userId.'/'.$mod_date.'pic_investor.jpg';
            array_push($arrayFile2, $newLink2);
        }

        foreach($file3 as $dataFile3)
        {
            $mod_date=date("Y-m-d", filemtime($dataFile3));
            $newLink3 = '../storage/app/public/user/'.$userId.'/'.$mod_date.'pic_investor.bmp';
            array_push($arrayFile3, $newLink3);
        }

        foreach($file4 as $dataFile4)
        {
            $mod_date=date("Y-m-d", filemtime($dataFile4));
            $newLink4 = '../storage/app/public/user/'.$userId.'/'.$mod_date.'pic_investor.png';
            array_push($arrayFile4, $newLink4);
        }

        foreach($file5 as $dataFile5)
        {
            $mod_date=date("Y-m-d", filemtime($dataFile5));
            $newLink5 = '../storage/app/public/user/'.$userId.'/'.$mod_date.'pic_investor.JPG';
            array_push($arrayFile5, $newLink5);
        }

        foreach($file6 as $dataFile6)
        {
            $mod_date=date("Y-m-d", filemtime($dataFile6));
            $newLink6 = '../storage/app/public/user/'.$userId.'/'.$mod_date.'pic_investor.JPEG';
            array_push($arrayFile6, $newLink6);
        }


        if (count($arrayFile1) != 0)
        {
            $fotoDiriExist = fopen(end($arrayFile1), 'r');
        }
        elseif (count($arrayFile2) != 0)
        {
            $fotoDiriExist = fopen(end($arrayFile2), 'r');
        }
        elseif (count($arrayFile3) != 0)
        {
            $fotoDiriExist = fopen(end($arrayFile3), 'r');
        }
        elseif (count($arrayFile4) != 0)
        {
            $fotoDiriExist = fopen(end($arrayFile4), 'r');
        }
        elseif (count($arrayFile5) != 0)
        {
            $fotoDiriExist = fopen(end($arrayFile5), 'r');
        }
        elseif (count($arrayFile6) != 0)
        {
            $fotoDiriExist = fopen(end($arrayFile6), 'r');
        }
        else
        {
            $fotoDiriExist = NULL;
        }

        return $fotoDiriExist;
    }

    private function cekFotoKtpExist($userId)
    {
        $link1 = '../storage/app/public/user/'.$userId.'/*pic_ktp_investor.jpeg';
        $link2 = '../storage/app/public/user/'.$userId.'/*pic_ktp_investor.jpg';
        $link3 = '../storage/app/public/user/'.$userId.'/*pic_ktp_investor.bmp';
        $link4 = '../storage/app/public/user/'.$userId.'/*pic_ktp_investor.png';
        $link5 = '../storage/app/public/user/'.$userId.'/*pic_ktp_investor.JPG';
        $link6 = '../storage/app/public/user/'.$userId.'/*pic_ktp_investor.JPEG';

        $file1 = glob($link1);
        $file2 = glob($link2);
        $file3 = glob($link3);
        $file4 = glob($link4);
        $file5 = glob($link5);
        $file6 = glob($link6);

        $arrayFile1 = [];
        $arrayFile2 = [];
        $arrayFile3 = [];
        $arrayFile4 = [];
        $arrayFile5 = [];
        $arrayFile6 = [];

        foreach($file1 as $dataFile1)
        {
            $mod_date=date("Y-m-d", filemtime($dataFile1));
            $newLink1 = '../storage/app/public/user/'.$userId.'/'.$mod_date.'pic_ktp_investor.jpeg';
            array_push($arrayFile1, $newLink1);
        }

        foreach($file2 as $dataFile2)
        {
            $mod_date=date("Y-m-d", filemtime($dataFile2));
            $newLink2 = '../storage/app/public/user/'.$userId.'/'.$mod_date.'pic_ktp_investor.jpg';
            array_push($arrayFile2, $newLink2);
        }

        foreach($file3 as $dataFile3)
        {
            $mod_date=date("Y-m-d", filemtime($dataFile3));
            $newLink3 = '../storage/app/public/user/'.$userId.'/'.$mod_date.'pic_ktp_investor.bmp';
            array_push($arrayFile3, $newLink3);
        }

        foreach($file4 as $dataFile4)
        {
            $mod_date=date("Y-m-d", filemtime($dataFile4));
            $newLink4 = '../storage/app/public/user/'.$userId.'/'.$mod_date.'pic_ktp_investor.png';
            array_push($arrayFile4, $newLink4);
        }

        foreach($file5 as $dataFile5)
        {
            $mod_date=date("Y-m-d", filemtime($dataFile5));
            $newLink5 = '../storage/app/public/user/'.$userId.'/'.$mod_date.'pic_ktp_investor.JPG';
            array_push($arrayFile5, $newLink5);
        }

        foreach($file6 as $dataFile6)
        {
            $mod_date=date("Y-m-d", filemtime($dataFile6));
            $newLink6 = '../storage/app/public/user/'.$userId.'/'.$mod_date.'pic_ktp_investor.JPEG';
            array_push($arrayFile6, $newLink6);
        }


        if (count($arrayFile1) != 0)
        {
            $fotoKtpExist = fopen(end($arrayFile1), 'r');
        }
        elseif (count($arrayFile2) != 0)
        {
            $fotoKtpExist = fopen(end($arrayFile2), 'r');
        }
        elseif (count($arrayFile3) != 0)
        {
            $fotoKtpExist = fopen(end($arrayFile3), 'r');
        }
        elseif (count($arrayFile4) != 0)
        {
            $fotoKtpExist = fopen(end($arrayFile4), 'r');
        }
        elseif (count($arrayFile5) != 0)
        {
            $fotoKtpExist = fopen(end($arrayFile5), 'r');
        }
        elseif (count($arrayFile6) != 0)
        {
            $fotoKtpExist = fopen(end($arrayFile6), 'r');
        }
        else
        {
            $fotoKtpExist = NULL;
        }

        return $fotoKtpExist;
    }

    public function registerDigiSignInvestor($userID){
        
        $getDataInvestor = DetilInvestor::leftJoin('investor','investor.id','=','detil_investor.investor_id')->where('investor.id',$userID)->first();
        
        $dataJenisKelamin = MasterJenisKelamin::where('id_jenis_kelamin',$getDataInvestor->jenis_kelamin_investor)->first();

        $dataKotaProvinsi = MasterProvinsi::where('kode_kota',$getDataInvestor->kota_investor)->first();

        $dataTglLahir = explode('-',$getDataInvestor->tgl_lahir_investor);
        $tgl =  $dataTglLahir[0];
        $bln = $dataTglLahir[1];
        $thn = $dataTglLahir[2];
        if (strlen($tgl) == 1) {$tgl_new = '0'.$tgl;} else {$tgl_new = $tgl;}
        if (strlen($bln) == 1) {$bln_new = '0'.$bln;} else {$bln_new = $bln;}

        // $data_user = $getDataInvestor->investor_id;
        $data_provider = 1;

        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),
                            'alamat' => $getDataInvestor->alamat_investor,
                            'jenis_kelamin' => $dataJenisKelamin->jenis_kelamin,
                            'kecamatan' => $getDataInvestor->kecamatan !== NULL ? $getDataInvestor->kecamatan : '-',
                            'kelurahan' => $getDataInvestor->kecamatan !== NULL ? $getDataInvestor->kelurahan : '-',
                            'kode-pos' => $getDataInvestor->kode_pos_investor,
                            'kota' => $dataKotaProvinsi->nama_kota,
                            'nama' => $getDataInvestor->nama_investor,
                            'tlp' => $getDataInvestor->phone_investor,
                            'tgl_lahir' => $tgl_new.'-'.$bln_new.'-'.$thn,
                            'provinci' => $dataKotaProvinsi->nama_provinsi,
                            'idktp' => $getDataInvestor->no_ktp_investor,
                            'tmp_lahir' => $getDataInvestor->tempat_lahir_investor,
                            'email' => $getDataInvestor->email,
                            'npwp' => $getDataInvestor->no_npwp_investor,
                            'redirect' => true
                        ]
                    ];

        $jsonFile = json_encode($data_json);
        // echo $jsonFile;die;

        $fotoDiri = $this->cekFotoDiriExist($getDataInvestor->id);

        $fotoKtp = $this->cekFotoKtpExist($getDataInvestor->id);

        
        // Log::info('foto_KTP = '.$fotoKtp);
        // Log::info('foto_DIRI = '.$fotoDiri);        
        //echo $fotoDiri.'--'.$fotoKtp;die;
    
        $multipart_form =   [
                                [
                                    'name' => 'jsonfield',
                                    'contents' => $jsonFile
                                ],
                                [
                                    'name' => 'fotodiri',
                                    'contents' => $fotoDiri
                                ],
                                [
                                    'name' => 'fotoktp',
                                    'contents' => $fotoKtp
                                ],
                                [
                                    'name' => 'ttd',
                                    'contents' => NULL
                                ],
                                [
                                    'name' => 'fotonpwp',
                                    'contents' => NULL
                                ]  
                            ];
        $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
        $cek = $client->post(config('app.api_digisign').'REG-MITRA.html',[
                'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                'Authorization' => config('app.authorization').' '.config('app.token')
                            ],
                
                'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                'verify' => false
            ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];

        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($getDataInvestor->email,$getNotif);


        return response()->json($response_API);
        
    }
   
    // private function cekFilePDF()
    // {
    //     $link = '../storage/app/public/akad/AKAD_INV_498-20191119.pdf';
    //     $cekFile = glob($link);

    //     if (count($PDFDiri) != 0)
    //     {
    //         $existDocPDF = fopen($PDFDiri[0], 'r');
    //     }
         
    //     else
    //     {
    //         $existDocPDF = NULL;
    //     }

    //     return $existDocPDF;
    // }


    public function sendDigiSignInvestor($userId){
        
        $getDataInvestor = DetilInvestor::leftJoin('investor','investor.id','=','detil_investor.investor_id')
                                        ->where('investor.id',$userId)
                                        ->first();
        $getDataTaufiqSign = DetilInvestor::leftJoin('investor','investor.id','=','detil_investor.investor_id')
                                        ->where('investor.email',config('app.email_pak_taufiq'))
                                        ->first();
        $getTotalAset = RekeningInvestor::where('investor_id',$userId)->first();

        $date = Carbon::now()->format('Ymd');
        $idInvestor = $getDataInvestor->id;
        $totalAset = !empty($getTotalAset) ? $getTotalAset->total_dana : 0;
        $getJumlahDoc = LogAkadDigiSignInvestor::where('investor_id',$idInvestor)
                                        ->count();
        $jumlahDocNext = $getJumlahDoc+1;
        $document_id = 'investorKontrak_'.$date.'_'.$idInvestor.'_'.$jumlahDocNext;
        
        $page = 10;

        $startx = 80; 
        $starty = 560;
        $size_x = 75;
        $size_y = 50;

        $llx = $startx;
        $lly = $starty;
        $urx = $llx+$size_x;
        $ury = $lly+$size_y;

        $startx2 = 360; 
        $starty2 = 560;
        $size_x2 = 75;
        $size_y2 = 50;

        $llx2 = $startx2;
        $lly2 = $starty2;
        $urx2 = $llx2+$size_x2;
        $ury2 = $lly2+$size_y2;
                
        
        $client = new Client();
        $data_json = array();

        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' => $document_id,
                            'redirect' => true,
                            'branch' => 'KANTOR PUSAT',
                            'sequence_option' => false,
                            'send-to' => [
                                            [
                                                'name' => $getDataInvestor->nama_investor,
                                                'email' => $getDataInvestor->email
                                            ]
                            ],
                            'req-sign' => [
                                            [
                                                'name' => $getDataInvestor->nama_investor,
                                                'email' => $getDataInvestor->email,
                                                'aksi_ttd' => 'mt',
                                                'kuser' => '1234567890123456',
                                                'user' => 'ttd1',
                                                'llx' => $llx,
                                                'lly' => $lly,
                                                'urx' => $urx,
                                                'ury' => $ury,
                                                'page' => $page,
                                                'visible' => '1'
                                            ],
                                            [
                                                'name' => $getDataTaufiqSign->nama_investor,
                                                'email' =>config('app.email_pak_taufiq') ,
                                                'aksi_ttd' => 'at',
                                                'kuser' => '3jWyul25i5jwv4J5',
                                                'user' => 'ttd2',
                                                'llx' => $llx2,
                                                'lly' => $lly2,
                                                'urx' => $urx2,
                                                'ury' => $ury2,
                                                'page' => $page,
                                                'visible' => '1'
                                            ]
                            ],    
                            'payment' => '3',
                            'visible' => '1',
                            'signing_seq' => 0
                        ]
                    ];
            
        $jsonFile = json_encode($data_json);

        $this->createDocInvestor($userId);
      
        $docPDF = fopen('../storage/app/public/akad_investor/'.$userId.'/PERJANJIAN_PEMBIAYAAN_WAKALAH_BIL_UJRAH.pdf', 'r');
             
        $multipart_form =   [  
                                [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                                ],
                                [
                                   'name' => 'file',
                                   'contents' => $docPDF
                                ]
                            
             
                            ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'SendDocMitraAT.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($getDataInvestor->email,$getNotif);

        $this->logAkadDigiSignInvestor($idInvestor,0,1,$totalAset,'kirim',$document_id); 

        return response()->json($response_API);
    }
    
    public function signDigiSignInvestor($userId)
    {
        $getDataInvestor = DetilInvestor::leftJoin('investor','investor.id','=','detil_investor.investor_id')
                                        ->where('investor.id',$userId)
                                        ->first();
        $getDocId = LogAkadDigiSignInvestor::where('investor_id',$userId)
                                        ->where(\DB::raw('substr(document_id, 1, 15)'), '=' , 'investorKontrak')
                                        ->orderBy('id_log_akad_investor','desc')
                                        ->first();
        
        $date = Carbon::now()->format('Ymd');
        $idInvestor = $getDataInvestor->id;
        $document_id = $getDocId->document_id;
        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' =>$document_id,                                
                            'email_user' => $getDataInvestor->email,
                            'view_only' => false 
                             
                        ]
                    ];
        $jsonFile = json_encode($data_json);
        $multipart_form = [
                               [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                               ] 
             
         ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'gen/genSignPage.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($getDataInvestor->email,$getNotif);

        return response()->json($response_API);
    }

    public function downloadDigiSignInvestor(Request $req)
    {
        $getDocId = LogAkadDigiSignInvestor::where('investor_id',$req->id)->orderBy('id_log_akad_investor','desc')->first();
    //dd($getDocId);die;
        $doc_id = $getDocId->document_id;
        //echo $doc_id;die;
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' => $doc_id,                                
                        ]
                    ];
        $jsonFile = json_encode($data_json);
        $multipart_form = [
                               [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                               ] 
             
         ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'DWMITRA.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        //$response_API = ['status_all' => utf8_encode($cek->getBody()->getContents())];    

        //return response()->json($response_API);
        return response()->json(['FileContent' => base64_encode($cek->getBody()->getContents()), 'ContentType' => 'application/pdf']);;
    }

    public function downloadBase64DigiSignInvestor(Request $req)
    {
        $getDocId = LogAkadDigiSignInvestor::where('investor_id',$req->id)->orderBy('id_log_akad_investor','desc')->first();
        $getDataInvestor = Investor::where('id',$req->id)->first();
        $emailInvestor = $getDataInvestor->email;

        $doc_id = $getDocId->document_id;
        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' => $doc_id,                                
                        ]
                    ];
        $jsonFile = json_encode($data_json);
        $multipart_form = [
                               [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                               ] 
             
         ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'DWMITRA64.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($emailInvestor,$getNotif);   

        return response()->json($response_API);
    }

    public function downloadBase64DigiSignMurobahahInvestor(Request $req)
    {
        $getDocId = LogAkadDigiSignInvestor::where('proyek_id',$req->proyek_id)->orderBy('id_log_akad_investor','desc')->first();
        $getDataInvestor = Investor::where('id',$getDocId->investor_id)->first();
        $emailInvestor = $getDataInvestor->email;

        $doc_id = $getDocId->document_id;
        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' => $doc_id,                                
                        ]
                    ];
        $jsonFile = json_encode($data_json);
        $multipart_form = [
                               [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                               ] 
             
         ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'DWMITRA64.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($emailInvestor,$getNotif);  

        return response()->json($response_API);
    }

    private function generateNoAkadInvestor($Id)
    {
        $sekarang = explode("-",date('d-n-Y'));
        $tgl = $sekarang[0];
        $bln = $sekarang[1];
        $thn = (string)$sekarang[2];

        switch ($bln) {
            case 1:
                $blnAkad = 'I';
                break;
            case 2:
                $blnAkad = 'II';
                break;
            case 3:
                $blnAkad = 'III';
                break;
            case 4:
                $blnAkad = 'IV';
                break;
            case 5:
                $blnAkad = 'V';
                break;
            case 6:
                $blnAkad = 'VI';
                break;
            case 7:
                $blnAkad = 'VII';
                break;
            case 8:
                $blnAkad = 'VIII';
                break;
            case 9:
                $blnAkad = 'IX';
                break;
            case 10:
                $blnAkad = 'X';
                break;
            case 11:
                $blnAkad = 'XI';
                break;
            case 12:
                $blnAkad = 'XII';
                break;
            default:
                $blnAkad = 0;
                break;
        }

        $getDataNoAkad = MasterNoAkadInvestor::where('bln_akad_inv',$blnAkad)->where('thn_akad_inv',$thn)->first();

        if (!empty($getDataNoAkad))
        {
            $noAkad = $getDataNoAkad->no_akad_inv;
            $noAkad += 1;
            $nextBlnAkad = $getDataNoAkad->bln_akad_inv;
            $nextThnAkad = $getDataNoAkad->thn_akad_inv;
            if (strlen($noAkad) == 1) {
                $nextNoAkad = '00'.$noAkad;
            }
            elseif (strlen($noAkad) == 2) {
                $nextNoAkad = '0'.$noAkad;
            }
            else {
                $nextNoAkad = $noAkad;
            }

            $getDataNoAkad->no_akad_inv = $noAkad;

            $getDataNoAkad->save();
        }
        else
        {
            
            $masterNoAkad = new MasterNoAkadInvestor;
            $masterNoAkad->no_akad_inv = 0;
            $masterNoAkad->investor_id = $Id;
            $masterNoAkad->bln_akad_inv = $blnAkad;
            $masterNoAkad->thn_akad_inv = $thn;

            $masterNoAkad->save();

            $nextNoAkad = '000';
            $nextBlnAkad = $blnAkad;
            $nextThnAkad = $thn;
        }

        return $nextNoAkad.'/DSI/AWBL/'.$nextBlnAkad.'/'.$nextThnAkad;
    }

    public function createDocInvestor($userID)
    {
        if($userID)
        {
            $getDataInvestor = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                                    ->where('investor_id',$userID)
                                    ->first();
            $getDataRekening = RekeningInvestor::where('investor_id',$userID)->first();
            $getDataBank = MasterBank::where('kode_bank',$getDataInvestor->bank_investor)->first();
            $getDataAhliWaris = AhliWarisInvestor::where('id_investor',$userID)->first();
            $getProyekInvestor = PendanaanAktif::leftJoin('proyek','proyek.id','=','pendanaan_aktif.proyek_id')
                                                ->where('pendanaan_aktif.investor_id',$userID)
                                                ->where('pendanaan_aktif.status',1)
                                                ->whereNotIn('proyek.id',[\DB::raw('select proyek_id from log_pengembalian_dana where investor_id = '.$userID.' group by proyek_id')])
                                                ->get();

            $getNominalInvestasiInvestor = PendanaanAktif::leftJoin('proyek','proyek.id','=','pendanaan_aktif.proyek_id')
                                                ->where('pendanaan_aktif.investor_id',$userID)
                                                ->where('pendanaan_aktif.status',1)
                                                ->whereNotIn('proyek.id',[\DB::raw('select proyek_id from log_pengembalian_dana where investor_id = '.$userID.' group by proyek_id')])
                                                ->sum('pendanaan_aktif.total_dana');

            $getJumlahProyekInvestor = PendanaanAktif::leftJoin('proyek','proyek.id','=','pendanaan_aktif.proyek_id')
                                                ->where('pendanaan_aktif.investor_id',$userID)
                                                ->where('pendanaan_aktif.status',1)
                                                ->whereNotIn('proyek.id',[\DB::raw('select proyek_id from log_pengembalian_dana where investor_id = '.$userID.' group by proyek_id')])
                                                ->count('pendanaan_aktif.id');

            $nama_investor = $getDataInvestor->nama_investor;
            $no_ktp = $getDataInvestor->no_ktp_investor;
            $alamat = $getDataInvestor->alamat_investor;
            $username = $getDataInvestor->username;
            $no_hp = $getDataInvestor->phone_investor;
            $email = $getDataInvestor->email;
            
            $tgl_invest = !empty($getDataRekening) ? Carbon::parse(explode(" ",$getDataRekening->updated_at)[0])->format('d-m-Y') : 0;
            $total_aset = !empty($getDataRekening) ? $getDataRekening->total_dana : 0;
            $nominal_investasi = !empty($getDataRekening) ? number_format($getDataRekening->total_dana,0,'','.') : 0;
            $va = !empty($getDataRekening) ? $getDataRekening->va_number : 0;

            $rekening = $getDataInvestor->rekening;
            $bank = $getDataBank->nama_bank;
            $pemilik_rekening = $getDataInvestor->nama_pemilik_rek;
            $nama_waris = !empty($getDataAhliWaris) ? $getDataAhliWaris->nama_ahli_waris : '-';
            $hub_keluarga_waris = !empty($getDataAhliWaris) ? $getDataAhliWaris->hubungan_keluarga_ahli_waris : '-';
            $no_ktp_waris = !empty($getDataAhliWaris) ? $getDataAhliWaris->nik_ahli_waris : '-';
            $no_hp_waris = !empty($getDataAhliWaris) ? $getDataAhliWaris->no_hp_ahli_waris : '-';
            $alamat_waris = !empty($getDataAhliWaris) ? $getDataAhliWaris->alamat_ahli_waris : '-';
            $tgl_sekarang = date("d-n-Y");
            $data_tgl = !empty($tgl_sekarang) ? explode("-",$tgl_sekarang) : null;
            // tgl
            $cek_tgl = 0;
            if($data_tgl !== null && $data_tgl !== '')
            {
              if($data_tgl[0] !== null && $data_tgl[0] !== '')
              {
                if(strlen($data_tgl[0])  == 2)
                {
                  if($data_tgl[0][0] == 0)
                  {
                    $cek_tgl = $data_tgl[0][1];
                  }
                  else
                  {
                    $cek_tgl = $data_tgl[0];
                  }
                }
                else
                {
                  $cek_tgl = $data_tgl[0];
                }
              }
              else
              {
                $cek_tgl = 0;
              }
            }
            else
            {
                $cek_tgl = 0;
            }
            // end tgl
            // bulan
            $data_bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
            for($x=1;$x<=12;$x++)
            {
                if ($x == $data_tgl[1])
                {
                    $cek_bln = $data_bulan[$x-1];
                }
            }
            // end bulan
            $tgl_bln_thn = $cek_tgl.' '.$cek_bln.' '.$data_tgl[2];
            $no_hari = date("N");
            
            switch ($no_hari) {
                case 1:
                    $hari_transaksi = 'Senin';
                    break;
                case 2:
                    $hari_transaksi = 'Selasa';
                    break;
                case 3:
                    $hari_transaksi = 'Rabu';
                    break;
                case 4:
                    $hari_transaksi = 'Kamis';
                    break;
                case 5:
                    $hari_transaksi = 'Jumat';
                    break;
                case 6:
                    $hari_transaksi = 'Sabtu';
                    break;
                case 7:
                    $hari_transaksi = 'Minggu';
                    break;
                default:
                    $hari_transaksi = 'Libur';
                    break;
            };

            $noAkadInvestor = $this->generateNoAkadInvestor($userID);

            $totalInvestasi = !empty($getNominalInvestasiInvestor) ? number_format($getNominalInvestasiInvestor,0,'','.') : 0;
            $totalProyek = !empty($getJumlahProyekInvestor) ? $getJumlahProyekInvestor : 0;

            // $phpWordObj = new PhpWord();
            // $section = $phpWordObj->addSection();
            
            // $fontStyle = [
            //                 'bold' => true, 
            //                 'align' => 'center'
            //              ];

            // $borderStyle = [
            //                     'borderTopColor' =>'ff0000',
            //                     'borderTopSize' => 6,
            //                     'borderRightColor' =>'ff0000',
            //                     'borderRightSize' => 6,
            //                     'borderBottomColor' =>'ff0000',
            //                     'borderBottomSize' => 6,
            //                     'borderLeftColor' =>'ff0000',
            //                     'borderLeftSize' => 6,
            //                ];

            // $table = $section->addTable();
            // $table->addRow();
            // $table->addCell(700,$borderStyle)->addText("No",$fontStyle);
            // $table->addCell(1100,$borderStyle)->addText("No Proyek Yang Dibiayai",$fontStyle);
            // $table->addCell(1750,$borderStyle)->addText("Jumlah Dana Pembiayaan",$fontStyle);
            // $table->addCell(1600,$borderStyle)->addText("Presentase Imbal Hasil Yang Diterima (per Tahun)",$fontStyle);
            // $table->addCell(1600,$borderStyle)->addText("Presentase Komisi Penyelenggara (per Tahun)",$fontStyle);
            // $table->addCell(1300,$borderStyle)->addText("Jangka Waktu Proyek",$fontStyle);
            // for ($r = 0; $r < $totalProyek; $r++) {
                
            //         $table->addRow();
            //         $table->addCell(700,$borderStyle)->addText($r+1);
            //         $table->addCell(1100,$borderStyle)->addText(!empty($getProyekInvestor) ? explode(' ',$getProyekInvestor[$r]['nama'])[1] : '');
            //         $table->addCell(1750,$borderStyle)->addText(!empty($getProyekInvestor) ? number_format($getProyekInvestor[$r]['total_dana'],0,'','.') : 0);
            //         $table->addCell(1600,$borderStyle)->addText(!empty($getProyekInvestor) ? number_format($getProyekInvestor[$r]['profit_magin'],0,'','').'%' : 0);
            //         $table->addCell(1600,$borderStyle)->addText('5%');
            //         $table->addCell(1300,$borderStyle)->addText(!empty($getProyekInvestor) ? $getProyekInvestor[$r]['tenor_waktu'].' bulan' : 0);
                
            // }

            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/public/akad_template/PERJANJIAN_PEMBIAYAAN_WAKALAH_BIL_UJRAH.docx'));
             
            $templateProcessor->setValue([
                                            'Nama_Investor',
                                            'Nomor_KTP_Investor',
                                            'Alamat_Investor',
                                            'Username_Investor',
                                            'Nomor_HP_Investor',
                                            'Email_Investor',
                                            'Nomor_Perjanjian',
                                            'Tanggal_Perjanjian',
                                            'Hari_Transaksi',
                                            'Tanggal_Transaksi',
                                            // 'Jenis_Pembiayaan',
                                            'Nominal_Investasi',
                                            'Tanggal_Transfer',
                                            'Nomor_Virtual_Account',
                                            'Rekening_Imbal_Hasil',
                                            'Nama_Bank',
                                            'Nama_Pemilik_Rekening',
                                            // 'Biaya_Perbankan',
                                            // 'Biaya_Kirim',
                                            // 'Biaya_Materai',
                                            'Nama_Ahli_waris',
                                            'Hubungan_Keluarga',
                                            'Nomor_KTP/KK_ahli_waris',
                                            'Nomor_HP_ahli_waris',
                                            'Alamat_ahli_waris',
                                            'Nomor_Surat_Kuasa',
                                            'Nilai_Investasi',
                                            'Jumlah_Proyek',
                                            
                                        ], 
                                        [
                                            $nama_investor,
                                            $no_ktp,
                                            $alamat,
                                            $username,
                                            $no_hp,
                                            $email,
                                            $noAkadInvestor,
                                            $tgl_bln_thn,
                                            $hari_transaksi,
                                            $tgl_bln_thn,
                                            // '-',
                                            $nominal_investasi,
                                            $tgl_invest,
                                            $va,
                                            $rekening,
                                            $bank,
                                            $pemilik_rekening,
                                            // '-',
                                            // '-',
                                            // '-',
                                            $nama_waris,
                                            $hub_keluarga_waris,
                                            $no_ktp_waris,
                                            $no_hp_waris,
                                            $alamat_waris,
                                            $noAkadInvestor,
                                            $totalInvestasi,
                                            $totalProyek,
                                            
                                        ]);
            // $templateProcessor->setComplexBlock('Data_Proyek', $table);

            Storage::disk('public')->makeDirectory('akad_investor/'.$userID);
            $templateProcessor->saveAs(storage_path('app/public/akad_investor/'.$userID.'/PERJANJIAN_PEMBIAYAAN_WAKALAH_BIL_UJRAH.docx'));
            
            shell_exec('unoconv -f pdf '.base_path('storage/app/public/akad_investor/'.$userID.'/PERJANJIAN_PEMBIAYAAN_WAKALAH_BIL_UJRAH.docx').' '.base_path('storage/app/public/akad_investor/'.$userID));

            // $this->logAkadDigiSignInvestorNonDigital($userID,0,1,$total_aset,'complete','none');
            
            return response()->json(['status' => 'Berhasil']);
        }
        else
        {
            return response()->json(['status' => 'Gagal']);
        }
    }





    #Akad Murobahah Investor Borrower
    public function signDigiSignMurobahahInvestor($userId,$proyekId)
    {
        $getDataInvestor = DetilInvestor::leftJoin('investor','investor.id','=','detil_investor.investor_id')
                                        ->where('investor.id',$userId)
                                        ->first();
        $getDocId = LogAkadDigiSignInvestor::where('proyek_id',$proyekId)->orderBy('id_log_akad_investor','desc')->first();
        
        $date = Carbon::now()->format('Ymd');
        $document_id = $getDocId->document_id;
        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' =>$document_id,                                
                            'email_user' => $getDataInvestor->email,
                            'view_only' => false 
                             
                        ]
                    ];
        $jsonFile = json_encode($data_json);
        $multipart_form = [
                               [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                               ] 
             
         ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'gen/genSignPage.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($getDataInvestor->email,$getNotif);

        return response()->json($response_API);
    }

    public function signDigiSignMurobahahBorrower($userId,$investor_id,$proyekId)
    {
        $getDataBorrower = BorrowerDetails::leftJoin('brw_users','brw_users.brw_id','=','brw_users_details.brw_id')
                                        ->where('brw_users_details.brw_id',$userId)
                                        ->first();
        
        $getDocId = LogAkadDigiSignBorrower::where('id_proyek',$proyekId)
                                        ->where('investor_id',$investor_id)
                                        ->orderBy('id_log_akad_borrower','desc')
                                        ->first();
        
        $date = Carbon::now()->format('Ymd');
        $document_id = $getDocId->document_id;
        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' =>$document_id,                                
                            'email_user' => $getDataBorrower->email,
                            'view_only' => false 
                             
                        ]
                    ];
        $jsonFile = json_encode($data_json);
        $multipart_form = [
                               [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                               ] 
             
         ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'gen/genSignPage.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($getDataBorrower->email,$getNotif);  

        return response()->json($response_API);
    }

    public function sendDocInvestorBorrower($idProyek,$userID){
        
        $getDataBorrower = BorrowerPendanaan::leftJoin('brw_users','brw_users.brw_id','=','brw_pendanaan.brw_id')
                                                    ->leftJoin('brw_users_details','brw_users_details.brw_id','=','brw_pendanaan.brw_id')
                                                    ->where('brw_pendanaan.id_proyek',$idProyek)
                                                    ->first();
        $getDataInvestor = DetilInvestor::leftJoin('investor','investor.id','=','detil_investor.investor_id')
                                        ->where('investor.id',$userID)
                                        ->first();
        $getTotalPendanaan = Proyek::where('id',$idProyek)->first();

        $pendanaan = $getTotalPendanaan->total_need;
        $getTotalAset = RekeningInvestor::where('investor_id',$userID)->first();
// syslog(0,"idproyek=".$idProyek);
// syslog(0,"userid=".$userID);

// syslog(0,"getDataBorrower=".json_encode($getDataBorrower));

        $date = Carbon::now()->format('Ymd');
        $idInvestor = $getDataInvestor->id;
        $idBorrower = $getDataBorrower->brw_id;
        $totalAset = !empty($getTotalAset) ? $getTotalAset->total_dana : 0;
        $getJumlahDoc = LogAkadDigiSignBorrower::where('investor_id',$userID)
                                                ->count();
        $jumlahDocNext = $getJumlahDoc+1;
        $document_id = 'kontrakAll_'.$date.'_'.$idProyek.'_'.$jumlahDocNext;
        
        $page = 13;

        $startx = 80; 
        $starty = 200;
        $size_x = 480;
        $size_y = 50;

        $llx = $startx;
        $lly = $starty;
        $urx = $llx+$size_x;
        $ury = $lly+$size_y;

        $startx2 = 360; 
        $starty2 = 480;
        $size_x2 = 140;
        $size_y2 = 50;

        $llx2 = $startx2;
        $lly2 = $starty2;
        $urx2 = $llx2+$size_x2;
        $ury2 = $lly2+$size_y2;
                
        
        $client = new Client();
        $data_json = array();

        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' => $document_id,
                            'redirect' => true,
                            'branch' => 'KANTOR PUSAT',
                            'sequence_option' => false,
                            'send-to' => [
                                            [
                                                'name' => $getDataInvestor->nama_investor,
                                                'email' => $getDataInvestor->email
                                            ],
                                            [
                                                'name' => $getDataBorrower->nama,
                                                'email' => $getDataBorrower->email
                                            ],
                            ],
                            'req-sign' => [
                                            [
                                                'name' => $getDataBorrower->nama,
                                                'email' => $getDataBorrower->email,
                                                'aksi_ttd' => 'mt',
                                                'kuser' => '1234567890123456',
                                                'user' => 'ttd1',
                                                'llx' => $llx,
                                                'lly' => $lly,
                                                'urx' => $urx,
                                                'ury' => $ury,
                                                'page' => $page,
                                                'visible' => '1'
                                            ],
                                            [
                                                'name' => $getDataInvestor->nama_investor,
                                                'email' => $getDataInvestor->email,
                                                'aksi_ttd' => 'mt',
                                                'kuser' => '1234567890123456',
                                                'user' => 'ttd2',
                                                'llx' => $llx2,
                                                'lly' => $lly2,
                                                'urx' => $urx2,
                                                'ury' => $ury2,
                                                'page' => $page,
                                                'visible' => '1'
                                            ]
                            ],    
                            'payment' => '3',
                            'visible' => '1',
                            'signing_seq' => 0
                        ]
                    ];
            
        $jsonFile = json_encode($data_json);

        $this->createDocInvestorBorrower($userID,$idProyek);
      
        $docPDF = fopen('../storage/app/public/akad_borrower/'.$idBorrower.'/PERJANJIAN_PEMBIAYAAN_MURABAHAH_revisi.pdf', 'r');
             
        $multipart_form =   [  
                                [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                                ],
                                [
                                   'name' => 'file',
                                   'contents' => $docPDF
                                ]
                            
             
                            ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'SendDocMitraAT.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($getDataBorrower->email,$getNotif);

        $this->logAkadDigiSignInvestor($userID,$idProyek,1,$totalAset,'kirim',$document_id);
        $this->logAkadDigiSignBorrower($idBorrower,$userID,$idProyek,1,$pendanaan,'kirim',$document_id);

        return response()->json($response_API);
    }


    public function createDocInvestorBorrower($userID,$idProyek)
    {
        
        if($userID)
        {
            $getDataBorrower    =   BorrowerPendanaan::leftJoin('brw_users','brw_users.brw_id','=','brw_pendanaan.brw_id')
                                                    ->leftJoin('brw_users_details','brw_users_details.brw_id','=','brw_pendanaan.brw_id')
                                                    ->where('brw_pendanaan.id_proyek',$idProyek)
                                                    ->first();
            $id_borrower = $getDataBorrower !== null ? $getDataBorrower->brw_id : null;

            $getDataInvestor    = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                                            ->where('investor.id',$userID)
                                            ->first();
            $getRekening        = $id_borrower !== null ? BorrowerRekening::leftJoin("m_bank", "m_bank.kode_bank", "=", "brw_rekening.brw_kd_bank")->where('brw_rekening.brw_id',$id_borrower)->first() : null;

            $getPekerjaan = $getDataBorrower !== null ? MasterPekerjaan::where('id_pekerjaan',$getDataBorrower->pekerjaan)->first() : null;

            $getDataProyek = $idProyek !== null ? Proyek::where('id',$idProyek)->first() : null;
            $getDataPendanaanAktif = $getDataProyek !== null ? PendanaanAktif::where('proyek_id',$getDataProyek->id)->sum('total_dana') : null;
            $getDataBank = $getDataBorrower !== null ? MasterBank::where('kode_bank',$getRekening->brw_kd_bank)->first() : null;
            
            $getJaminan= $id_borrower !== null ? BorrowerJaminan::leftJoin('brw_pendanaan','brw_jaminan.pendanaan_id','=','brw_pendanaan.pendanaan_id')
                                    ->leftJoin('m_jenis_jaminan', 'm_jenis_jaminan.id_jenis_jaminan', '=','brw_jaminan.jaminan_jenis')
                                    ->where('brw_pendanaan.brw_id',$id_borrower)
                                    ->first() : null;

            $getProyekInvestor = $idProyek !== null ? PendanaanAktif::leftJoin('proyek','proyek.id','=','pendanaan_aktif.proyek_id')
                                                ->leftJoin('m_no_akad_investor','m_no_akad_investor.investor_id','=','pendanaan_aktif.investor_id')
                                                 ->leftJoin('detil_investor','detil_investor.investor_id','=','pendanaan_aktif.investor_id')
                                                ->where('pendanaan_aktif.proyek_id',$idProyek)
                                                ->where('pendanaan_aktif.status',1)
                                                ->whereNotIn('proyek.id',[\DB::raw('select proyek_id from log_pengembalian_dana group by proyek_id')])
                                                ->get() : null;

            $getJumlahProyekInvestor = PendanaanAktif::leftJoin('proyek','proyek.id','=','pendanaan_aktif.proyek_id')
                                                ->where('pendanaan_aktif.investor_id',$userID)
                                                ->where('pendanaan_aktif.status',1)
                                                ->whereNotIn('proyek.id',[\DB::raw('select proyek_id from log_pengembalian_dana where investor_id = '.$userID.' group by proyek_id')])
                                                ->count('pendanaan_aktif.id');

            $nama_investor = $getDataInvestor->nama_investor;
            $no_ktp_investor = $getDataInvestor->no_ktp_investor;
            $alamat_investor = $getDataInvestor->alamat_investor;
            $no_hp_investor = $getDataInvestor->phone_investor;

            $marginProyek = !empty($getDataProyek) ? number_format($getDataProyek->profit_margin,0,'','') : 0;
            $totalMargin = $marginProyek + 5;
            $perhitunganMargin = $totalMargin/100 * $getDataPendanaanAktif;
            $totalHarga = $getDataPendanaanAktif + $perhitunganMargin;
            

            $nama = $getDataBorrower !== null ? $getDataBorrower->nama : '-';
            $nama_badan = $getDataBorrower !== null ? $getDataBorrower->nm_bdn_hukum : '-';
            $jabatan = $getDataBorrower !== null ? $getDataBorrower->jabatan : '-';
            $alamat = $getDataBorrower !== null ? $getDataBorrower->alamat : '-';

            $no_akta = '-';
            $tgl_akta = '-';
            $nama_notaris = '-';
            
            $Nomor_SP3 = '-';
            $Tanggal_SP3 = '-';
            $Nomor_Waad = '-';
            $Tanggal_Waad = '-';
            
            $Jenis_Obyek_Pembiayaan = $getDataProyek !== null ? $getDataProyek->nama : '';
            $Alamat_Proyek =  $getDataProyek !== null ? $getDataProyek->alamat : '-';
            $Jumlah_Plafond = $getRekening !== null ? $getRekening->total_plafon : 0;
            $Harga_Pokok = $getDataPendanaanAktif !== null ? $getDataPendanaanAktif : 0;
            $Jumlah_Uang_Muka = 0;
            $Jumlah_Margin_Pembiayaan = $perhitunganMargin;
            $Harga_Jual = $totalHarga;
            $Biaya_Administrasi = 0;
            $Jangka_Waktu_Pembiayaan = $getDataProyek !== null ? $getDataProyek->tenor_waktu : 0;
            $Tanggal_Akad = Carbon::now()->format('d-m-Y');
            $Tanggal_Jatuh_Tempo = $getDataProyek !== null ? Carbon::parse($getDataProyek->tgl_selesai)->format('d-m-Y') : 0;
            $Jangka_Waktu = $getDataProyek !== null ? $getDataProyek->tenor_waktu : 0;
 
            $Nominal_Angsuran = 0;
            
            $Jenis_Jaminan = $getJaminan !== null ? $getJaminan->jenis_jaminan : '-';
            $Alamat_Jaminan = $getJaminan !== null ? $getJaminan->jaminan_detail : '-';
            $Pemilik_Jaminan = $getJaminan !== null ? $getJaminan->jaminan_nama : '-';
            $Nilai_Jaminan = $getJaminan !== null ? $getJaminan->jaminan_nilai : 0;
 
            $Nomor_Rekening = $getRekening !== null ? $getRekening->brw_norek : 0;
            
            $Bank_Rekening = $getRekening !== null ? $getRekening->nama_bank : '-';
            $Nama_Pemilik_Rekening = $getRekening !== null ? $getRekening->brw_nm_pemilik : '-';
            $Terbilang_Jangka_Waktu =  ucwords(Terbilang::make($Jangka_Waktu_Pembiayaan,''));

            $totalProyek = !empty($getJumlahProyekInvestor) ? $getJumlahProyekInvestor : 0;
            
            $tgl_sekarang = date("d-n-Y");
            $data_tgl = !empty($tgl_sekarang) ? explode("-",$tgl_sekarang) : null;
            // tgl
            $cek_tgl = 0;
            if($data_tgl !== null && $data_tgl !== '')
            {
              if($data_tgl[0] !== null && $data_tgl[0] !== '')
              {
                if(strlen($data_tgl[0])  == 2)
                {
                  if($data_tgl[0][0] == 0)
                  {
                    $cek_tgl = $data_tgl[0][1];
                  }
                  else
                  {
                    $cek_tgl = $data_tgl[0];
                  }
                }
                else
                {
                  $cek_tgl = $data_tgl[0];
                }
              }
              else
              {
                $cek_tgl = 0;
              }
            }
            else
            {
                $cek_tgl = 0;
            }
            // end tgl
            // bulan
            $data_bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
            for($x=1;$x<=12;$x++)
            {
                if ($x == $data_tgl[1])
                {
                    $cek_bln = $data_bulan[$x-1];
                }
            }
            // end bulan
            $tgl_bln_thn = $cek_tgl.' '.$cek_bln.' '.$data_tgl[2];
            $no_hari = date("N");
            
            switch ($no_hari) {
                case 1:
                    $hari_transaksi = 'Senin';
                    break;
                case 2:
                    $hari_transaksi = 'Selasa';
                    break;
                case 3:
                    $hari_transaksi = 'Rabu';
                    break;
                case 4:
                    $hari_transaksi = 'Kamis';
                    break;
                case 5:
                    $hari_transaksi = 'Jumat';
                    break;
                case 6:
                    $hari_transaksi = 'Sabtu';
                    break;
                case 7:
                    $hari_transaksi = 'Minggu';
                    break;
                default:
                    $hari_transaksi = 'Libur';
                    break;
            };

            $noAkad = $this->generateNoAkadBorrower($idProyek);

            // $phpWordObj = new PhpWord();
            // $section = $phpWordObj->addSection();
            
            // $fontStyle = [
            //                 'bold' => true, 
            //                 'align' => 'center'
            //              ];

            // $borderStyle = [
            //                     'borderTopColor' =>'ff0000',
            //                     'borderTopSize' => 6,
            //                     'borderRightColor' =>'ff0000',
            //                     'borderRightSize' => 6,
            //                     'borderBottomColor' =>'ff0000',
            //                     'borderBottomSize' => 6,
            //                     'borderLeftColor' =>'ff0000',
            //                     'borderLeftSize' => 6,
            //                ];

            // $table = $section->addTable();
            // $table->addRow();
            // $table->addCell(700,$borderStyle)->addText("No",$fontStyle);
            // $table->addCell(1100,$borderStyle)->addText("Nama Pemberi Pembiayaan",$fontStyle);
            // $table->addCell(1750,$borderStyle)->addText("Jumlah Dana yang Dibiayai",$fontStyle);
            // $table->addCell(1600,$borderStyle)->addText("Margin Keuntungan",$fontStyle);
            // $table->addCell(1600,$borderStyle)->addText("No Proyek yang Dibiayai",$fontStyle);
            // $table->addCell(1300,$borderStyle)->addText("No Surat Kuasa",$fontStyle);
            // for ($r = 0; $r < $totalProyek; $r++) {
                
            //         $table->addRow();
            //         $table->addCell(700,$borderStyle)->addText($r+1);
            //         $table->addCell(1100,$borderStyle)->addText($getProyekInvestor[$r]['nama_investor']);
            //         $table->addCell(1750,$borderStyle)->addText(number_format($getProyekInvestor[$r]['total_dana'],0,'','.'));
            //         $table->addCell(1600,$borderStyle)->addText(number_format($getProyekInvestor[$r]['profit_magin'],0,'','').'%');
            //         $table->addCell(1600,$borderStyle)->addText(explode(' ',$getProyekInvestor[$r]['nama'])[1]);
            //         $table->addCell(1300,$borderStyle)->addText($getProyekInvestor[$r]['no_akad_inv'].'/DSI/AWBL/'.$getProyekInvestor[$r]['bln_akad_inv'].'/'.$getProyekInvestor[$r]['thn_akad_inv']);
                
            // }

            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/public/akad_template/PERJANJIAN_PEMBIAYAAN_MURABAHAH_revisi.docx'));
             
            $templateProcessor->setValue([  
                                            'Nama_Investor',
                                            'Nomor_KTP',
                                            'Alamat_Investor',
                                            'Nomor_HP_Investor',
                                            'Nomor_Perjanjian',
                                            'Hari_Sekarang',
                                            'Tanggal_Sekang',
                                            'Nama_Borrowers',
                                            'Alamat_Borrowers',
                                            'Nama_Direktur',
                                            'Jabatan_Direktur',
                                            'Nomor_Akta_Pendirian',
                                            'Tanggal_Pendirian',
                                            'Nama_Notaris',
                                            'Nomor_SP3',
                                            'Tanggal_SP3',  
                                            'Jenis_Obyek_Pembiayaan/Proyek',
                                            'Harga_Pokok',
                                            'Jumlah_Margin_Pembiayaan',
                                            'Harga_Pengembalian',
                                            'Jangka_Waktu_Pembiayaan',
                                            'Tanggal_Hari_Ini',
                                            'Tanggal_Jatuh_Tempo',
                                            'Jumlah_Angsuran',
                                            'Tanggal_Jatuh_Tempo_Angsuran',
                                            'Jenis_Jaminan',
                                            'Legalitas_Jaminan',
                                            'Nama_Pemilik_Jaminan',
                                            'Nilai_Jaminan',
                                            'Nomor_Rekening',
                                            'Bank_Transfer',
                                            'Nama_Rekening',
                                            'Jangka_Waktu',
                                            'Terbilang_Jangka_Waktu',
                                            'Nama_PT_Borrower'
                                        ], 
                                        [
                                            $nama_investor,
                                            $no_ktp_investor,
                                            $alamat_investor,
                                            $no_hp_investor,
                                            $noAkad,
                                            $hari_transaksi,
                                            $Tanggal_Akad,
                                            $nama_badan,
                                            $alamat,
                                            $nama,
                                            $jabatan,
                                            $no_akta,
                                            $tgl_akta,
                                            $nama_notaris,
                                            $Nomor_SP3,
                                            $Tanggal_SP3,
                                            $Jenis_Obyek_Pembiayaan,
                                            $Harga_Pokok,
                                            $Jumlah_Margin_Pembiayaan,
                                            $Harga_Jual,
                                            $Jangka_Waktu_Pembiayaan,
                                            $Tanggal_Akad,
                                            $Tanggal_Jatuh_Tempo,
                                            $Jangka_Waktu_Pembiayaan,
                                            '-',
                                            $Jenis_Jaminan,
                                            '-',
                                            $Pemilik_Jaminan,
                                            $Nilai_Jaminan,
                                            $Nomor_Rekening,
                                            $Bank_Rekening,
                                            $Nama_Pemilik_Rekening,
                                            $Jangka_Waktu_Pembiayaan,
                                            $Terbilang_Jangka_Waktu,
                                            $nama_badan
                                        ]);
            // $templateProcessor->setComplexBlock('Data_Tabel', $table);
            
            
            if ($id_borrower == null)
            {
                Storage::disk('public')->makeDirectory('akad_investor/'.$userID);

                $templateProcessor->saveAs(storage_path('app/public/akad_investor/'.$userID.'/PERJANJIAN_PEMBIAYAAN_MURABAHAH_revisi.docx'));
                shell_exec('unoconv -f pdf '.base_path('storage/app/public/akad_investor/'.$userID.'/PERJANJIAN_PEMBIAYAAN_MURABAHAH_revisi.docx').' '.base_path('storage/app/public/akad_investor/'.$userID));
            }
            else
            {
                Storage::disk('public')->makeDirectory('akad_borrower/'.$id_borrower);

                $templateProcessor->saveAs(storage_path('app/public/akad_borrower/'.$id_borrower.'/PERJANJIAN_PEMBIAYAAN_MURABAHAH_revisi.docx'));
                shell_exec('unoconv -f pdf '.base_path('storage/app/public/akad_borrower/'.$id_borrower.'/PERJANJIAN_PEMBIAYAAN_MURABAHAH_revisi.docx').' '.base_path('storage/app/public/akad_borrower/'.$id_borrower));
            }
            

            return ['status' => 'Berhasil'];
        }
        else
        {
            return ['status' => 'Gagal'];
        }
    }




    #Dokumen Wakalah Borrower
    public function signDigiSignWakalahBorrower($userId,$proyekId)
    {
        $getDataBorrower = BorrowerDetails::leftJoin('brw_users','brw_users.brw_id','=','brw_users_details.brw_id')
                                        ->where('brw_users_details.brw_id',$userId)
                                        ->first();
        $getDocId = LogAkadDigiSignBorrower::where('id_proyek',$proyekId)->orderBy('id_log_akad_borrower','desc')->first();
        
        $date = Carbon::now()->format('Ymd');
        $document_id = $getDocId->document_id;
        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' =>$document_id,                                
                            'email_user' => $getDataBorrower->email,
                            'view_only' => false 
                             
                        ]
                    ];
        $jsonFile = json_encode($data_json);
        $multipart_form = [
                               [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                               ] 
             
         ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'gen/genSignPage.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($getDataBorrower->email,$getNotif);

        return response()->json($response_API);
    }

    public function sendDocWakalahBorrower($userID,$idProyek){
        
        $getDataBorrower = BorrowerDetails::leftJoin('brw_users','brw_users.brw_id','=','brw_users_details.brw_id')
                                        ->where('brw_users.brw_id',$userID)
                                        ->first();
                                        
        $getDataTaufiqSign = DetilInvestor::leftJoin('investor','investor.id','=','detil_investor.investor_id')
                                        ->where('investor.email',config('app.email_pak_taufiq'))
                                        ->first();
        $getDataProyek = Proyek::where('id',$idProyek)->first();
        $pendanaan = $getDataProyek->total_need;

        $date = Carbon::now()->format('Ymd');
        $idBorrower = $getDataBorrower->brw_id;
        $document_id = 'borrowerKontrak_'.$date.'_'.$idBorrower.'_'.$idProyek;
        $type_borrower = $getDataBorrower->brw_type;
        

        if ($type_borrower == 1 || $type_borrower == 3)
        {
            $startx = 145;
            $starty = 250;
            $size_x = 75;
            $size_y = 50;
            $page = 2;

            $llx = $startx;
            $lly = $starty;
            $urx = $llx+$size_x;
            $ury = $lly+$size_y;

            $startx2 = 360;
            $starty2 = 250;
            $size_x2 = 75;
            $size_y2 = 50;

            $llx2 = $startx2;
            $lly2 = $starty2;
            $urx2 = $llx2+$size_x2;
            $ury2 = $lly2+$size_y2;
        }
        else
        {
            $startx = 145;
            $starty = 250;
            $size_x = 75;
            $size_y = 50;
            $page = 2;

            $llx = $startx;
            $lly = $starty;
            $urx = $llx+$size_x;
            $ury = $lly+$size_y;

            $startx2 = 360;
            $starty2 = 250;
            $size_x2 = 75;
            $size_y2 = 50;

            $llx2 = $startx2;
            $lly2 = $starty2;
            $urx2 = $llx2+$size_x2;
            $ury2 = $lly2+$size_y2;
        }
                
        
        $client = new Client();
        $data_json = array();

        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' => $document_id,
                            'redirect' => true,
                            'branch' => 'KANTOR PUSAT',
                            'sequence_option' => false,
                            'send-to' => [
                                            [
                                                'name' => $getDataBorrower->nama,
                                                'email' => $getDataBorrower->email
                                            ]
                            ],
                            'req-sign' => [
                                            [
                                                'name' => $getDataTaufiqSign->nama_investor,
                                                'email' => $getDataTaufiqSign->email,
                                                'aksi_ttd' => 'at',
                                                'kuser' => '3jWyul25i5jwv4J5',
                                                'user' => 'ttd1',
                                                'llx' => $llx,
                                                'lly' => $lly,
                                                'urx' => $urx,
                                                'ury' => $ury,
                                                'page' => $page,
                                                'visible' => '1'
                                            ],
                                            [
                                                'name' => $getDataBorrower->nama,
                                                'email' => $getDataBorrower->email,
                                                'aksi_ttd' => 'mt',
                                                'kuser' => '1234567890123456',
                                                'user' => 'ttd2',
                                                'llx' => $llx2,
                                                'lly' => $lly2,
                                                'urx' => $urx2,
                                                'ury' => $ury2,
                                                'page' => $page,
                                                'visible' => '1'
                                            ]
                            ],    
                            'payment' => '3',
                            'visible' => '1',
                            'signing_seq' => 0
                        ]
                    ];
            
        $jsonFile = json_encode($data_json);

        // $this->createDocBorrower($userId);

        if($type_borrower == 1 or $type_borrower == 3){
            $this->createDocWakalahBorrower($userID,$idProyek);
            $docPDF = fopen('../storage/app/public/akad_borrower/'.$userID.'/PERJANJIAN_WAKALAH_PEMBIAYAAN.pdf', 'r');
        }
        
        else{
            $this->createDocWakalahBorrower($userId,$idProyek);
            $docPDF = fopen('../storage/app/public/akad_borrower/'.$userID.'/PERJANJIAN_WAKALAH_PEMBIAYAAN.pdf', 'r');
        }
             
        $multipart_form =   [  
                                [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                                ],
                                [
                                   'name' => 'file',
                                   'contents' => $docPDF
                                ]
                            
             
                            ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'SendDocMitraAT.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($getDataBorrower->email,$getNotif);

        $this->logAkadDigiSignBorrower($idBorrower,0,$idProyek,1,$pendanaan,'kirim',$document_id);
// syslog(0,"return sendDocWakalahBorrower=".json_encode($response_API)); 
        return response()->json($response_API);
    }

    public function createDocWakalahBorrower($userID,$idProyek)
    {
        
        if($userID)
        {
            $getDataBorrower    = Borrower::leftJoin('brw_users_details','brw_users_details.brw_id','=','brw_users.brw_id')
                                    ->where('brw_users.brw_id',$userID)
                                    ->first();
            // $getDataPendanaan   = BorrowerPendanaan::leftJoin('brw_tipe_pendanaan','brw_tipe_pendanaan.tipe_id','=','brw_pendanaan.pendanaan_tipe')
            //                                         ->where('brw_pendanaan.brw_id',$userID)
            //                                         ->first(['brw_tipe_pendanaan.pendanaan_nama','brw_pendanaan.*']);
            $getRekening        = BorrowerRekening::leftJoin("m_bank", "m_bank.kode_bank", "=", "brw_rekening.brw_kd_bank")->where('brw_rekening.brw_id',$userID)->first();

            $getPekerjaan = MasterPekerjaan::where('id_pekerjaan',$getDataBorrower->pekerjaan)->first();

            $getDataProyek = $idProyek !== null ? Proyek::where('id',$idProyek)->first() : null;
            $getDataPendanaanAktif = $getDataProyek !== null ? PendanaanAktif::where('proyek_id',$getDataProyek->id)->sum('total_dana') : null;
            $getDataBank = MasterBank::where('kode_bank',$getRekening->brw_kd_bank)->first();
            
            $getJaminan= BorrowerJaminan::leftJoin('brw_pendanaan','brw_jaminan.pendanaan_id','=','brw_pendanaan.pendanaan_id')
                                    ->leftJoin('m_jenis_jaminan', 'm_jenis_jaminan.id_jenis_jaminan', '=','brw_jaminan.jaminan_jenis')
                                    ->where('brw_pendanaan.brw_id',$userID)
                                    ->first();

            $getProyekInvestor = PendanaanAktif::leftJoin('proyek','proyek.id','=','pendanaan_aktif.proyek_id')
                                                ->leftJoin('m_no_akad_investor','m_no_akad_investor.investor_id','=','pendanaan_aktif.investor_id')
                                                 ->leftJoin('detil_investor','detil_investor.investor_id','=','pendanaan_aktif.investor_id')
                                                ->where('pendanaan_aktif.proyek_id',$idProyek)
                                                ->where('pendanaan_aktif.status',1)
                                                ->whereNotIn('proyek.id',[\DB::raw('select proyek_id from log_pengembalian_dana group by proyek_id')])
                                                ->get();

            $nama = $getDataBorrower->nama;
            $nama_badan = $getDataBorrower->nm_bdn_hukum;
            $jabatan = $getDataBorrower->jabatan;
            $alamat = $getDataBorrower->alamat;

            $no_akta = '-';
            $tgl_akta = '-';
            $nama_notaris = '-';
            
            $Jenis_Obyek_Pembiayaan = $getDataProyek !== null ? $getDataProyek->nama : '';
            $Jumlah_Butuh = $getDataProyek !== null ? $getDataProyek->total_need : 0;
            $Harga_Pokok = $getDataPendanaanAktif !== null ? $getDataPendanaanAktif : 0;
            
            $Tanggal_Akad = Carbon::now()->format('d-m-Y');
        
            $Nomor_Rekening = $getRekening->brw_norek;
            
            $Bank_Rekening = $getRekening->nama_bank;
            $Nama_Pemilik_Rekening = $getRekening->brw_nm_pemilik;
            
            $tgl_sekarang = date("d-n-Y");
            $data_tgl = !empty($tgl_sekarang) ? explode("-",$tgl_sekarang) : null;
            // tgl
            $cek_tgl = 0;
            if($data_tgl !== null && $data_tgl !== '')
            {
              if($data_tgl[0] !== null && $data_tgl[0] !== '')
              {
                if(strlen($data_tgl[0])  == 2)
                {
                  if($data_tgl[0][0] == 0)
                  {
                    $cek_tgl = $data_tgl[0][1];
                  }
                  else
                  {
                    $cek_tgl = $data_tgl[0];
                  }
                }
                else
                {
                  $cek_tgl = $data_tgl[0];
                }
              }
              else
              {
                $cek_tgl = 0;
              }
            }
            else
            {
                $cek_tgl = 0;
            }
            // end tgl
            // bulan
            $data_bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
            for($x=1;$x<=12;$x++)
            {
                if ($x == $data_tgl[1])
                {
                    $cek_bln = $data_bulan[$x-1];
                }
            }
            // end bulan
            $tgl_bln_thn = $cek_tgl.' '.$cek_bln.' '.$data_tgl[2];
            $no_hari = date("N");
            
            switch ($no_hari) {
                case 1:
                    $hari_transaksi = 'Senin';
                    break;
                case 2:
                    $hari_transaksi = 'Selasa';
                    break;
                case 3:
                    $hari_transaksi = 'Rabu';
                    break;
                case 4:
                    $hari_transaksi = 'Kamis';
                    break;
                case 5:
                    $hari_transaksi = 'Jumat';
                    break;
                case 6:
                    $hari_transaksi = 'Sabtu';
                    break;
                case 7:
                    $hari_transaksi = 'Minggu';
                    break;
                default:
                    $hari_transaksi = 'Libur';
                    break;
            };

            $noAkad = $this->generateNoAkadBorrower($idProyek);


            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/public/akad_template/PERJANJIAN_WAKALAH_PEMBIAYAAN.docx'));
             
            $templateProcessor->setValue([  'Nama_Borrower',
                                            'Nomor_Wakalah',
                                            'Hari_Sekarang',
                                            'Tanggal_Sekarang',
                                            'Alamat_Borrowers',
                                            'Nama_Direktur',
                                            'Jabatan_Direktur',
                                            'Nomor_Akta',
                                            'Tanggal_Akta',
                                            'Nama_Notaris',
                                            'Tujuan_Pembiayaan',
                                            'Nilai_Pencairan',
                                            'Bank_Transfer',
                                            'Nama_Penerima',
                                            'Nomor_Rekening_Penerima',
                                            'Nama_PT_Borrower',
                                            'Nama_Proyek',
                                            'Nilai_Pembiayaan'
                                            
                                        ], 
                                        [
                                            $nama_badan,
                                            $noAkad,
                                            $hari_transaksi,
                                            $Tanggal_Akad,
                                            $alamat,
                                            $nama,
                                            $jabatan,
                                            $no_akta,
                                            $tgl_akta,
                                            $nama_notaris,
                                            $Jenis_Obyek_Pembiayaan,
                                            $Harga_Pokok,
                                            $Bank_Rekening,
                                            $Nama_Pemilik_Rekening,
                                            $Nomor_Rekening,
                                            $nama_badan,
                                            $Jenis_Obyek_Pembiayaan,
                                            $Jumlah_Butuh

                                        ]);
            
            Storage::disk('public')->makeDirectory('akad_borrower/'.$userID);
            
            $templateProcessor->saveAs(storage_path('app/public/akad_borrower/'.$userID.'/PERJANJIAN_WAKALAH_PEMBIAYAAN.docx'));
            shell_exec('unoconv -f pdf '.base_path('storage/app/public/akad_borrower/'.$userID.'/PERJANJIAN_WAKALAH_PEMBIAYAAN.docx').' '.base_path('storage/app/public/akad_borrower/'.$userID));
            

            return ['status' => 'Berhasil'];
        }
        else
        {
            return ['status' => 'Gagal'];
        }
    }






    //Borrower
    private function cekFotoDiriBorrowerExist($userId)
    {
        $link1 = '../storage/app/public/borrower/'.$userId.'/*pic_brw.jpeg';
        $link2 = '../storage/app/public/borrower/'.$userId.'/*pic_brw.jpg';
        $link3 = '../storage/app/public/borrower/'.$userId.'/*pic_brw.bmp';
        $link4 = '../storage/app/public/borrower/'.$userId.'/*pic_brw.png';
        $link5 = '../storage/app/public/borrower/'.$userId.'/*pic_brw.JPG';
        $link6 = '../storage/app/public/borrower/'.$userId.'/*pic_brw.JPEG';

        $file1 = glob($link1);
        $file2 = glob($link2);
        $file3 = glob($link3);
        $file4 = glob($link4);
        $file5 = glob($link5);
        $file6 = glob($link6);

        if (count($file1) != 0)
        {
            $fotoDiriExist = fopen($file1[0], 'r');
        }
        elseif (count($file2) != 0)
        {
            $fotoDiriExist = fopen($file2[0], 'r');
        }
        elseif (count($file3) != 0)
        {
            $fotoDiriExist = fopen($file3[0], 'r');
        }
        elseif (count($file4) != 0)
        {
            $fotoDiriExist = fopen($file4[0], 'r');
        }
        elseif (count($file5) != 0)
        {
            $fotoDiriExist = fopen($file5[0], 'r');
        }
        elseif (count($file6) != 0)
        {
            $fotoDiriExist = fopen($file6[0], 'r');
        }
        else
        {
            $fotoDiriExist = NULL;
        }

        return $fotoDiriExist;
    }

    private function cekFotoKtpBorrowerExist($userId)
    {
        $link1 = '../storage/app/public/borrower/'.$userId.'/*pic_brw_ktp.jpeg';
        $link2 = '../storage/app/public/borrower/'.$userId.'/*pic_brw_ktp.jpg';
        $link3 = '../storage/app/public/borrower/'.$userId.'/*pic_brw_ktp.bmp';
        $link4 = '../storage/app/public/borrower/'.$userId.'/*pic_brw_ktp.png';
        $link5 = '../storage/app/public/borrower/'.$userId.'/*pic_brw_ktp.JPG';
        $link6 = '../storage/app/public/borrower/'.$userId.'/*pic_brw_ktp.JPEG';

        $file1 = glob($link1);
        $file2 = glob($link2);
        $file3 = glob($link3);
        $file4 = glob($link4);
        $file5 = glob($link5);
        $file6 = glob($link6);

        if (count($file1) != 0)
        {
            $fotoKtpExist = fopen($file1[0], 'r');
        }
        elseif (count($file2) != 0)
        {
            $fotoKtpExist = fopen($file2[0], 'r');
        }
        elseif (count($file3) != 0)
        {
            $fotoKtpExist = fopen($file3[0], 'r');
        }
        elseif (count($file4) != 0)
        {
            $fotoKtpExist = fopen($file4[0], 'r');
        }
        elseif (count($file5) != 0)
        {
            $fotoKtpExist = fopen($file5[0], 'r');
        }
        elseif (count($file6) != 0)
        {
            $fotoKtpExist = fopen($file6[0], 'r');
        }
        else
        {
            $fotoKtpExist = NULL;
        }

        return $fotoKtpExist;
    }

    public function registerDigiSignBorrower($userID){

       
        $getDataBorrower = BorrowerDetails::leftJoin('brw_users','brw_users.brw_id','=','brw_users_details.brw_id')->where('brw_users.brw_id',$userID)->first();
       //var_dump($getDataBorrower);die;
        $dataJenisKelamin = $getDataBorrower->jns_kelamin !== null ? MasterJenisKelamin::where('id_jenis_kelamin','=',$getDataBorrower->jns_kelamin)->first() : null;
        //echo json_encode($dataJenisKelamin);die;
        $dataKotaProvinsi = MasterProvinsi::where('kode_kota',$getDataBorrower->kota)->first();
        //echo json_encode($dataKotaProvinsi);die;
        
        $tipe_borrower = $getDataBorrower->brw_type;
        if ($tipe_borrower == 1 || $tipe_borrower == 3)
        {
            $dataTglLahir = explode('-',$getDataBorrower->tgl_lahir);
            $tgl =  $dataTglLahir[0];
            $bln = $dataTglLahir[1];
            $thn = $dataTglLahir[2];
            //echo $tgl;die;
            if (strlen($tgl) == 1) {$tgl_new = '0'.$tgl;} else {$tgl_new = $tgl;}
            if (strlen($bln) == 1) {$bln_new = '0'.$bln;} else {$bln_new = $bln;}

        }
        else
        {
            $tgl_new = '00';
            $bln_new = '00';
            $thn = '0000';
        }

        // $data_user = $getDataBorrower->brw_id;
        $data_provider = 1;
        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),
                            'alamat' => $getDataBorrower->alamat,
                            'jenis_kelamin' => $dataJenisKelamin !== null ? $dataJenisKelamin->jenis_kelamin : '-',
                            'kecamatan' => $getDataBorrower->kecamatan,
                            'kelurahan' => $getDataBorrower->kelurahan,
                            'kode-pos' => $getDataBorrower->kode_pos,
                            'kota' => $dataKotaProvinsi->nama_kota,
                            'nama' => $getDataBorrower->nama,
                            'tlp' => $getDataBorrower->no_tlp,
                            'tgl_lahir' => $tgl_new.'-'.$bln_new.'-'.$thn,
                            'provinci' => $dataKotaProvinsi->nama_provinsi,
                            'idktp' => $getDataBorrower->ktp,
                            'tmp_lahir' => $getDataBorrower->tempat_lahir,
                            'email' => $getDataBorrower->email,
                            'npwp' => $getDataBorrower->npwp,
                            'redirect' => true
                        ]
                    ];

        $jsonFile = json_encode($data_json);
         

        $fotoDiri = $this->cekFotoDiriBorrowerExist($getDataBorrower->brw_id);
        //var_dump($fotoDiri);die;

        $fotoKtp = $this->cekFotoKtpBorrowerExist($getDataBorrower->brw_id);
        
        $multipart_form =   [
                                [
                                    'name' => 'jsonfield',
                                    'contents' => $jsonFile
                                ],
                                [
                                    'name' => 'fotodiri',
                                    'contents' => $fotoDiri
                                ],
                                [
                                    'name' => 'fotoktp',
                                    'contents' => $fotoKtp
                                ],
                                [
                                    'name' => 'ttd',
                                    'contents' => NULL
                                ],
                                [
                                    'name' => 'fotonpwp',
                                    'contents' => NULL
                                ]  
                            ];
        $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
        $cek = $client->post(config('app.api_digisign').'REG-MITRA.html',[
                'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                'Authorization' => config('app.authorization').' '.config('app.token')
                            ],
                
                'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                'verify' => false
            ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($getDataBorrower->email,$getNotif); 

        return response()->json($response_API);
        
    }


    public function sendDigiSignBorrower($userId, $id_proyek){
        
        $getDataBorrower = BorrowerDetails::leftJoin('brw_users','brw_users.brw_id','=','brw_users_details.brw_id')
                                        ->where('brw_users.brw_id',$userId)
                                        ->first();
                                        
        $getDataTaufiqSign = DetilInvestor::leftJoin('investor','investor.id','=','detil_investor.investor_id')
                                        ->where('investor.email',config('app.email_pak_taufiq'))
                                        ->first();
        $getDataProyek = Proyek::where('id',$id_proyek)->first();
        $pendanaan = $getDataProyek->total_need;

        $date = Carbon::now()->format('Ymd');
        $idBorrower = $getDataBorrower->brw_id;
        $document_id = 'borrowerKontrak_'.$date.'_'.$idBorrower.'_'.$id_proyek;
        $type_borrower = $getDataBorrower->brw_type;
        

        if ($type_borrower == 1 || $type_borrower == 3)
        {
            $startx = 145;
            $starty = 600;
            $size_x = 75;
            $size_y = 50;
            $page = 13;

            $llx = $startx;
            $lly = $starty;
            $urx = $llx+$size_x;
            $ury = $lly+$size_y;

            $startx2 = 360;
            $starty2 = 600;
            $size_x2 = 75;
            $size_y2 = 50;

            $llx2 = $startx2;
            $lly2 = $starty2;
            $urx2 = $llx2+$size_x2;
            $ury2 = $lly2+$size_y2;
        }
        else
        {
            $startx = 145;
            $starty = 620;
            $size_x = 75;
            $size_y = 50;
            $page = 13;

            $llx = $startx;
            $lly = $starty;
            $urx = $llx+$size_x;
            $ury = $lly+$size_y;

            $startx2 = 360;
            $starty2 = 620;
            $size_x2 = 75;
            $size_y2 = 50;

            $llx2 = $startx2;
            $lly2 = $starty2;
            $urx2 = $llx2+$size_x2;
            $ury2 = $lly2+$size_y2;
        }
                
        
        $client = new Client();
        $data_json = array();

        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' => $document_id,
                            'redirect' => true,
                            'branch' => 'KANTOR PUSAT',
                            'sequence_option' => false,
                            'send-to' => [
                                            [
                                                'name' => $getDataBorrower->nama,
                                                'email' => $getDataBorrower->email
                                            ]
                            ],
                            'req-sign' => [
                                            [
                                                'name' => $getDataBorrower->nama,
                                                'email' => $getDataBorrower->email,
                                                'aksi_ttd' => 'mt',
                                                'kuser' => '1234567890123456',
                                                'user' => 'ttd1',
                                                'llx' => $llx,
                                                'lly' => $lly,
                                                'urx' => $urx,
                                                'ury' => $ury,
                                                'page' => $page,
                                                'visible' => '1'
                                            ],
                                            [
                                                'name' => $getDataTaufiqSign->nama_investor,
                                                'email' => $getDataTaufiqSign->email,
                                                'aksi_ttd' => 'mt',
                                                'kuser' => '1234567890123456',
                                                'user' => 'ttd2',
                                                'llx' => $llx2,
                                                'lly' => $lly2,
                                                'urx' => $urx2,
                                                'ury' => $ury2,
                                                'page' => $page,
                                                'visible' => '1'
                                            ]
                            ],    
                            'payment' => '3',
                            'visible' => '1',
                            'signing_seq' => 0
                        ]
                    ];
            
        $jsonFile = json_encode($data_json);

        // $this->createDocBorrower($userId);

        if($type_borrower == 1 or $type_borrower == 3){
            $this->createDocBorrower_Individu($userId,$id_proyek);
            $docPDF = fopen('../storage/app/public/akad_borrower/'.$userId.'/PERJANJIAN_PEMBIAYAAN_MURABAHAH_DSI_Penerima_Pembiayaan_PERORANGAN.pdf', 'r');
        }
        
        else{
            $this->createDocBorrower_Perusahaan($userId,$id_proyek);
            $docPDF = fopen('../storage/app/public/akad_borrower/'.$userId.'/PERJANJIAN_PEMBIAYAAN_MURABAHAH_DSI_Penerima_Pembiayaan_PERUSAHAAN.pdf', 'r');
        }
      
        // $docPDF = fopen('../storage/app/public/akad_borrower/'.$userId.'/PERJANJIAN_PEMBIAYAAN_MURABAHAH.pdf', 'r');
             
        $multipart_form =   [  
                                [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                                ],
                                [
                                   'name' => 'file',
                                   'contents' => $docPDF
                                ]
                            
             
                            ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'SendDocMitraAT.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($getDataBorrower->email,$getNotif);

        $this->logAkadDigiSignBorrower($idBorrower,0,$id_proyek,1,$pendanaan,'kirim',$document_id);

        return response()->json($response_API);
    }

    public function signDigiSignBorrower($userId)
    {
        $getDataBorrower = BorrowerDetails::leftJoin('brw_users','brw_users.brw_id','=','brw_users_details.brw_id')
                                        ->where('brw_users.brw_id',$userId)
                                        ->first();
        
        $date = Carbon::now()->format('Ymd');
        $idBorrower = $getDataBorrower->brw_id;
        $document_id = 'borrowerKontrak_'.$date.''.$idBorrower;
        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' =>$document_id,                                
                            'email_user' => $getDataBorrower->email,
                            'view_only' => false 
                             
                        ]
                    ];
        $jsonFile = json_encode($data_json);
        $multipart_form = [
                               [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                               ] 
             
         ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'gen/genSignPage.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($getDataBorrower->email,$getNotif);

        return response()->json($response_API);
    }

    public function signDigiSignBorrower_Individu($userId)
    {
        $getDataBorrower = BorrowerDetails::leftJoin('brw_users','brw_users.brw_id','=','brw_users_details.brw_id')
                                        ->where('brw_users.brw_id',$userId)
                                        ->first();
        
        $date = Carbon::now()->format('Ymd');
        $idBorrower = $getDataBorrower->brw_id;
        $document_id = 'borrowerKontrak_'.$date.''.$idBorrower;
        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' =>$document_id,                                
                            'email_user' => $getDataBorrower->email,
                            'view_only' => false 
                             
                        ]
                    ];
        $jsonFile = json_encode($data_json);
        $multipart_form = [
                               [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                               ] 
             
         ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'gen/genSignPage.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($getDataBorrower->email,$getNotif);    

        return response()->json($response_API);
    }

    public function downloadDigiSignBorrower(Request $req)
    {
        $getDocId = LogAkadDigiSignBorrower::where('brw_id',$req->id)
                                            ->where('id_proyek',$req->proyek_id)
                                            ->orderBy('id_log_akad_borrower','desc')
                                            ->first();
        $getDataBorrower = Borrower::where('brw_id',$getDocId->brw_id)->first();

        $emailBorrower = $getDataBorrower->email;

        $doc_id = $getDocId->document_id;
        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' => $doc_id,                                
                        ]
                    ];
        $jsonFile = json_encode($data_json);
        $multipart_form = [
                               [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                               ] 
             
         ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'DWMITRA.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($emailBorrower,$getNotif); 

        return response()->json($response_API);
    }

    public function downloadBase64DigiSignBorrower(Request $req)
    {
        $getDocId = LogAkadDigiSignBorrower::where('brw_id',$req->id)
                                            ->where('id_proyek',$req->proyek_id)
                                            ->orderBy('id_log_akad_borrower','desc')
                                            ->first();
        $getDataBorrower = Borrower::where('brw_id',$getDocId->brw_id)->first();

        $emailBorrower = $getDataBorrower->email;

        $doc_id = $getDocId->document_id;
        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' => $doc_id,                                
                        ]
                    ];
        $jsonFile = json_encode($data_json);
        $multipart_form = [
                               [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                               ] 
             
         ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'DWMITRA64.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($emailBorrower,$getNotif);  

        return response()->json($response_API);
    }

    public function downloadBase64DigiSignMurobahahBorrower(Request $req)
    {
        $getDocId = LogAkadDigiSignBorrower::where('id_proyek',$req->proyek_id)
                                            ->where('investor_id', $req->investor_id)
                                            ->orderBy('id_log_akad_borrower','desc')
                                            ->first();
        $getDataBorrower = Borrower::where('brw_id',$getDocId->brw_id)->first();

        $emailBorrower = $getDataBorrower->email;
        
        $doc_id = $getDocId->document_id;
        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' => $doc_id,                                
                        ]
                    ];
        $jsonFile = json_encode($data_json);
        $multipart_form = [
                               [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                               ] 
             
         ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'DWMITRA64.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];
        // $getResponse = json_decode($response_API['status_all'],true);
        // if (array_key_exists("JSONFile",$getResponse))
        // {
        //    $getNotif = $getResponse['JSONFile']['notif'];
        // }
        // else
        // {
        //    $getNotif = $getResponse['notif'];
        // }
        
        // $this->logDigiSignResponse($emailBorrower,$getNotif);   

        return response()->json($response_API);
    }
    
    public function createDocBorrower_Individu($userID,$idProyek)
    {
        if($userID)
        {
            $getDataBorrower    = Borrower::leftJoin('brw_users_details','brw_users_details.brw_id','=','brw_users.brw_id')
                                    ->where('brw_users.brw_id',$userID)
                                    ->first();
            // $getDataPendanaan   = BorrowerPendanaan::leftJoin('brw_tipe_pendanaan','brw_tipe_pendanaan.tipe_id','=','brw_pendanaan.pendanaan_tipe')
            //                                         ->where('brw_pendanaan.brw_id',$userID)
            //                                         ->first(['brw_tipe_pendanaan.pendanaan_nama','brw_pendanaan.*']);
            $getRekening        = BorrowerRekening::leftJoin("m_bank", "m_bank.kode_bank", "=", "brw_rekening.brw_kd_bank")->where('brw_rekening.brw_id',$userID)->first();
            
            
            $getPekerjaan = MasterPekerjaan::where('id_pekerjaan',$getDataBorrower->pekerjaan)->first();

            $getDataProyek = $idProyek !== null ? Proyek::where('id',$idProyek)->first() : null;
            $getDataPendanaanAktif = $getDataProyek !== null ? PendanaanAktif::where('proyek_id',$getDataProyek->id)->sum('total_dana') : null;
            $getDataBank = MasterBank::where('kode_bank',$getRekening->brw_kd_bank)->first();
            
            $getJaminan= BorrowerJaminan::leftJoin('brw_pendanaan','brw_jaminan.pendanaan_id','=','brw_pendanaan.pendanaan_id')
                                    ->leftJoin('m_jenis_jaminan', 'm_jenis_jaminan.id_jenis_jaminan', '=','brw_jaminan.jaminan_jenis')
                                    ->where('brw_pendanaan.brw_id',$userID)
                                    ->first();

            $marginProyek = !empty($getDataProyek) ? number_format($getDataProyek->profit_margin,0,'','') : 0;
            $totalMargin = $marginProyek + 5;
            $perhitunganMargin = $totalMargin/100 * $getDataPendanaanAktif;
            $totalHarga = $getDataPendanaanAktif + $perhitunganMargin;
            //echo json_encode($getJenis_Bukti_Kepemilikan_Jaminan);die;
            //$getJenis_Bukti_Kepemilikan_Jaminan= MasterJenisJaminan::where('jaminan_jenis',$getDataPendanaan->jaminan_id)->first();
            

            $nama = $getDataBorrower->nama;
            $no_ktp = $getDataBorrower->ktp;
            $alamat = $getDataBorrower->alamat;
            $pekerjaan = $getPekerjaan->pekerjaan;
            
            $Nomor_SP3 = '-';
            $Tanggal_SP3 = '-';
            $Nomor_Waad = '-';
            $Tanggal_Waad = '-';
            
            $Jenis_Obyek_Pembiayaan = !empty($getDataProyek) ? $getDataProyek->nama : '-';
            $Alamat_Proyek =  $getDataProyek !== null ? $getDataProyek->alamat : '-';
            $Jumlah_Plafond = $getRekening !== null ? $getRekening->total_plafon : 0;
            $Harga_Pokok = $getDataPendanaanAktif !== null ? $getDataPendanaanAktif : 0;
            $Jumlah_Uang_Muka = 0;
            $Jumlah_Margin_Pembiayaan = $perhitunganMargin;
            $Harga_Jual = $totalHarga;
            $Biaya_Administrasi = 0;
            $Jangka_Waktu_Pembiayaan =  $getDataProyek !== null ? $getDataProyek->tenor_waktu : 0;
            $Tanggal_Akad = Carbon::now()->format('d-m-Y');
            $Tanggal_Jatuh_Tempo = $getDataProyek !== null ? Carbon::parse($getDataProyek->tgl_selesai)->format('d-m-Y') : 0;
            $Jangka_Waktu = $getDataProyek !== null ? $getDataProyek->tenor_waktu : 0;
 
            $Nominal_Angsuran = 0;
            
            // $Tanggal_Saja_Jatuh_Tempo = substr($Tanggal_Jatuh_Tempo,0,2);
            $Jenis_Jaminan = $getJaminan !== null ? $getJaminan->jenis_jaminan : '-';
            $Alamat_Jaminan = $getJaminan !== null ? $getJaminan->jaminan_detail : '-';
            $Pemilik_Jaminan = $getJaminan !== null ? $getJaminan->jaminan_nama : '-';
            $Nilai_Jaminan = $getJaminan !== null ? $getJaminan->jaminan_nilai : 0;
 
            $Nomor_Rekening = $getRekening->brw_norek;
            
            $Bank_Rekening = $getRekening->nama_bank;
            $Nama_Pemilik_Rekening = $getRekening->brw_nm_pemilik;
            //$terbilang =  ucwords(Terbilang::make($Jangka_Waktu_Pembiayaan,''));
            
            $tgl_sekarang = date("d-n-Y");
            $data_tgl = !empty($tgl_sekarang) ? explode("-",$tgl_sekarang) : null;
            // tgl
            $cek_tgl = 0;
            if($data_tgl !== null && $data_tgl !== '')
            {
              if($data_tgl[0] !== null && $data_tgl[0] !== '')
              {
                if(strlen($data_tgl[0])  == 2)
                {
                  if($data_tgl[0][0] == 0)
                  {
                    $cek_tgl = $data_tgl[0][1];
                  }
                  else
                  {
                    $cek_tgl = $data_tgl[0];
                  }
                }
                else
                {
                  $cek_tgl = $data_tgl[0];
                }
              }
              else
              {
                $cek_tgl = 0;
              }
            }
            else
            {
                $cek_tgl = 0;
            }
            // end tgl
            // bulan
            $data_bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
            for($x=1;$x<=12;$x++)
            {
                if ($x == $data_tgl[1])
                {
                    $cek_bln = $data_bulan[$x-1];
                }
            }
            // end bulan
            $tgl_bln_thn = $cek_tgl.' '.$cek_bln.' '.$data_tgl[2];

            $noAkad = $this->generateNoAkadBorrower($idProyek);

            $phpWordObj = new PhpWord();
            $section = $phpWordObj->addSection();
            
            $fontStyle = array('bold' => true, 'align' => 'center');
            $table = $section->addTable();
            for ($r = 1; $r <= 8; $r++) {
                if ($r == 1)
                {
                    $table->addRow();
                    $table->addCell(1750)->addText("No",$fontStyle);
                    $table->addCell(1750)->addText("Nama",$fontStyle);
                    $table->addCell(1750)->addText("Alamat",$fontStyle);
                    $table->addCell(1750)->addText("No Telp",$fontStyle);
                    $table->addCell(1750)->addText("Keterangan",$fontStyle);
                }
                else
                {
                    $table->addRow();
                    for ($c = 1; $c <= 5; $c++) {
                        $table->addCell(1750)->addText("tes");
                    }
                }
            }

            // Create writer to convert document to xml
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWordObj, 'Word2007');

            // Get all document xml code
            $fullxml = $objWriter->getWriterPart('Document')->write();

            // Get only table xml code
            $tablexml = preg_replace('/^[\s\S]*(<w:tbl\b.*<\/w:tbl>).*/', '$1', $fullxml);

            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/public/akad_template/PERJANJIAN_PEMBIAYAAN_MURABAHAH_DSI_Penerima_Pembiayaan_PERORANGAN.docx'));
             
            $templateProcessor->setValue([  'Nama_Borrowers',
                                            'Nomor_Perjanjian',
                                            'Nomor_KTP_Borrowers',
                                            'Alamat_Borrowers',
                                            'Pekerjaan_Borrowers',
                                            'Nomor_SP3',
                                            'Tanggal_SP3',  
                                            'Nomor_Waad',
                                            'Tanggal_Waad',
                                            'Jenis_Obyek_Pembiayaan/Proyek',
                                            'Alamat_Proyek',
                                            'Jumlah_Plafond',
                                            'Harga_Pokok',
                                            'Jumlah_Uang_Muka',
                                            'Jumlah_Margin_Pembiayaan',
                                            'Harga_Jual',
                                            'Biaya_Administrasi',
                                            'Jangka_Waktu_Pembiayaan',
                                            'Jangka_Waktu',
                                            'Tanggal_Akad',
                                            'Tanggal_Jatuh_Tempo',
                                            'Jangka_Waktu_Pembiayaan',
                                            'Nominal_Angsuran',
                                            'Jenis_Jaminan',
                                            'Alamat_Jaminan',
                                            'Pemilik_Jaminan',
                                            'Nilai_Jaminan',
                                            'Nomor_Rekening',
                                            'Bank_Rekening',
                                            'Nama_Pemilik_Rekening',
                                            'terbilang',                                        
                                            'Tanggal_Bulan_Tahun'
                                        ], 
                                        [
                                            $nama,
                                            $noAkad,
                                            $no_ktp,
                                            $alamat,
                                            $pekerjaan,
                                            $Nomor_SP3,
                                            $Tanggal_SP3,
                                            $Nomor_Waad,
                                            $Tanggal_Waad,
                                            $Jenis_Obyek_Pembiayaan,
                                            $Alamat_Proyek,
                                            $Jumlah_Plafond,
                                            $Harga_Pokok,
                                            $Jumlah_Uang_Muka,
                                            $Jumlah_Margin_Pembiayaan,
                                            $Harga_Jual,
                                            $Biaya_Administrasi,
                                            $Jangka_Waktu_Pembiayaan,
                                            $Jangka_Waktu,
                                            $Tanggal_Akad,
                                            $Tanggal_Jatuh_Tempo,
                                            $Jangka_Waktu_Pembiayaan,
                                            $Nominal_Angsuran,
                                            $Jenis_Jaminan,
                                            $Alamat_Jaminan,
                                            $Pemilik_Jaminan,
                                            $Nilai_Jaminan,
                                            $Nomor_Rekening,
                                            $Bank_Rekening,
                                            $Nama_Pemilik_Rekening,
                                            '0',
                                            $tgl_bln_thn
                                        ]);
            
            Storage::disk('public')->makeDirectory('akad_borrower/'.$userID);
            
            $templateProcessor->saveAs(storage_path('app/public/akad_borrower/'.$userID.'/PERJANJIAN_PEMBIAYAAN_MURABAHAH_DSI_Penerima_Pembiayaan_PERORANGAN.docx'));
            shell_exec('unoconv -f pdf '.base_path('storage/app/public/akad_borrower/'.$userID.'/PERJANJIAN_PEMBIAYAAN_MURABAHAH_DSI_Penerima_Pembiayaan_PERORANGAN.docx').' '.base_path('storage/app/public/akad_borrower/'.$userID));

            return ['status' => 'Berhasil'];
        }
        else
        {
            return ['status' => 'Gagal'];
        }
    }

    public function createDocBorrower_Perusahaan($userID,$idProyek)
    {
        if($userID)
        {
            $getDataBorrower    = Borrower::leftJoin('brw_users_details','brw_users_details.brw_id','=','brw_users.brw_id')
                                    ->where('brw_users.brw_id',$userID)
                                    ->first();
            // $getDataPendanaan   = BorrowerPendanaan::leftJoin('brw_tipe_pendanaan','brw_tipe_pendanaan.tipe_id','=','brw_pendanaan.pendanaan_tipe')
            //                                         ->where('brw_pendanaan.brw_id',$userID)
            //                                         ->first(['brw_tipe_pendanaan.pendanaan_nama','brw_pendanaan.*']);
            $getRekening        = BorrowerRekening::leftJoin("m_bank", "m_bank.kode_bank", "=", "brw_rekening.brw_kd_bank")->where('brw_rekening.brw_id',$userID)->first();

            $getPekerjaan = MasterPekerjaan::where('id_pekerjaan',$getDataBorrower->pekerjaan)->first();

            $getDataProyek = $idProyek !== null ? Proyek::where('id',$idProyek)->first() : null;
            $getDataPendanaanAktif = $getDataProyek !== null ? PendanaanAktif::where('proyek_id',$getDataProyek->id)->sum('total_dana') : null;
            $getDataBank = MasterBank::where('kode_bank',$getRekening->brw_kd_bank)->first();
            
            $getJaminan= BorrowerJaminan::leftJoin('brw_pendanaan','brw_jaminan.pendanaan_id','=','brw_pendanaan.pendanaan_id')
                                    ->leftJoin('m_jenis_jaminan', 'm_jenis_jaminan.id_jenis_jaminan', '=','brw_jaminan.jaminan_jenis')
                                    ->where('brw_pendanaan.brw_id',$userID)
                                    ->first();

            $getProyekInvestor = PendanaanAktif::leftJoin('proyek','proyek.id','=','pendanaan_aktif.proyek_id')
                                                ->leftJoin('m_no_akad_investor','m_no_akad_investor.investor_id','=','pendanaan_aktif.investor_id')
                                                 ->leftJoin('detil_investor','detil_investor.investor_id','=','pendanaan_aktif.investor_id')
                                                ->where('pendanaan_aktif.proyek_id',$idProyek)
                                                ->where('pendanaan_aktif.status',1)
                                                ->whereNotIn('proyek.id',[\DB::raw('select proyek_id from log_pengembalian_dana group by proyek_id')])
                                                ->get();
            $getJumlahProyekInvestor = PendanaanAktif::leftJoin('proyek','proyek.id','=','pendanaan_aktif.proyek_id')
                                                ->where('pendanaan_aktif.investor_id',$userID)
                                                ->where('pendanaan_aktif.status',1)
                                                ->whereNotIn('proyek.id',[\DB::raw('select proyek_id from log_pengembalian_dana where investor_id = '.$userID.' group by proyek_id')])
                                                ->count('pendanaan_aktif.id');

            $marginProyek = !empty($getDataProyek) ? number_format($getDataProyek->profit_margin,0,'','') : 0;
            $totalMargin = $marginProyek + 5;
            $perhitunganMargin = $totalMargin/100 * $getDataPendanaanAktif;
            $totalHarga = $getDataPendanaanAktif + $perhitunganMargin;
            //echo json_encode($getJenis_Bukti_Kepemilikan_Jaminan);die;
            //$getJenis_Bukti_Kepemilikan_Jaminan= MasterJenisJaminan::where('jaminan_jenis',$getDataPendanaan->jaminan_id)->first();
            

            $nama = $getDataBorrower->nama;
            $nama_badan = $getDataBorrower->nm_bdn_hukum;
            $jabatan = $getDataBorrower->jabatan;
            $alamat = $getDataBorrower->alamat;

            $no_akta = '-';
            $tgl_akta = '-';
            $nama_notaris = '-';
            
            $Nomor_SP3 = '-';
            $Tanggal_SP3 = '-';
            $Nomor_Waad = '-';
            $Tanggal_Waad = '-';
            
            $Jenis_Obyek_Pembiayaan = $getDataProyek !== null ? $getDataProyek->nama : '';
            $Alamat_Proyek =  $getDataProyek !== null ? $getDataProyek->alamat : '-';
            $Jumlah_Plafond = $getRekening !== null ? $getRekening->total_plafon : 0;
            $Harga_Pokok = $getDataPendanaanAktif !== null ? $getDataPendanaanAktif : 0;
            $Jumlah_Uang_Muka = 0;
            $Jumlah_Margin_Pembiayaan = $perhitunganMargin;
            $Harga_Jual = $totalHarga;
            $Biaya_Administrasi = 0;
            $Jangka_Waktu_Pembiayaan = $getDataProyek !== null ? $getDataProyek->tenor_waktu : 0;
            $Tanggal_Akad = Carbon::now()->format('d-m-Y');
            $Tanggal_Jatuh_Tempo = $getDataProyek !== null ? Carbon::parse($getDataProyek->tgl_selesai)->format('d-m-Y') : 0;
            $Jangka_Waktu = $getDataProyek !== null ? $getDataProyek->tenor_waktu : 0;
 
            $Nominal_Angsuran = 0;
            
            // $Tanggal_Saja_Jatuh_Tempo = substr($Tanggal_Jatuh_Tempo,0,2);
            $Jenis_Jaminan = $getJaminan !== null ? $getJaminan->jenis_jaminan : '-';
            $Alamat_Jaminan = $getJaminan !== null ? $getJaminan->jaminan_detail : '-';
            $Pemilik_Jaminan = $getJaminan !== null ? $getJaminan->jaminan_nama : '-';
            $Nilai_Jaminan = $getJaminan !== null ? $getJaminan->jaminan_nilai : 0;
 
            $Nomor_Rekening = $getRekening->brw_norek;
            
            $Bank_Rekening = $getRekening->nama_bank;
            $Nama_Pemilik_Rekening = $getRekening->brw_nm_pemilik;
            $Terbilang_Jangka_Waktu =  ucwords(Terbilang::make($Jangka_Waktu_Pembiayaan,''));

            $totalProyek = !empty($getJumlahProyekInvestor) ? $getJumlahProyekInvestor : 0;
            
            $tgl_sekarang = date("d-n-Y");
            $data_tgl = !empty($tgl_sekarang) ? explode("-",$tgl_sekarang) : null;
            // tgl
            $cek_tgl = 0;
            if($data_tgl !== null && $data_tgl !== '')
            {
              if($data_tgl[0] !== null && $data_tgl[0] !== '')
              {
                if(strlen($data_tgl[0])  == 2)
                {
                  if($data_tgl[0][0] == 0)
                  {
                    $cek_tgl = $data_tgl[0][1];
                  }
                  else
                  {
                    $cek_tgl = $data_tgl[0];
                  }
                }
                else
                {
                  $cek_tgl = $data_tgl[0];
                }
              }
              else
              {
                $cek_tgl = 0;
              }
            }
            else
            {
                $cek_tgl = 0;
            }
            // end tgl
            // bulan
            $data_bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
            for($x=1;$x<=12;$x++)
            {
                if ($x == $data_tgl[1])
                {
                    $cek_bln = $data_bulan[$x-1];
                }
            }
            // end bulan
            $tgl_bln_thn = $cek_tgl.' '.$cek_bln.' '.$data_tgl[2];
            $no_hari = date("N");
            
            switch ($no_hari) {
                case 1:
                    $hari_transaksi = 'Senin';
                    break;
                case 2:
                    $hari_transaksi = 'Selasa';
                    break;
                case 3:
                    $hari_transaksi = 'Rabu';
                    break;
                case 4:
                    $hari_transaksi = 'Kamis';
                    break;
                case 5:
                    $hari_transaksi = 'Jumat';
                    break;
                case 6:
                    $hari_transaksi = 'Sabtu';
                    break;
                case 7:
                    $hari_transaksi = 'Minggu';
                    break;
                default:
                    $hari_transaksi = 'Libur';
                    break;
            };

            $noAkad = $this->generateNoAkadBorrower($idProyek);

            $phpWordObj = new PhpWord();
            $section = $phpWordObj->addSection();
            
            $fontStyle = [
                            'bold' => true, 
                            'align' => 'center'
                         ];

            $borderStyle = [
                                'borderTopColor' =>'ff0000',
                                'borderTopSize' => 6,
                                'borderRightColor' =>'ff0000',
                                'borderRightSize' => 6,
                                'borderBottomColor' =>'ff0000',
                                'borderBottomSize' => 6,
                                'borderLeftColor' =>'ff0000',
                                'borderLeftSize' => 6,
                           ];

            $table = $section->addTable();
            $table->addRow();
            $table->addCell(700,$borderStyle)->addText("No",$fontStyle);
            $table->addCell(1100,$borderStyle)->addText("Nama Pemberi Pembiayaan",$fontStyle);
            $table->addCell(1750,$borderStyle)->addText("Jumlah Dana yang Dibiayai",$fontStyle);
            $table->addCell(1600,$borderStyle)->addText("Margin Keuntungan",$fontStyle);
            $table->addCell(1600,$borderStyle)->addText("No Proyek yang Dibiayai",$fontStyle);
            $table->addCell(1300,$borderStyle)->addText("No Surat Kuasa",$fontStyle);
            for ($r = 0; $r < $totalProyek; $r++) {
                
                    $table->addRow();
                    $table->addCell(700,$borderStyle)->addText($r+1);
                    $table->addCell(1100,$borderStyle)->addText($getProyekInvestor[$r]['nama_investor']);
                    $table->addCell(1750,$borderStyle)->addText(number_format($getProyekInvestor[$r]['total_dana'],0,'','.'));
                    $table->addCell(1600,$borderStyle)->addText(number_format($getProyekInvestor[$r]['profit_magin'],0,'','').'%');
                    $table->addCell(1600,$borderStyle)->addText(explode(' ',$getProyekInvestor[$r]['nama'])[1]);
                    $table->addCell(1300,$borderStyle)->addText($getProyekInvestor[$r]['no_akad_inv'].'/DSI/AWBL/'.$getProyekInvestor[$r]['bln_akad_inv'].'/'.$getProyekInvestor[$r]['thn_akad_inv']);
                
            }

            // Create writer to convert document to xml
            // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWordObj, 'Word2007');

            // Get all document xml code
            // $fullxml = $objWriter->getWriterPart('Document')->write();

            // Get only table xml code
            // $tablexml = preg_replace('/^[\s\S]*(<w:tbl\b.*<\/w:tbl>).*/', '$1', $fullxml);

            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/public/akad_template/PERJANJIAN_PEMBIAYAAN_MURABAHAH_DSI_Penerima_Pembiayaan_PERUSAHAAN.docx'));
             
            $templateProcessor->setValue([  'Nama_Borrowers',
                                            'Nomor_Perjanjian',
                                            'Hari_Sekarang',
                                            'Tanggal_Sekarang',
                                            'Alamat_Borrowers',
                                            'Nama_Direktur',
                                            'Jabatan_Direktur',
                                            'Nomor_Akta_Pendirian',
                                            'Tanggal_Pendirian',
                                            'Nama_Notaris',
                                            'Nomor_SP3',
                                            'Tanggal_SP3',  
                                            // 'Nomor_Waad',
                                            // 'Tanggal_Waad',
                                            'Jenis_Obyek_Pembiayaan/Proyek',
                                            // 'Alamat_Proyek',
                                            // 'Jumlah_Plafond',
                                            'Harga_Pokok',
                                            // 'Jumlah_Uang_Muka',
                                            'Jumlah_Margin_Pembiayaan',
                                            'Harga_Pengembalian',
                                            // 'Biaya_Administrasi',
                                            'Jangka_Waktu_Pembiayaan',
                                            // 'Jangka_Waktu',
                                            'Tanggal_Hari_Ini',
                                            'Tanggal_Jatuh_Tempo',
                                            // 'Jangka_Waktu_Pembiayaan',
                                            'Jumlah_Angsuran',
                                            // 'Nominal_Angsuran',
                                            'Tanggal_Jatuh_Tempo_Angsuran',
                                            'Jenis_Jaminan',
                                            'Legalitas_Jaminan',
                                            // 'Alamat_Jaminan',
                                            'Nama_Pemilik_Jaminan',
                                            'Nilai_Jaminan',
                                            'Nomor_Rekening',
                                            'Bank_Transfer',
                                            'Nama_Rekening',
                                            'Jangka_Waktu',
                                            'Terbilang_Jangka_Waktu',
                                            'Nama_PT_Borrower'                                      
                                            // 'Tanggal_Bulan_Tahun'
                                        ], 
                                        [
                                            $nama_badan,
                                            $noAkad,
                                            $hari_transaksi,
                                            $Tanggal_Akad,
                                            $alamat,
                                            $nama,
                                            $jabatan,
                                            $no_akta,
                                            $tgl_akta,
                                            $nama_notaris,
                                            $Nomor_SP3,
                                            $Tanggal_SP3,
                                            // $Nomor_Waad,
                                            // $Tanggal_Waad,
                                            $Jenis_Obyek_Pembiayaan,
                                            // $Alamat_Proyek,
                                            // $Jumlah_Plafond,
                                            $Harga_Pokok,
                                            // $Jumlah_Uang_Muka,
                                            $Jumlah_Margin_Pembiayaan,
                                            $Harga_Jual,
                                            // $Biaya_Administrasi,
                                            $Jangka_Waktu_Pembiayaan,
                                            // $Jangka_Waktu,
                                            $Tanggal_Akad,
                                            $Tanggal_Jatuh_Tempo,
                                            // $Jangka_Waktu_Pembiayaan,
                                            $Jangka_Waktu_Pembiayaan,
                                            // $Nominal_Angsuran,
                                            '-',
                                            $Jenis_Jaminan,
                                            '-',
                                            // $Alamat_Jaminan,
                                            $Pemilik_Jaminan,
                                            $Nilai_Jaminan,
                                            $Nomor_Rekening,
                                            $Bank_Rekening,
                                            $Nama_Pemilik_Rekening,
                                            $Jangka_Waktu_Pembiayaan,
                                            $Terbilang_Jangka_Waktu,
                                            $nama_badan
                                            // $tgl_bln_thn
                                        ]);
            $templateProcessor->setComplexBlock('Data_Tabel', $table);
            
            Storage::disk('public')->makeDirectory('akad_borrower/'.$userID);
            
            $templateProcessor->saveAs(storage_path('app/public/akad_borrower/'.$userID.'/PERJANJIAN_PEMBIAYAAN_MURABAHAH_DSI_Penerima_Pembiayaan_PERUSAHAAN.docx'));
            shell_exec('unoconv -f pdf '.base_path('storage/app/public/akad_borrower/'.$userID.'/PERJANJIAN_PEMBIAYAAN_MURABAHAH_DSI_Penerima_Pembiayaan_PERUSAHAAN.docx').' '.base_path('storage/app/public/akad_borrower/'.$userID));
            

            return ['status' => 'Berhasil'];
        }
        else
        {
            return ['status' => 'Gagal'];
        }

    }



    #SP3
    private function logSP3Borrower($user_id,$no_sp3,$proyek_id,$total_pendanaan,$status)
    {       
        if ($user_id)
        {
            $cekLog = LogSP3Borrower::where('brw_id',$user_id)
                                    ->where('id_proyek',$proyek_id)
                                    ->count();
            if ($cekLog != 0)
            {
                $dataLog = LogSP3Borrower::where('brw_id',$user_id)
                                    ->where('id_proyek',$proyek_id)
                                    ->first();
                
                $dataLog->status = $status;

                $dataLog->save();
            }
            else
            {
                $logSP3 = new LogSP3Borrower;
                $logSP3->brw_id = $user_id;
                $logSP3->no_sp3 = $no_sp3;
                $logSP3->id_proyek = $proyek_id;
                $logSP3->total_pendanaan = $total_pendanaan;
                $logSP3->status = $status;

                $logSP3->save();
            }

            $response = ['status' => 'Data Berhasil di Update'];
        }
        else
        {

            $response = ['status' => 'Data Gagal di Update'];
        }
        return $response;
    }

    private function generateNoSP3($id_Proyek)
    {
        $sekarang = explode("-",date('d-n-Y'));
        $tgl = $sekarang[0];
        $bln = $sekarang[1];
        $thn = (string)$sekarang[2];

        switch ($bln) {
            case 1:
                $blnSP3 = 'I';
                break;
            case 2:
                $blnSP3 = 'II';
                break;
            case 3:
                $blnSP3 = 'III';
                break;
            case 4:
                $blnSP3 = 'IV';
                break;
            case 5:
                $blnSP3 = 'V';
                break;
            case 6:
                $blnSP3 = 'VI';
                break;
            case 7:
                $blnSP3 = 'VII';
                break;
            case 8:
                $blnSP3 = 'VIII';
                break;
            case 9:
                $blnSP3 = 'IX';
                break;
            case 10:
                $blnSP3 = 'X';
                break;
            case 11:
                $blnSP3 = 'XI';
                break;
            case 12:
                $blnSP3 = 'XII';
                break;
            default:
                $blnSP3 = 0;
                break;
        }

        $getDataNoSP3 = MasterNoSP3::where('bln_sp3',$blnSP3)->where('thn_sp3',$thn)->first();

        if (!empty($getDataNoSP3))
        {
            $noSP3 = $getDataNoSP3->no_sp3;
            $noSP3 += 1;
            $nextBlnSP3 = $getDataNoSP3->bln_sp3;
            $nextThnSP3 = $getDataNoSP3->thn_sp3;
            if (strlen($noSP3) == 1) {
                $nextNoSP3 = '00'.$noSP3;
            }
            elseif (strlen($noSP3) == 2) {
                $nextNoSP3 = '0'.$noSP3;
            }
            else {
                $nextNoSP3 = $noSP3;
            }

            $getDataNoSP3->no_sp3 = $noSP3;

            $getDataNoSP3->save();
        }
        else
        {
            
            $masterNoSP3 = new MasterNoSP3;
            $masterNoSP3->no_sp3 = 0;
            $masterNoSP3->proyek_id = $id_Proyek;
            $masterNoSP3->bln_sp3 = $blnSP3;
            $masterNoSP3->thn_sp3 = $thn;

            $masterNoSP3->save();

            $nextNoSP3 = '000';
            $nextBlnSP3 = $blnSP3;
            $nextThnSP3 = $thn;
        }

        return $nextNoSP3.'/DSI/SP3/'.$nextBlnSP3.'/'.$nextThnSP3;
    }



    #SP3
    public function createDocSP3($userID,$idProyek)
    {
        if($userID)
        {
            $getDataBorrower    = Borrower::leftJoin('brw_users_details','brw_users_details.brw_id','=','brw_users.brw_id')
                                    ->where('brw_users.brw_id',$userID)
                                    ->first();
            $getDataPendanaan   = BorrowerPendanaan::leftJoin('brw_tipe_pendanaan','brw_tipe_pendanaan.tipe_id','=','brw_pendanaan.pendanaan_tipe')
                                                    ->where('brw_pendanaan.brw_id',$userID)
                                                    ->first(['brw_tipe_pendanaan.pendanaan_nama','brw_pendanaan.*']);

            $getDataProyek = $idProyek !== null ? Proyek::where('id',$idProyek)->first() : null;
            $getDataPendanaanAktif = $getDataProyek !== null ? PendanaanAktif::where('proyek_id',$getDataProyek->id)->sum('total_dana') : null;
            
            $getJaminan= BorrowerJaminan::leftJoin('brw_pendanaan','brw_jaminan.pendanaan_id','=','brw_pendanaan.pendanaan_id')
                                    ->leftJoin('m_jenis_jaminan', 'm_jenis_jaminan.id_jenis_jaminan', '=','brw_jaminan.jaminan_jenis')
                                    ->where('brw_pendanaan.brw_id',$userID)
                                    ->first();

            $nilai_proyek = $getDataProyek !== null ? $getDataProyek->total_need : 0;
            $marginProyek = !empty($getDataProyek) ? number_format($getDataProyek->profit_margin,0,'','') : 0;
            $totalMargin = $marginProyek + 5;
            $perhitunganMargin = $totalMargin/100 * $nilai_proyek;
            $totalHarga = $nilai_proyek + $perhitunganMargin;

            $no_proyek = $getDataProyek !== null ? explode(' ',$getDataProyek->nama)[1] : '';
            $mulai_penggalangan = $getDataProyek !== null ? Carbon::parse($getDataProyek->tgl_mulai_penggalangan) : 0;
            $selesai_penggalangan = $getDataProyek !== null ? Carbon::parse($getDataProyek->tgl_selesai_penggalangan) : 0;
            $jumlah_hari_penggalangan = $mulai_penggalangan->diffInDays($selesai_penggalangan)+1;

            $nama = $getDataBorrower->nama;
            $nama_badan = !empty($getDataBorrower->nm_bdn_hukum) ? $getDataBorrower->nm_bdn_hukum : $getDataBorrower->nama;
            $jabatan = $getDataBorrower->jabatan;
            $alamat = $getDataBorrower->alamat;
            $get_tgl_permohonan = Carbon::parse(explode(' ',$getDataPendanaan->created_at)[0])->format('d-n-Y');
            
            $Jenis_Obyek_Pembiayaan = $getDataProyek !== null ? $getDataProyek->nama : '';
            $Jangka_Waktu_Pembiayaan = $getDataProyek !== null ? $getDataProyek->tenor_waktu : 0;
            $Tanggal_Jatuh_Tempo = $getDataProyek !== null ? Carbon::parse($getDataProyek->tgl_selesai)->format('d-m-Y') : 0;

            $Jenis_Jaminan = $getJaminan !== null ? $getJaminan->jenis_jaminan : '-';
            $No_Jaminan = $getJaminan !== null ? $getJaminan->jaminan_nomor : '-';
            $Nama_Jaminan = $getJaminan !== null ? $getJaminan->jaminan_nama : '-';
 
            $Terbilang_Jangka_Waktu =  ucwords(Terbilang::make($Jangka_Waktu_Pembiayaan,''));
            
            $tgl_sekarang = date("d-n-Y");
            $data_tgl = !empty($tgl_sekarang) ? explode("-",$tgl_sekarang) : null;
            // tgl
            $cek_tgl = 0;
            if($data_tgl !== null && $data_tgl !== '')
            {
              if($data_tgl[0] !== null && $data_tgl[0] !== '')
              {
                if(strlen($data_tgl[0])  == 2)
                {
                  if($data_tgl[0][0] == 0)
                  {
                    $cek_tgl = $data_tgl[0][1];
                  }
                  else
                  {
                    $cek_tgl = $data_tgl[0];
                  }
                }
                else
                {
                  $cek_tgl = $data_tgl[0];
                }
              }
              else
              {
                $cek_tgl = 0;
              }
            }
            else
            {
                $cek_tgl = 0;
            }
            // end tgl
            // bulan
            $data_bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
            for($x=1;$x<=12;$x++)
            {
                if ($x == $data_tgl[1])
                {
                    $cek_bln = $data_bulan[$x-1];
                }
            }
            // end bulan
            $tgl_bln_thn = $cek_tgl.' '.$cek_bln.' '.$data_tgl[2];


            
            $data_tgl_permohonan = !empty($get_tgl_permohonan) ? explode("-",$get_tgl_permohonan) : null;
            // tgl
            $cek_tgl_permohonan = 0;
            if($data_tgl_permohonan !== null && $data_tgl_permohonan !== '')
            {
              if($data_tgl_permohonan[0] !== null && $data_tgl_permohonan[0] !== '')
              {
                if(strlen($data_tgl_permohonan[0])  == 2)
                {
                  if($data_tgl_permohonan[0][0] == 0)
                  {
                    $cek_tgl_permohonan = $data_tgl_permohonan[0][1];
                  }
                  else
                  {
                    $cek_tgl_permohonan = $data_tgl_permohonan[0];
                  }
                }
                else
                {
                  $cek_tgl_permohonan = $data_tgl_permohonan[0];
                }
              }
              else
              {
                $cek_tgl_permohonan = 0;
              }
            }
            else
            {
                $cek_tgl_permohonan = 0;
            }
            // end tgl
            // bulan
            $data_bulan_permohonan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
            for($x=1;$x<=12;$x++)
            {
                if ($x == $data_tgl_permohonan[1])
                {
                    $cek_bln_permohonan = $data_bulan_permohonan[$x-1];
                }
            }
            // end bulan
            $tgl_bln_thn_permohonan = $cek_tgl_permohonan.' '.$cek_bln_permohonan.' '.$data_tgl_permohonan[2];
            
            $noSP3 = $this->generateNoSP3($idProyek);

            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/public/akad_template/SP3.docx'));
             
            $templateProcessor->setValue([  'Nomor_SP3',
                                            'Tanggal_Sekarang',
                                            'Nama_Borrower',
                                            'Alamat_Borrower',
                                            'Nama_Direktur',
                                            'Tanggal_Permohonan',
                                            'Nama_Proyek',
                                            'Jangka_Waktu_Proyek',
                                            'Nilai_Proyek',
                                            'Nilai_Imbal_Hasil',
                                            'Nilai_Pengembalian',
                                            'Sekaligus_Atau_Bertahap',
                                            'Tanggal_Jatuh_Tempo',
                                            'Jumlah_Angsuran',
                                            'Nilai_Angsuran',
                                            'Tanggal_Pembayaran_Angsuran',
                                            'Jangka_Waktu_Pembiayaan',
                                            'Nama_Jaminan',
                                            'Jenis_Jaminan',
                                            'Nomor_Jaminan',
                                            'Pemilik_Jaminan',
                                            'Nomor_Proyek',
                                            'Nilai_Proyek',
                                            'Jumlah_Penggalangan_Dana',
                                            'Katagori_Scoring',
                                            'Imbal_Hasil',
                                        ], 
                                        [
                                            $noSP3,
                                            $tgl_bln_thn,
                                            $nama_badan,
                                            $alamat,
                                            $nama,
                                            $tgl_bln_thn_permohonan,
                                            $Jenis_Obyek_Pembiayaan,
                                            $Jangka_Waktu_Pembiayaan,
                                            $nilai_proyek,
                                            $marginProyek,
                                            $totalHarga,
                                            '-',
                                            $Tanggal_Jatuh_Tempo,
                                            $Jangka_Waktu_Pembiayaan,
                                            0,
                                            '-',
                                            $Jangka_Waktu_Pembiayaan,
                                            $Nama_Jaminan,
                                            $Jenis_Jaminan,
                                            $No_Jaminan,
                                            $nama,
                                            $no_proyek,
                                            $nilai_proyek,
                                            $jumlah_hari_penggalangan,
                                            '-',
                                            $marginProyek,
                                        ]);
            
            Storage::disk('public')->makeDirectory('akad_borrower/'.$userID);
            
            $templateProcessor->saveAs(storage_path('app/public/akad_borrower/'.$userID.'/SP3.docx'));
            shell_exec('unoconv -f pdf '.base_path('storage/app/public/akad_borrower/'.$userID.'/SP3.docx').' '.base_path('storage/app/public/akad_borrower/'.$userID));
            
            $this->logSP3Borrower($userID,$noSP3,$idProyek,$nilai_proyek,1);

            $response = ['status' => 'Berhasil'];
        }
        else
        {
            $response = ['status' => 'Gagal'];
        }

        return response()->json($response);

    }

    private function generateNoAkadBorrower($id_Proyek)
    {
        $sekarang = explode("-",date('d-n-Y'));
        $tgl = $sekarang[0];
        $bln = $sekarang[1];
        $thn = (string)$sekarang[2];

        switch ($bln) {
            case 1:
                $blnAkad = 'I';
                break;
            case 2:
                $blnAkad = 'II';
                break;
            case 3:
                $blnAkad = 'III';
                break;
            case 4:
                $blnAkad = 'IV';
                break;
            case 5:
                $blnAkad = 'V';
                break;
            case 6:
                $blnAkad = 'VI';
                break;
            case 7:
                $blnAkad = 'VII';
                break;
            case 8:
                $blnAkad = 'VIII';
                break;
            case 9:
                $blnAkad = 'IX';
                break;
            case 10:
                $blnAkad = 'X';
                break;
            case 11:
                $blnAkad = 'XI';
                break;
            case 12:
                $blnAkad = 'XII';
                break;
            default:
                $blnAkad = 0;
                break;
        }

        $getDataNoAkad = MasterNoAkadBorrower::where('bln_akad_bor',$blnAkad)->where('thn_akad_bor',$thn)->first();

        if (!empty($getDataNoAkad))
        {
            $noAkad = $getDataNoAkad->no_akad_bor;
            $noAkad += 1;
            $nextBlnAkad = $getDataNoAkad->bln_akad_bor;
            $nextThnAkad = $getDataNoAkad->thn_akad_bor;
            if (strlen($noAkad) == 1) {
                $nextNoAkad = '00'.$noAkad;
            }
            elseif (strlen($noAkad) == 2) {
                $nextNoAkad = '0'.$noAkad;
            }
            else {
                $nextNoAkad = $noAkad;
            }

            $getDataNoAkad->no_akad_bor = $noAkad;

            $getDataNoAkad->save();
        }
        else
        {
            
            $masterNoAkad = new MasterNoAkadBorrower;
            $masterNoAkad->no_akad_bor = 0;
            $masterNoAkad->proyek_id = $id_Proyek;
            $masterNoAkad->bln_akad_bor = $blnAkad;
            $masterNoAkad->thn_akad_bor = $thn;

            $masterNoAkad->save();

            $nextNoAkad = '000';
            $nextBlnAkad = $blnAkad;
            $nextThnAkad = $thn;
        }

        return $nextNoAkad.'/DSI/AMRB/'.$nextBlnAkad.'/'.$nextThnAkad;
    }
 
}