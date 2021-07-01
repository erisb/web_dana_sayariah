<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Webpatser\Uuid\Uuid;
use App\Investor;
use App\DetilInvestor;
use App\RekeningInvestor;
use App\PendanaanAktif;
use App\Proyek;
use App\RDLAccountNumber;
use App\RDLAkunTipe;
use App\RDLAlasan;
use App\RDLCabang;
use App\RDLCifNumber;
use App\RDLKodeBank;
use App\RDLMap;
use App\RDLSumberPendapatan;
use App\RDLTipeCharging;
use App\RDLTitle;
use App\LogBankRDLTransaction;
use Response;

class RDLController extends Controller
{
 
   // generateUUID
   public function uuid(){
      
      $uuid          = (string)Uuid::generate();
      $explode_uuid  = explode('-', $uuid);
      $merge         = $explode_uuid[0].$explode_uuid[1].$explode_uuid[2].$explode_uuid[3].$explode_uuid[4];
      $strtoupper    = strtoupper($merge);
      $substr_uuid   = substr($strtoupper, 0, 16);
    //   syslog(0, "$substr_uuid");
      return $substr_uuid;
      
   }
   
   // generate base64 username:password
   public function base64_usename_password(){
      
      return base64_encode(config('app.username_rdl').':'.config('app.password_rdl'));
      
   }
   
   // generate base64 OUTH_ID:OUTH_SECRET
   public function base64_oauth(){
      
      return base64_encode(config('app.api_key_outh_id_rdl').':'.config('app.api_key_outh_secret_rdl'));
      
   }
   
   //generateToken
   public function generateToken(){
      
      $path = "api/oauth/token";
      $query_param = ['Authorization=Basic '.$this->base64_usename_password()];
      
      $client = new Client();
      $request = $client->post(config('app.url_rdl').':'.config('app.port_rdl')."/".$path, [
         // 'query' => [  
            // 'Authorization' => 'Basic '.$this->base64_usename_password()
         // ],
         http_build_query($query_param),
         'headers' => [  
            'Authorization' => 'Basic '.$this->base64_oauth(),
            'Content-Type' => 'application/x-www-form-urlencoded'
         ],
         'body' => 'grant_type=client_credentials'
      ]);
      $response = $request->getBody();
      $convert = json_decode($response);
      return $convert->{'access_token'};
      
   }
   
   public function generateJWT($array_payload){
      
      // api secret key
      $apiSecretKey = config('app.api_key_secret_rdl'); //please adjusted 
      // Create token payload as a JSON string 
      $array_header = array ('alg' => 'HS256', 'typ' => 'JWT'); 
      $header = JSON_encode($array_header);
      
      $payload = JSON_encode($array_payload, JSON_UNESCAPED_SLASHES);
      // Encode Header to Base64Url String 
      $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header)); 
 
      // Encode Payload to Base64Url String 
      $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload)); 
       
      // Create Signature Hash 
      $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $apiSecretKey, true); 
       
      // Encode Signature to Base64Url String 
      $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature)); 
       
      // Create JWT 
      $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature; 
      return $jwt;
         
   }
   
   // create new investor
   public function RegisterInvestor($investor_id, $kd_bank){
      
      $Investor      = Investor::where('id', $investor_id)->first();
      
      $DetilInvestor    = DetilInvestor::where('investor_id', $investor_id)->first();
      
      $agama         = RDLMap::where('kategori', 'AGAMA')->where('id_dsi', $DetilInvestor->agama_investor == "" ? "1" : $DetilInvestor->agama_investor)->first();
      $isMarried     = RDLMap::where('kategori', 'KAWIN')->where('id_dsi', $DetilInvestor->status_kawin_investor == "" ? "1" : $DetilInvestor->status_kawin_investor )->first();
      $monthlyIncome  = RDLMap::where('kategori', 'PENDAPATAN')->where('id_dsi', $DetilInvestor->pendapatan_investor == "" ? "1" : $DetilInvestor->pendapatan_investor)->first();
      $edu = RDLMap::where('kategori', 'PENDIDIKAN')->where('id_dsi', $DetilInvestor->pendidikan_investor == "" ? "1" : $DetilInvestor->pendidikan_investor)->first();
      $job = RDLMap::where('kategori', 'PEKERJAAN')->where('id_dsi', $DetilInvestor->pekerjaan_investor == "" ? "1" : $DetilInvestor->pekerjaan_investor)->first();
      
      $tgl_lahir  = $DetilInvestor->tgl_lahir_investor == "" ? "01-01-1980": $DetilInvestor->tgl_lahir_investor;
      $date    =  date_create($tgl_lahir);
      $birthDate  = (string)date_format($date,"dmY");
      
      
      if($kd_bank == "009"){
         
         $kode_uuid = $this->uuid();
         $apiSecretKey = config('app.api_key_secret_rdl'); //please adjusted 
      
         // $date    = date('dmY');
         $client = new Client();
         
         
         $jk = $DetilInvestor->jenis_kelamin_investor == "" ? "1": $DetilInvestor->jenis_kelamin_investor;
         
         $jk         = "";
         if($jk == "1"){
            $jk         = "F";
         }else{
            $jk         = "M";
         }
         
         $mobilePhone1 = "";
         $mobilePhone2="";
         if (strlen($DetilInvestor->phone_investor) > 6) {
               
               if (substr($DetilInvestor->phone_investor,0,2)=='08') {
                     
                     $mobilePhone1 = substr($DetilInvestor->phone_investor,0,4);
                     $mobilePhone2 = substr($DetilInvestor->phone_investor,4);
                     
               } else if (substr($DetilInvestor->phone_investor,0,3)=='+62') {
                  // +628116543
                     $mobilePhone1 = '0'.substr($DetilInvestor->phone_investor,3,3);
                     $mobilePhone2 = substr($DetilInvestor->phone_investor,6);
                  
               } 
         }
         
         $i_zipCode = $DetilInvestor->kode_pos_investor;
         $zipCode = strval($i_zipCode);
         if (strlen($zipCode) ==0)
               $zipCode = "11111";
         
         // // // Create token payload as a JSON string 
         $array_payload = array ('request' => 
                        array('header' =>array (
                                 'companyId' => config('app.company_id_rdl'), // mandatory
                                 'parentCompanyId' => '', 
                                 'requestUuid' => $kode_uuid
                              ), // mandatory
                              'title' => (string)'01', // mandatory
                              'firstName' => (string)$DetilInvestor->nama_investor == "" ? "112233444556677" : $DetilInvestor->nama_investor, 
                              'middleName' => (string)$DetilInvestor->nama_investor == "" ? "112233444556677" : $DetilInvestor->nama_investor,
                              'lastName' => (string)$DetilInvestor->nama_investor == "" ? "112233444556677" : $DetilInvestor->nama_investor, // mandatory
                              //'lastName' => (string)$DetilInvestor->nama_investor, // mandatory
                              'optNPWP' => (string)'1', // mandatory
                              'NPWPNum' => (string)$DetilInvestor->no_npwp_investor == "" ? "1122334445566778" : $DetilInvestor->no_npwp_investor, // mandatory
                              'nationality' => (string)'ID', // mandatory
                              'domicileCountry' => (string)'ID', // mandatory
                              'religion' => (string)"1", //mandatory
                              'birthPlace' => (string)"Jakarta", // mandatory
                              'birthDate' => (string)$birthDate, // mandatory
                              'gender' => (string)$jk , // mandatory
                              'isMarried' => (string)$isMarried->kode_map, // mandatory
                              'motherMaidenName' =>(string)"IBU KANDUNG", // mandatory
                              'jobCode' => (string)"02", //mandatory
                              'education' =>(string)"05", //mandatory
                              //'idNumber' => "321503240292004", // mandatory no ktp
                              'idNumber' => (string)$DetilInvestor->no_ktp_investor == "" ? "112233444556677" : $DetilInvestor->no_ktp_investor, // mandatory no ktp
                              'idIssuingCity' => (string)"Jakarta", // mandatory
                              'idExpiryDate' => (string)"26102099", // mandatory
                              'addressStreet' => (string)"Jalan Jalan", // mandatory
                              'addressRtRwPerum' => (string)"003009Sentosa", // mandatory
                              'addressKel' => (string)"Kelurahan" , // mandatory
                              //'addressKel' => (string) $DetilInvestor->kelurahan == "" ? "Kelurahan" : $DetilInvestor->kelurahan  , // mandatory
                              'addressKec' => (string)"Kecamatan"  , // mandatory
                              //'addressKec' => (string) $DetilInvestor->kecamatan == "" ? "Kecamatan" : $DetilInvestor->kecamatan  , // mandatory
                              'zipCode' => (string)"12345", // mandatory
                              // 'zipCode' => (string)$DetilInvestor->kode_pos_investor == "" ? "11111" : $DetilInvestor->kode_pos_investor, // mandatory
                              'homePhone1' => '',
                              'homePhone2' => '',
                              'officePhone1' => '',
                              'officePhone2' => '',
                              'mobilePhone1' => (string)"0812",  // mandatory
                              //'mobilePhone1' => (string) $DetilInvestor->phone_investor == "" ? "0812" : $mobilePhone1    ,  // mandatory
                              'mobilePhone2' => (string)"18224440"  , // mandatory
                              //'mobilePhone2' => (string) $DetilInvestor->phone_investor == "" ? "0000001" : $mobilePhone2  , // mandatory
                              'faxNum1' => '',
                              'faxNum2' => '',
                              'email' => (string)"email@yahoo.com",
                              'monthlyIncome' => (string)"8000000", //mandatory
                              'branchOpening' => (string)"0259"
                           )
                        
                     );
         //var_dump($array_payload);die;
         
         $get_jwt = $this->generateJWT($array_payload);
         
         $token         = $this->generateToken(); // generate token
         
         //$path = "p2pl/register/investor?access_token=".$token;
         $path    = "p2pl/register/investor";
         
         $request = $client->post(config('app.url_rdl').':'.config('app.port_rdl')."/".$path, [
            'headers' => [
               'X-API-Key'    => config('app.api_key_id_rdl'),
               'Content-Type'    => 'application/json'
               
            ],
            'query' => ['access_token' => $token],
            'body' => json_encode(
               ['request' => [
                  'header' => [
                     'signature' => $get_jwt, // mandatory
                     'companyId' => config('app.company_id_rdl'), // mandatory
                     'parentCompanyId' => '', 
                     'requestUuid' => $kode_uuid, // mandatory
                  ],
                     'title' => (string)'01', // mandatory
                              'firstName' => (string)$DetilInvestor->nama_investor == "" ? "112233444556677" : $DetilInvestor->nama_investor, 
                              'middleName' => (string)$DetilInvestor->nama_investor == "" ? "112233444556677" : $DetilInvestor->nama_investor,
                              'lastName' => (string)$DetilInvestor->nama_investor == "" ? "112233444556677" : $DetilInvestor->nama_investor, // mandatory
                              //'lastName' => (string)$DetilInvestor->nama_investor, // mandatory
                              'optNPWP' => (string)'1', // mandatory
                              'NPWPNum' => (string)$DetilInvestor->no_npwp_investor == "" ? "1122334445566778" : $DetilInvestor->no_npwp_investor, // mandatory
                              'nationality' => (string)'ID', // mandatory
                              'domicileCountry' => (string)'ID', // mandatory
                              'religion' => (string)"1", //mandatory
                              'birthPlace' => (string)"Jakarta", // mandatory
                              'birthDate' => (string)$birthDate, // mandatory
                              'gender' => (string)$jk , // mandatory
                              'isMarried' => (string)$isMarried->kode_map, // mandatory
                              'motherMaidenName' =>(string)"IBU KANDUNG", // mandatory
                              'jobCode' => (string)"02", //mandatory
                              'education' =>(string)"05", //mandatory
                              //'idNumber' => "321503240292004", // mandatory no ktp
                              'idNumber' => (string)$DetilInvestor->no_ktp_investor == "" ? "112233444556677" : $DetilInvestor->no_ktp_investor, // mandatory no ktp
                              'idIssuingCity' => (string)"Jakarta", // mandatory
                              'idExpiryDate' => (string)"26102099", // mandatory
                              'addressStreet' => (string)"Jalan Jalan", // mandatory
                              'addressRtRwPerum' => (string)"003009Sentosa", // mandatory
                              'addressKel' => (string)"Kelurahan" , // mandatory
                              //'addressKel' => (string) $DetilInvestor->kelurahan == "" ? "Kelurahan" : $DetilInvestor->kelurahan  , // mandatory
                              'addressKec' => (string)"Kecamatan"  , // mandatory
                              //'addressKec' => (string) $DetilInvestor->kecamatan == "" ? "Kecamatan" : $DetilInvestor->kecamatan  , // mandatory
                              'zipCode' => (string)"12345", // mandatory
                              // 'zipCode' => (string)$DetilInvestor->kode_pos_investor == "" ? "11111" : $DetilInvestor->kode_pos_investor, // mandatory
                              'homePhone1' => '',
                              'homePhone2' => '',
                              'officePhone1' => '',
                              'officePhone2' => '',
                              'mobilePhone1' => (string)"0812",  // mandatory
                              //'mobilePhone1' => (string) $DetilInvestor->phone_investor == "" ? "0812" : $mobilePhone1    ,  // mandatory
                              'mobilePhone2' => (string)"18224440"  , // mandatory
                              //'mobilePhone2' => (string) $DetilInvestor->phone_investor == "" ? "0000001" : $mobilePhone2  , // mandatory
                              'faxNum1' => '',
                              'faxNum2' => '',
                              'email' => (string)"email@yahoo.com",
                              'monthlyIncome' => (string)"8000000", //mandatory
                              'branchOpening' => (string)"0259"
                  ]
               ]
            )
         ]);
         
       $response = $request->getBody();
       $response = str_replace("\r","",$response);
       $response = str_replace("\n","",$response);
       $response = str_replace("\t","",$response);
         $response_decode = json_decode($response);
         if($response_decode->{'response'}->{'responseCode'} == "0001"){
            
               $insertCifNumber = new \App\RDLCifNumber();  
                $insertCifNumber->investor_id = $investor_id;
                $insertCifNumber->kode_bank = $kd_bank;
                $insertCifNumber->cif_number = $response_decode->{'response'}->{'cifNumber'};
                $insertCifNumber->save();
            
               $this->writeLog($kd_bank,'ADMIN/CREATE_CIF',json_encode($array_payload),json_encode($response),0,'SUCCESS',$response_decode->{'response'}->{'responseUuid'});


            
              //$response = ['status' => $response_decode->{'response'}->{'responseCode'}, 'message'=>'Request has been processed successfully'];
               return $response;
               //return response()->json($response);
         
         } else {
         
         
               $this->writeLog($kd_bank,'ADMIN/CREATE_CIF',json_encode($array_payload),json_encode($response),0,'FAILED','');
         }
         
      }
      
   }
   
   // create new customers Account
   public function RegisterInvestorAccount($investor_id, $cif_number, $kode_bank){
      
      // get cif number
      //$RDLCifNumber = RDLCifNumber::where('investor_id', $investor_id)->first();
      if($kode_bank == "009"){
         $apiSecretKey = config('app.api_key_secret_rdl'); //please adjusted 
         
         $kode_uuid  = $this->uuid();
         $token      = $this->generateToken(); // generate token
         
         $date    = date('dmY');
         $client = new Client();
         
         
         
         
         // Create token payload as a JSON string 
         $array_payload = array ('request' => 
                        array('header' =>array (
                              'companyId' => config('app.company_id_rdl'), // mandatory
                              'parentCompanyId' => '', 
                              'requestUuid' => $kode_uuid
                              ), // mandatory
                              'cifNumber' => $cif_number, // mandatory
                              //'cifNumber' => $RDLCifNumber->cif_number, // mandatory
                              'accountType' => 'RDL', // mandatory 
                              'currency' => 'IDR', // mandatory
                              'openAccountReason' => '2', // mandatory
                              'sourceOfFund' => '1', // mandatory
                              'branchId' => '0259', // mandatory
                           )
                        
                     );
         // generate jwt payload          
         $get_jwt = $this->generateJWT($array_payload);
         
         $path    = "p2pl/register/investor/account";
         
         $request = $client->post(config('app.url_rdl').':'.config('app.port_rdl')."/".$path, [
            'headers' => [
               'X-API-Key'    => config('app.api_key_id_rdl'),
               'Content-Type'    => 'application/json'
               
            ],
            'query' => ['access_token' => $token],
            'body' => json_encode(
               ['request' => [
                  'header' => [
                     'signature' => $get_jwt, // mandatory
                     'companyId' => config('app.company_id_rdl'), // mandatory
                     'parentCompanyId' => '', 
                     'requestUuid' => $kode_uuid, // mandatory
                  ],
                  'cifNumber' => $cif_number, // mandatory
                  //'cifNumber' => $RDLCifNumber->cif_number, // mandatory
                  'accountType' => 'RDL', // mandatory 
                  'currency' => 'IDR', // mandatory
                  'openAccountReason' => '2', // mandatory
                  'sourceOfFund' => '1', // mandatory
                  'branchId' => '0259', // mandatory
                  
                  ]
               ]
            )
            
         ]);
         
       $response = $request->getBody();
       $response = str_replace("\r","",$response);
       $response = str_replace("\n","",$response);
       $response = str_replace("\t","",$response);
         $response_decode = json_decode($response);
         if($response_decode->{'response'}->{'responseCode'} == "0001"){
            
            $insertCifNumber = new \App\RDLAccountNumber();  
                $insertCifNumber->investor_id = $investor_id;
                $insertCifNumber->kode_bank = $kode_bank;
                $insertCifNumber->cif_number = $cif_number;
                $insertCifNumber->account_number = $response_decode->{'response'}->{'accountNumber'};
                $insertCifNumber->save();
            
               $this->writeLog($kode_bank,'ADMIN/CREATE_ACC_RDL',json_encode($array_payload),json_encode($response),0,'SUCCESS',$response_decode->{'response'}->{'responseUuid'});
            
            //$response = ['status' => $response_decode->{'response'}->{'responseCode'}, 'message'=>'Request has been processed successfully'];
            return $response;
            //return response()->json($response);
         
         } else {
         
            $this->writeLog($kode_bank,'ADMIN/CREATE_ACC_RDL',json_encode($array_payload),json_encode($response),0,'FAILED','');
            
         }  
         
      }
      
   }
   
   // inquiry account number information for same BANK
   public function InquiryAccountInfo($kode_bank, $account_number){
      
      if($kode_bank == "009"){
      
         $apiSecretKey = config('app.api_key_secret_rdl'); //please adjusted 
      
         $date    = date('dmY');
         $client = new Client();
         $kode_uuid  = $this->uuid();
         $token      = $this->generateToken(); // generate token
          
         // Create token payload as a JSON string 
         $array_payload = array ('request' => 
            array('header' =>array (
               //'signature' => $this->create_jwt(), // mandatory
                  'companyId' => config('app.company_id_rdl'), // mandatory
                  'parentCompanyId' => '', 
                  'requestUuid' => $kode_uuid
               ), // mandatory
               'accountNumber' => $account_number // mandatory
            )
            
         );
                     
         // generate jwt payload          
         $get_jwt       = $this->generateJWT($array_payload); 
         
         $token            = $this->generateToken(); // generate token
         
         $path          = "p2pl/inquiry/account/info";
         
         $request       = $client->post(config('app.url_rdl').':'.config('app.port_rdl')."/".$path, [
            'headers' => [
               'X-API-Key'    => config('app.api_key_id_rdl'),
               'Content-Type'    => 'application/json'
               
            ],
            'query' => ['access_token' => $token],
            'body' => json_encode(
               ['request' => [
                  'header' => [
                     'signature' => $get_jwt, // mandatory
                     'companyId' => config('app.company_id_rdl'), // mandatory
                     'parentCompanyId' => '', 
                     'requestUuid' => $kode_uuid, // mandatory
                  ],
                  'accountNumber' => $account_number // mandatory
                
                  ]
               ]
            )
            
         ]);
         
           
         
      $response = $request->getBody();
      $response = str_replace("\r","",$response);
      $response = str_replace("\n","",$response);
      $response = str_replace("\t","",$response);
        $response_decode = json_decode($response);
        if($response_decode->{'response'}->{'responseCode'} == "0001"){
        
          $this->writeLog($kode_bank,'INQ/INFO_ACC_RDL',json_encode($array_payload),json_encode($response),0,'SUCCESS',$response_decode->{'response'}->{'responseUuid'});
      
        } else {
        
          $this->writeLog($kode_bank,'INQ/INFO_ACC_RDL',json_encode($array_payload),json_encode($response),0,'FAILED',$response_decode->{'response'}->{'responseUuid'});
      
        }
        
        echo $response;
      
      } // BNI 009
       
      
   }
   
   // inquiry account number balance
   public function InquiryAccountBalance($account_number,$kode_bank){
      
      if($kode_bank == "009"){
         $kode_uuid        = $this->uuid();
         $token            = $this->generateToken(); // generate token
         $apiSecretKey     = config('app.api_key_secret_rdl'); //please adjusted 
      
         $date       = date('dmY');
         $client  = new Client();
         
         // Create token payload as a JSON string 
         $array_payload = array ('request' => 
            array('header' =>array (
                 //'signature' => $this->create_jwt(), // mandatory
                     'companyId' => config('app.company_id_rdl'), // mandatory
                     'parentCompanyId' => '', 
                     'requestUuid' => $kode_uuid
                  ), // mandatory
                  'accountNumber' => $account_number // mandatory
               )
            
            );
                     
         // generate jwt payload          
         $get_jwt = $this->generateJWT($array_payload); 
         
         $path    = "p2pl/inquiry/account/balance";
         
         $request = $client->post(config('app.url_rdl').':'.config('app.port_rdl')."/".$path, [
            'headers' => [
               'X-API-Key'    => config('app.api_key_id_rdl'),
               'Content-Type'    => 'application/json'
               
            ],
            'query' => ['access_token' => $token],
            'body' => json_encode(
               ['request' => [
                  'header' => [
                     'signature' => $get_jwt, // mandatory
                     'companyId' => config('app.company_id_rdl'), // mandatory
                     'parentCompanyId' => '', 
                     'requestUuid' => $kode_uuid // mandatory
                  ],
                  'accountNumber' => $account_number // mandatory
                 
                  ]
               ]
            )  
            
        ]);
         
      $response = $request->getBody();
      $response = str_replace("\r","",$response);
      $response = str_replace("\n","",$response);
      $response = str_replace("\t","",$response);
        $response_decode = json_decode($response);
         if($response_decode->{'response'}->{'responseCode'} == "0001"){
        
          $this->writeLog($kode_bank,'INQ/BAL_ACC_RDL',json_encode($array_payload),json_encode($response),0,'SUCCESS',$response_decode->{'response'}->{'responseUuid'});
      
        } else {
        
          $this->writeLog($kode_bank,'INQ/BAL_ACC_RDL',json_encode($array_payload),json_encode($response),0,'FAILED',$response_decode->{'response'}->{'responseUuid'});
      
        }
        echo $response;
      
      } // BNI 009
       
      
   }
   
   // inquiry account number mutation history last 100 trx
   public function InquiryAccountHistory($account_number,$kode_bank){
      
      if($kode_bank == "009"){
         $kode_uuid     = $this->uuid();
         $token            = $this->generateToken(); // generate token
         $apiSecretKey  = config('app.api_key_secret_rdl'); //please adjusted 
      
         $date    = date('dmY');
         $client = new Client();
         
         
         // Create token payload as a JSON string 
         $array_payload = array ('request' => 
            array('header' =>array (
                 
                 'companyId' => config('app.company_id_rdl'), // mandatory
                 'parentCompanyId' => '', 
                 'requestUuid' => $kode_uuid
                 ), // mandatory
                  'accountNumber' => $account_number // mandatory
               )
            
          );
                     
         // generate jwt payload          
         $get_jwt = $this->generateJWT($array_payload); 
          
         $path    = "p2pl/inquiry/account/history";
         
         $request = $client->post(config('app.url_rdl').':'.config('app.port_rdl')."/".$path, [
            'headers' => [
               'X-API-Key'    => config('app.api_key_id_rdl'),
               'Content-Type'    => 'application/json'
               
            ],
            'query' => ['access_token' => $token],
            'body' => json_encode(
               ['request' => [
                  'header' => [
                     'signature' => $get_jwt, // mandatory
                     'companyId' => config('app.company_id_rdl'), // mandatory
                     'parentCompanyId' => '', 
                     'requestUuid' => $kode_uuid // mandatory
                  ],
                  'accountNumber' => $account_number // mandatory
                 
                  ]
               ]
            )
            
         ]);
         
       $response = $request->getBody();
       $response = str_replace("\r","",$response);
       $response = str_replace("\n","",$response);
       $response = str_replace("\t","",$response);
         $response_decode = json_decode($response);
         if($response_decode->{'response'}->{'responseCode'} == "0001"){
        
          $this->writeLog($kode_bank,'INQ/HIST_ACC_RDL',json_encode($array_payload),json_encode($response),0,'SUCCESS',$response_decode->{'response'}->{'responseUuid'});
      
        } else {
        
          $this->writeLog($kode_bank,'INQ/HIST_ACC_RDL',json_encode($array_payload),json_encode($response),0,'FAILED',$response_decode->{'response'}->{'responseUuid'});
      
        }
        
         return $response;
      
      } // BNI 009
       
      
   }
   
   // Inquiry Payment Status 
   public function InquiryTransferTransaction($kode_bank,$trx_uuid){
      
      if($kode_bank == "009"){
         $kode_uuid = $this->uuid();
         $apiSecretKey = config('app.api_key_secret_rdl'); //please adjusted 
      
         $date    = date('dmY');
         $client = new Client();
         
         
          
         // Create token payload as a JSON string 
         $array_payload = array ('request' => 
            array('header' =>array (
                 
               'companyId' => config('app.company_id_rdl'), // mandatory
               'parentCompanyId' => '', 
               'requestUuid' => $kode_uuid
               ), // mandatory
                'requestedUuid' => $trx_uuid // mandatory
            )
            
         );
                     
         // generate jwt payload          
         $get_jwt = $this->generateJWT($array_payload); 
         
         $token         = $this->generateToken(); // generate token
         
          
         $path    = "p2pl/inquiry/payment/status";
         
         $request = $client->post(config('app.url_rdl').':'.config('app.port_rdl')."/".$path, [
            'headers' => [
               'X-API-Key'    => config('app.api_key_id_rdl'),
               'Content-Type'    => 'application/json'
               
            ],
            'query' => ['access_token' => $token],
            'body' => json_encode(
               ['request' => [
                  'header' => [
                     'signature' => $get_jwt, // mandatory
                     'companyId' => config('app.company_id_rdl'), // mandatory
                     'parentCompanyId' => '', 
                     'requestUuid' => $kode_uuid // mandatory
                  ],
                  'requestedUuid' => $trx_uuid // mandatory
                 
                  ]
               ]
            )
            
         ]);
         
       $response = $request->getBody();
       $response = str_replace("\r","",$response);
       $response = str_replace("\n","",$response);
       $response = str_replace("\t","",$response);
         $response_decode = json_decode($response);
         if($response_decode->{'response'}->{'responseCode'} == "0001"){
        
          $this->writeLog($kode_bank,'TRX/TRF_INQ_OB',json_encode($array_payload),json_encode($response),0,'SUCCESS',$response_decode->{'response'}->{'responseUuid'});
      
        } else {
        
          $this->writeLog($kode_bank,'TRX/TRF_INQ_OB',json_encode($array_payload),json_encode($response),0,'FAILED',$response_decode->{'response'}->{'responseUuid'});
      
        }
        
         return $response;
      
      } // BNI 009
   }
   
    // Payment Using Transfer 
   public function ExecuteTransferTransactionOverbooking($account_number,$kode_bank,$accno_dest,$amount,$berita_transfer){
      
      // if ($currency != 'IDR') {
      
            // $return1 = array(
            // "status_code" => "05",
            // "status_message" => 'Invalid Currency. Must be IDR'
                                  
            // );
            // return json_encode($return1);
            
      // }
      
      if($kode_bank == "009"){
      
         $kode_uuid = $this->uuid();
      
         if (strlen($berita_transfer) > 50) 
            $berita_transfer = substr($berita_transfer,0,50);
      
            $apiSecretKey = config('app.api_key_secret_rdl'); //please adjusted 
      
            $date    = date('dmY');
            $client = new Client();
                
                $path    = "p2pl/payment/transfer";
                    
                // Create token payload as a JSON string 
                $array_payload = array ('request' => 
               array('header' =>array (
                     'companyId' => config('app.company_id_rdl'), // mandatory
                     'parentCompanyId' => '', 
                     'requestUuid' =>$kode_uuid
                  ), // mandatory
                  'accountNumber' => $account_number, // mandatory
                  'beneficiaryAccountNumber' => $accno_dest, // mandatory
                  'currency' => "IDR", // mandatory
                  'amount' => $amount, // mandatory
                  //'remark' => ""
                  'remark' => $berita_transfer
               )
                
            );
                              
                // generate jwt payload            
            $get_jwt = $this->generateJWT($array_payload); 
                     
            $token         = $this->generateToken(); // generate token
          
            
                $request = $client->post(config('app.url_rdl').':'.config('app.port_rdl')."/".$path, [
               'headers' => [
                        'X-API-Key'    => config('app.api_key_id_rdl'),
                        'Content-Type'    => 'application/json'
                        
                    ],
                    'query' => ['access_token' => $token],
                    'body' => json_encode(
                        ['request' => [
                     'header' => [
                        'signature' => $get_jwt, // mandatory
                        'companyId' => config('app.company_id_rdl'), // mandatory
                        'parentCompanyId' => '', 
                        'requestUuid' =>$kode_uuid // mandatory
                     ],
                     'accountNumber' => $account_number, // mandatory
                     'beneficiaryAccountNumber' => $accno_dest, // mandatory
                     'currency' => "IDR", // mandatory
                     'amount' => $amount, // mandatory
                     //'remark' => ""
                     'remark' => $berita_transfer
                           ]
                        ]
                    )
                     
               ]);
      
         
         
         $response = $request->getBody();
         $response = str_replace("\r","",$response);
         $response = str_replace("\n","",$response);
         $response = str_replace("\t","",$response);
            $response_decode = json_decode($response);
            if($response_decode->{'response'}->{'responseCode'} == "0001"){
                
                  $this->writeLog($kode_bank,'TRX/TRF_EXE_OB',json_encode($array_payload),json_encode($response),$amount,'SUCCESS',$response_decode->{'response'}->{'responseUuid'});
              
            } else {
                
                  $this->writeLog($kode_bank,'TRX/TRF_EXE_OB',json_encode($array_payload),json_encode($response),$amount,'FAILED',$response_decode->{'response'}->{'responseUuid'});
              
            }
        
            return $response;
      
      } // BNI 009
       
      
   }
   
   
    // transfer SKN Kliring
   public function ExecuteTransferTransactionKliring($kode_bank,$account_number,$accno_dest,$beneficiaryAddress1,$bank_code_dest,$accname_dest,$amount,$berita_transfer){
      
      // if ($currency != 'IDR') {
      
            // $return1 = array(
            // "status_code" => "05",
            // "status_message" => 'Invalid Currency. Must be IDR'
                                  
            // );
            // return json_encode($return1);
            
      // }
      
      if($kode_bank == "009"){
      
         $kode_uuid = $this->uuid();
      
         if (strlen($berita_transfer) > 50) 
            $berita_transfer = substr($berita_transfer,0,50);
      
            $apiSecretKey = config('app.api_key_secret_rdl'); //please adjusted 
        
            $date    = date('dmY');
            $client = new Client();
                
                //$bank_code_dest_clearing  = GetBank_ClearingCode($bank_code_dest);
                   
                $path    = "p2pl/payment/clearing";
                    
                // Create token payload as a JSON string 
                $array_payload = array ('request' => 
                           array('header' =>array (
                                       
                              'companyId' => config('app.company_id_rdl'), // mandatory
                              'parentCompanyId' => '', 
                              'requestUuid' => $kode_uuid
                                    ), // mandatory
                                    'accountNumber' => (string)$account_number, // mandatory
                                    'beneficiaryAccountNumber' => (string)$accno_dest, // mandatory
                                    'beneficiaryAddress1' => (string)$beneficiaryAddress1,
                                    'beneficiaryAddress2' => '',
                                    'beneficiaryBankCode' => (string)$bank_code_dest,
                                    'beneficiaryName' => (string)$accname_dest,
                                    'currency' => 'IDR', // mandatory
                                    'amount' => (string)$amount, // mandatory
                                    'remark' => (string)$berita_transfer,
                                    'chargingType' => 'OUR'
                                    )
                                 
                        );
            
            // generate jwt payload          
            $get_jwt = $this->generateJWT($array_payload); 
                     
            $token         = $this->generateToken(); // generate token
         
            
                $request = $client->post(config('app.url_rdl').':'.config('app.port_rdl')."/".$path, [
                    'headers' => [
                  'X-API-Key'    => config('app.api_key_id_rdl'),
                        'Content-Type'    => 'application/json'
                        
                    ],
               'query' => ['access_token' => $token],
                  'body' => json_encode(
                     ['request' => [
                        'header' => [
                           'signature' => $get_jwt, // mandatory
                           'companyId' => config('app.company_id_rdl'), // mandatory
                           'parentCompanyId' => '', 
                           'requestUuid' => $kode_uuid // mandatory
                        ],
                        'accountNumber' => (string)$account_number, // mandatory
                        'beneficiaryAccountNumber' => (string)$accno_dest, // mandatory
                        'beneficiaryAddress1' => (string)$beneficiaryAddress1,
                        'beneficiaryAddress2' => '',
                        'beneficiaryBankCode' => (string)$bank_code_dest,
                        'beneficiaryName' => (string)$accname_dest,
                        'currency' => 'IDR', // mandatory
                        'amount' => (string)$amount, // mandatory
                        'remark' => (string)$berita_transfer,
                        'chargingType' => 'OUR'
                        ]
                     ]
                  )
                     
               ]);
         
         
       $response = $request->getBody();
       $response = str_replace("\r","",$response);
       $response = str_replace("\n","",$response);
       $response = str_replace("\t","",$response);
         $response_decode = json_decode($response);
         if($response_decode->{'response'}->{'responseCode'} == "0001"){
                
                  $this->writeLog($kode_bank,'TRX/TRF_EXE_SKN',json_encode($array_payload),json_encode($response),$amount,'SUCCESS',$response_decode->{'response'}->{'responseUuid'});
              
            } else {
                
                  $this->writeLog($kode_bank,'TRX/TRF_EXE_SKN',json_encode($array_payload),json_encode($response),$amount,'FAILED',$response_decode->{'response'}->{'responseUuid'});
              
            }
            
         return $response;
      
      } // BNI 009
       
      
   }
   
    // transfer RTGS  
   public function ExecuteTransferTransactionRTGS($kode_bank,$account_number,$accno_dest,$beneficiaryAddress1,$bank_code_dest,$accname_dest,$amount,$berita_transfer){
      
      // if ($currency != 'IDR') {
      
            // $return1 = array(
            // "status_code" => "05",
            // "status_message" => 'Invalid Currency. Must be IDR'
                                  
            // );
            // return json_encode($return1);
            
      // }
      
      if($kode_bank == "009"){
      
         $kode_uuid = $this->uuid();
      
         if (strlen($berita_transfer) > 50) 
            $berita_transfer = substr($berita_transfer,0,50);
      
            $apiSecretKey = config('app.api_key_secret_rdl'); //please adjusted 
      
            $date    = date('dmY');
            $client = new Client();
         
            //$bank_code_dest_RTGS  = GetBank_RTGSCode($bank_code_dest);
                   
                $path    = "p2pl/payment/rtgs";
                    
                // Create token payload as a JSON string 
            $array_payload = array ('request' => 
               array('header' =>array (
                     
                     'companyId' => config('app.company_id_rdl'), // mandatory
                     'parentCompanyId' => '', 
                     'requestUuid' => $kode_uuid
                  ), // mandatory
                  'accountNumber' => (string)$account_number, // mandatory
                  'beneficiaryAccountNumber' => (string)$accno_dest, // mandatory
                  'beneficiaryAddress1' => (string)$beneficiaryAddress1,
                  'beneficiaryAddress2' => '',
                  'beneficiaryBankCode' => (string)$bank_code_dest,
                  'beneficiaryName' => (string)$accname_dest,
                  'currency' => "IDR", // mandatory
                  'amount' => (string)$amount, // mandatory
                  'remark' => (string)$berita_transfer,
                  'chargingType' => 'OUR'
               )
                
            );
         
         $get_jwt = $this->generateJWT($array_payload); // generate jwt payload  
         
         $token         = $this->generateToken(); // generate token
         
            $request = $client->post(config('app.url_rdl').':'.config('app.port_rdl')."/".$path, [
            'headers' => [
               'X-API-Key'    => config('app.api_key_id_rdl'),
               'Content-Type'    => 'application/json'
            
            ],
            'query' => ['access_token' => $token],
            'body' => json_encode(
               ['request' => [
                  'header' => [
                     'signature' => $get_jwt, // mandatory
                     'companyId' => config('app.company_id_rdl'), // mandatory
                     'parentCompanyId' => '', 
                     'requestUuid' => $kode_uuid // mandatory
                  ],
                  'accountNumber' => (string)$account_number, // mandatory
                  'beneficiaryAccountNumber' => (string)$accno_dest, // mandatory
                  'beneficiaryAddress1' => (string)$beneficiaryAddress1,
                  'beneficiaryAddress2' => '',
                  'beneficiaryBankCode' => (string)$bank_code_dest,
                  'beneficiaryName' => (string)$accname_dest,
                  'currency' => "IDR", // mandatory
                  'amount' => (string)$amount, // mandatory
                  'remark' => (string)$berita_transfer,
                  'chargingType' => 'OUR'
                  ]
               ]
            )
          
         ]);
         
         
       $response = $request->getBody();
       $response = str_replace("\r","",$response);
       $response = str_replace("\n","",$response);
       $response = str_replace("\t","",$response);
         $response_decode = json_decode($response);
         if($response_decode->{'response'}->{'responseCode'} == "0001"){
                
                  $this->writeLog($kode_bank,'TRX/TRF_EXE_RTGS',json_encode($array_payload),json_encode($response),$amount,'SUCCESS',$response_decode->{'response'}->{'responseUuid'});
              
            } else {
                
                  $this->writeLog($kode_bank,'TRX/TRF_EXE_RTGS',json_encode($array_payload),json_encode($response),$amount,'FAILED',$response_decode->{'response'}->{'responseUuid'});
              
            }
            
         return $response;
      
      } // BNI 009
       
      
   }
   
    // inquiry transfer online  
   public function InquiryTransferTransactionOnline($kode_bank,$account_number,$bank_code_dest,$accno_dest){
      
      // if ($currency != 'IDR') {
      
            // $return1 = array(
            // "status_code" => "05",
            // "status_message" => 'Invalid Currency. Must be IDR'
                                  
            // );
            // return json_encode($return1);
            
      // }
      
      if($kode_bank == "009"){
      
         $kode_uuid = $this->uuid();
         $apiSecretKey = config('app.api_key_secret_rdl'); //please adjusted 
      
         $date    = date('dmY');
         $client = new Client();
         
         $path    = "p2pl/inquiry/interbank/account";
         
         // Create token payload as a JSON string 
         $array_payload = array ('request' => 
            array('header' =>array (
                        
                  'companyId' => config('app.company_id_rdl'), // mandatory
                  'parentCompanyId' => '', 
                  'requestUuid' => $kode_uuid
               ), // mandatory
               'accountNumber' => $account_number, // mandatory
               'beneficiaryBankCode' => $bank_code_dest,
               'beneficiaryAccountNumber' => $accno_dest 
            )
                   
         );
         
         $get_jwt = $this->generateJWT($array_payload); // generate jwt payload  
                     
         $token         = $this->generateToken(); // generate token
         
         $request = $client->post(config('app.url_rdl').':'.config('app.port_rdl')."/".$path, [
            'headers' => [
               'X-API-Key'    => config('app.api_key_id_rdl'),
               'Content-Type'    => 'application/json'
            
            ],
            'query' => ['access_token' => $token],
            'body' => json_encode(
               ['request' => [
                  'header' => [
                     'signature' => $get_jwt, // mandatory
                     'companyId' => config('app.company_id_rdl'), // mandatory
                     'parentCompanyId' => '', 
                     'requestUuid' => $kode_uuid // mandatory
                  ],
                  'accountNumber' => $account_number, // mandatory
                  'beneficiaryBankCode' => $bank_code_dest,
                  'beneficiaryAccountNumber' => $accno_dest
                  ]
               ]
            )
          
         ]);
         
         
       $response = $request->getBody();
       $response = str_replace("\r","",$response);
       $response = str_replace("\n","",$response);
       $response = str_replace("\t","",$response);
         $response_decode = json_decode($response);
           if($response_decode->{'response'}->{'responseCode'} == "0001"){
                
                  $this->writeLog($kode_bank,'TRX/TRF_INQ_ONL',json_encode($array_payload),json_encode($response),0,'SUCCESS',$response_decode->{'response'}->{'responseUuid'});
              
            } else {
                
                  $this->writeLog($kode_bank,'TRX/TRF_INQ_ONL',json_encode($array_payload),json_encode($response),0,'FAILED',$response_decode->{'response'}->{'responseUuid'});
              
            }
         
      
      } // BNI 009
      $return1 = array(
         "status_code" => "00",
         "status_message" => 'Inquiry Success',
         "response_result" => $response
             
      );
        return json_encode($return1);
        
      
   }
   
   // transfer
   
   public function ExecuteTransferTransactionOnline($kode_bank,$account_number,$bank_code_dest,$bank_name_dest,$accno_dest, $accname_dest,$amount){
      
      // if ($currency != 'IDR') {
        
         // $return1 = array(
            // "status_code" => "05",
            // "status_message" => 'Invalid Currency. Must be IDR'
                             
         // );
         // return json_encode($return1);
            
      // }
        
      if($kode_bank == "009"){
         
         $kode_uuid = $this->uuid();
        
         $apiSecretKey = config('app.api_key_secret_rdl'); //please adjusted 
        
         $date    = date('dmY');
         $client = new Client();
          
         $path    = "p2pl/payment/interbank";
                  
         // Create token payload as a JSON string 
         $array_payload = array ('request' => 
            array('header' =>array (
               
               'companyId' => config('app.company_id_rdl'), // mandatory
               'parentCompanyId' => '', 
               'requestUuid' => $kode_uuid
            ), // mandatory
               'accountNumber' => (string)$account_number, // mandatory
               'beneficiaryAccountNumber' => (string)$accno_dest, // mandatory
               'beneficiaryAccountName' => (string)$accname_dest,
               'beneficiaryBankCode' => (string)$bank_code_dest,
               'beneficiaryBankName' => (string)$bank_name_dest,
               'amount' => (string)$amount // mandatory
            )
          
         );
          
                   
         $get_jwt = $this->generateJWT($array_payload); // generate jwt payload  
          
         $token         = $this->generateToken(); // generate token
          
         $request = $client->post(config('app.url_rdl').':'.config('app.port_rdl')."/".$path, [
            'headers' => [
               'X-API-Key'    => config('app.api_key_id_rdl'),
               'Content-Type'    => 'application/json'
            
            ],
            'query' => ['access_token' => $token],
            'body' => json_encode(
               ['request' => [
                  'header' => [
                    'signature' => $get_jwt, // mandatory
                    'companyId' => config('app.company_id_rdl'), // mandatory
                    'parentCompanyId' => '', 
                    'requestUuid' =>$kode_uuid // mandatory
                  ],
                  'accountNumber' => (string)$account_number, // mandatory
                  'beneficiaryAccountNumber' => (string)$accno_dest, // mandatory
                  'beneficiaryAccountName' => (string)$accname_dest,
                  'beneficiaryBankCode' => (string)$bank_code_dest,
                  'beneficiaryBankName' => (string)$bank_name_dest,
                   'amount' => (string)$amount // mandatory
                  ]
               ]
            )
             
         ]);
          
          
       $response = $request->getBody();
       $response = str_replace("\r","",$response);
       $response = str_replace("\n","",$response);
       $response = str_replace("\t","",$response);
         $response_decode = json_decode($response);
         if($response_decode->{'response'}->{'responseCode'} == "0001"){
                
                  $this->writeLog($kode_bank,'TRX/TRF_EXE_ONL',json_encode($array_payload),json_encode($response),$amount,'SUCCESS',$response_decode->{'response'}->{'responseUuid'});
              
            } else {
                
                  $this->writeLog($kode_bank,'TRX/TRF_EXE_ONL',json_encode($array_payload),json_encode($response),$amount,'FAILED',$response_decode->{'response'}->{'responseUuid'});
              
            }
            
         return $response;
        
      } // BNI 009
      
   }
   
   
    // transfer
   public function ExecuteTransferTransaction($kode_bank,$method,$account_number,$bank_code_dest,$accno_dest,$accname_dest,$amount,$berita_transfer){
      
      // if ($currency != 'IDR') {
      
            // $return1 = array(
                     // "status_code" => "05",
                     // "status_message" => 'Invalid Currency. Must be IDR'
                                  
                        // );
            // return json_encode($return1);
            
      // }
       
         
      if ($method=='OVERBOOKING') {
            $ret = ExecuteTransferTransactionOverbooking($account_number,$kode_bank,$accno_dest,$amount,$berita_transfer);
                 
      } else if ($method=='SKN') {
         
            $ret = ExecuteTransferTransactionKliring($kode_bank,$account_number,$accno_dest,$beneficiaryAddress1, $bank_code_dest,$accname_dest,$amount,$berita_transfer);
                
      } else if ($method=='RTGS') {
         
            $ret = ExecuteTransferTransactionRTGS($kode_bank,$account_number,$accno_dest,$beneficiaryAddress1, $bank_code_dest,$accname_dest,$amount,$berita_transfer);
       
      } else if ($method=='ONLINE') {
            $ret = InquiryTransferTransactionOnline($kode_bank,$account_number,$bank_code_dest,$accno_dest);
                
                $resx = json_decode($ret);
                if ($resx->status_code=='00') {
                
                    if ($resx->response_result->response->responseCode=='0001') {
                      
                  $bank_name_dest = $resx->response_result->response->beneficiaryBankName;
                        $accname_dest = $resx->response_result->response->beneficiaryAccountName;
                           
                        $ret = ExecuteTransferTransactionOnline($kode_bank,$accno_src,$bank_code_dest,$bank_name_dest,$accno_dest,$accname_dest,$currency,$amount);
                
                    }
                }
      }
                   
      return $ret;
       
      
   }
   
   public function writeLog($bank_rdl_code,$category,$request_content,$request_response,$amount,$status,$bank_reference) {

        $log1 =  New LogBankRDLTransaction();
        $log1->bank_rdl_code = $bank_rdl_code;
        $log1->category = $category;
        $log1->request_content = $request_content;
        $log1->request_response = $request_response;
        $log1->nominal_transaction = $amount;
        $log1->bank_reference = $bank_reference;
        $log1->status = $status;
        $log1->save();

   }

}