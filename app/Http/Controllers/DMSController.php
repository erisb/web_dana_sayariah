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
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007\Element\Section;
use Terbilang;


class DMSController extends Controller
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


    public function createFolder($type1,$type2,$type3,$path) 
    {

      $docpath = '';
      $client = new Client();
      
      $data02 = $this->checkExistingFolder($type1,$type2,$type3,$path);
      $data02x = json_decode($data02);
      if ($data02x->status_code=='00') {
              $return1 = array(
                              "status_code" => "88",
                              "status_message" => 'Folder already created'
                               
                          );
              return json_encode($return1);
      } else {
            // go on to create folder
      }
      
      if ($type1=='BORROWER') {
      
             if ($type2=='CORPORATE') {
            
                      if ($type3=='LOCAL') {
      
                              $docpath = config('app.DMS_PATH_BORROWER_CORPORATE_LOCAL');
      
                     } else if ($type3=='FOREIGN') {
                     
                               $docpath = config('app.DMS_PATH_BORROWER_CORPORATE_FOREIGN');  
                     
                     }
      
            } else if ($type2=='PERSONAL') {
            
                      if ($type3=='WNI') {
      
                                 $docpath = config('app.DMS_PATH_BORROWER_PERSONAL_WNI');
      
                     } else if ($type3=='WNA') {
                     
                                 $docpath = config('app.DMS_PATH_BORROWER_PERSONAL_WNA');
                     
                     }
                  
            
            }
      
      } else if ($type1=='LENDER') {
      
             if ($type2=='CORPORATE') {
      
                      if ($type3=='LOCAL') {
      
                                 $docpath = config('app.DMS_PATH_LENDER_CORPORATE_LOCAL');
      
                     } else if ($type3=='FOREIGN') {
                     
                                 $docpath = config('app.DMS_PATH_LENDER_CORPORATE_FOREIGN');
                     
                     }
      
            } else if ($type2=='PERSONAL') {
            
                  
                      if ($type3=='WNI') {
      
                                 $docpath = config('app.DMS_PATH_LENDER_PERSONAL_WNI');
      
                     } else if ($type3=='WNA') {
                     
                                 $docpath = config('app.DMS_PATH_LENDER_PERSONAL_WNA');
                     
                     }
            }
      
    } // LENDER OR BORROWER
      
     // syslog(0,"type=".$type1.$type2.$type3);
     // syslog(0,"dir=".$docpath.$path);
    
      $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
       $cek = $client->post(config('app.DMS_URL_SVC').'folder/createSimple',[
                    'auth' => [config('app.DMS_USER'),config('app.DMS_PASSWORD')],
                    'headers' => [  'Content-Type' => 'application/json',
                                    'Accept' => 'application/json'
                                    
                                ],

                    'body' => $docpath.$path,
                    'verify' => false
                ]);
                
       if ($cek->getStatusCode() == 200) {

               $response =  $cek->getBody()->getContents();
            
               $response1 = json_decode($response);
         
               if (isset($response1->created)) {
                       $return1 = array(
                              "status_code" => "00",
                              "status_message" => 'Folder created'
                               
                          );
               } else {
                        $return1 = array(
                              "status_code" => "88",
                              "status_message" => 'Folder already created'
                               
                          );
               
               }
         } else {
         
               $return1 = array(
                              "status_code" => "88",
                              "status_message" => 'Folder already created'
                               
                          );
         }
          return json_encode($return1);
    }

    public function checkExistingFolder($type1,$type2,$type3,$uniqid) {

      $docpath = '';
      $client = new Client();
      if ($type1=='BORROWER') {
      
             if ($type2=='CORPORATE') {
            
                      if ($type3=='LOCAL') {
      
                              $docpath = config('app.DMS_PATH_BORROWER_CORPORATE_LOCAL');
      
                     } else if ($type3=='FOREIGN') {
                     
                               $docpath = config('app.DMS_PATH_BORROWER_CORPORATE_FOREIGN');  
                     
                     }
      
            } else if ($type2=='PERSONAL') {
            
                      if ($type3=='WNI') {
      
                                 $docpath = config('app.DMS_PATH_BORROWER_PERSONAL_WNI');
      
                     } else if ($type3=='WNA') {
                     
                                 $docpath = config('app.DMS_PATH_BORROWER_PERSONAL_WNA');
                     
                     }
                  
            
            }
      
      } else if ($type1=='LENDER') {
      
             if ($type2=='CORPORATE') {
      
                      if ($type3=='LOCAL') {
      
                                 $docpath = config('app.DMS_PATH_LENDER_CORPORATE_LOCAL');
      
                     } else if ($type3=='FOREIGN') {
                     
                                 $docpath = config('app.DMS_PATH_LENDER_CORPORATE_FOREIGN');
                     
                     }
      
            } else if ($type2=='PERSONAL') {
            
                  
                      if ($type3=='WNI') {
      
                                 $docpath = config('app.DMS_PATH_LENDER_PERSONAL_WNI');
      
                     } else if ($type3=='WNA') {
                     
                                 $docpath = config('app.DMS_PATH_LENDER_PERSONAL_WNA');
                     
                     }
            }
      
      } // LENDER OR BORROWER
      
      $status_code=0;
       try {
       
        
           $cek = $client->get(config('app.DMS_URL_SVC').'folder/isValid?fldId='.urlencode($docpath.$uniqid),[
                    'auth' => [config('app.DMS_USER'),config('app.DMS_PASSWORD')],
                    'headers' => [   
                                    'Accept' => 'text/plain'
                                    
                                ],

             
                    'verify' => false
                ]);
                
                $status_code=200;

      } catch (\GuzzleHttp\Exception\RequestException $e) {
            // echo Psr7\str($e->getRequest());
         
             
            if ($e->hasResponse()) {
            
               
                // syslog(0,"not 200 = ".$e->getResponse()->getStatusCode());
                // syslog(0,"not 200xxxx = ".$e->getResponse()->getBody());
                $dmesg1 = $e->getResponse()->getBody();
                if (strstr($dmesg1,'PathNotFoundException')) {
                  
                      $status_code = 500;
                }
                
            }  
      
     }

       if ($status_code== 200) {
                
                  $response =  $cek->getBody()->getContents();
                  
                   
                  if ($response == 'true') {
                          $return1 = array(
                                 "status_code" => "00",
                                 "status_message" => 'Folder Valid'
                                  
                             );
                  } else {
                           $return1 = array(
                                 "status_code" => "14",
                                 "status_message" => 'Folder not valid'
                                  
                             );
                  
                  }
         } else if ($status_code== 500) {
              
               
                   $return1 = array(
                                 "status_code" => "14",
                                 "status_message" => 'Folder not valid'
                                  
                             );
         
         }
          return json_encode($return1);
    }

    public function uploadFile($type1,$type2,$type3,$path,$filename,$filecontent) {

      $docpath = '';
      $client = new Client();
      if ($type1=='BORROWER') {
      
             if ($type2=='CORPORATE') {
            
                      if ($type3=='LOCAL') {
      
                              $docpath = config('app.DMS_PATH_BORROWER_CORPORATE_LOCAL');
      
                     } else if ($type3=='FOREIGN') {
                     
                               $docpath = config('app.DMS_PATH_BORROWER_CORPORATE_FOREIGN');  
                     
                     }
      
            } else if ($type2=='PERSONAL') {
            
                      if ($type3=='WNI') {
      
                                 $docpath = config('app.DMS_PATH_BORROWER_PERSONAL_WNI');
      
                     } else if ($type3=='WNA') {
                     
                                 $docpath = config('app.DMS_PATH_BORROWER_PERSONAL_WNA');
                     
                     }
                  
            
            }
      
      } else if ($type1=='LENDER') {
      
             if ($type2=='CORPORATE') {
      
                      if ($type3=='LOCAL') {
      
                                 $docpath = config('app.DMS_PATH_LENDER_CORPORATE_LOCAL');
      
                     } else if ($type3=='FOREIGN') {
                     
                                 $docpath = config('app.DMS_PATH_LENDER_CORPORATE_FOREIGN');
                     
                     }
      
            } else if ($type2=='PERSONAL') {
            
                  
                      if ($type3=='WNI') {
      
                                 $docpath = config('app.DMS_PATH_LENDER_PERSONAL_WNI');
      
                     } else if ($type3=='WNA') {
                     
                                 $docpath = config('app.DMS_PATH_LENDER_PERSONAL_WNA');
                     
                     }
            }
      
      } // LENDER OR BORROWER
      
      
      $this->createFolder($type1,$type2,$type3,$path) ;
      
       $jsonFile = $docpath.$path.'/'.$filename;
       //syslog(0,"DHK try to upload file with=".$jsonFile);
       $multipart_form =   [
                                [
                                    'name' => 'docPath',
                                    'contents' => $jsonFile
                                ]
                                ,
                                [
                                   'name' => 'content',
                                   'contents' => $filecontent
                                ]

                            ];

      $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
       $cek = $client->post(config('app.DMS_URL_SVC').'document/createSimple',[
                    'auth' => [config('app.DMS_USER'),config('app.DMS_PASSWORD')],
                    'headers' => [  
                                    'Accept' => 'application/json'
                                    
                                ],
                   // 'multipart' => $multipart_form,
                   'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

       if ($cek->getStatusCode() == 200) {
       
              $response =  $cek->getBody()->getContents();
              
                $response1 = json_decode($response);
                //var_dump($response1);die();
               if (isset($response1->created)) {
                       $return1 = array(
                              "status_code" => "00",
                              "status_message" => 'Upload File Success',
                              "uuid" => $response1->uuid
                               
                          );
               } else {
                        $return1 = array(
                               "status_code" => "98",
                                 "status_message" => 'Upload File Error'
                               
                          );
               
               } 
                       
       } else {
       
              $return1 = array(
                                 "status_code" => "99",
                                 "status_message" => 'Upload File Error'
                                  
                            );
       
       }
       return json_encode($return1);
                     

    } // function upload
    
    public function downloadFile($uuid) {

      $docpath = '';
      $client = new Client();
      $tmp = '';
      $filename = '';
      $longfilename='';
      $cek = $client->get(config('app.DMS_URL_SVC').'document/getProperties?docId='.$uuid,[
        'headers' => [  
            'Accept' => 'application/json'
            
        ], 
        'auth' => [config('app.DMS_USER'),config('app.DMS_PASSWORD')],
        'verify' => false
    ]);

    if ($cek->getStatusCode() == 200) {

            $tmp =  json_decode($cek->getBody()->getContents());
            $longfilename = $tmp->path;


    }
       $filename = str_replace("/","_",$longfilename);
       $cek = $client->get(config('app.DMS_URL_SVC').'document/getContent?docId='.$uuid,[
                    'auth' => [config('app.DMS_USER'),config('app.DMS_PASSWORD')],
                    'verify' => false
                ]);

       if ($cek->getStatusCode() == 200) {
       
                      $response =  $cek->getBody()->getContents();
               
                       $return1 = array(
                              "status_code" => "00",
                              "status_message" => 'Download File Success',
                              "uuid" => $uuid,
                              "filename" => $filename,
                              "content" =>  base64_encode($response)
                               
                          );
            
                       
       } else {
       
              $return1 = array(
                                 "status_code" => "99",
                                 "status_message" => 'Download File Error'
                                  
                            );
       
       }
       return json_encode($return1);
                     

    } // function download
    
    
    
    
}
