<?php
namespace App\Http\Controllers;

use App\Http\Middleware\XML2Array;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use SoapClient;
use SoapHeader;
use App\User;
use Hash; 
use Log;
use App\Borrower;
use App\BorrowerDetails;
use App\Proyek; 

class PefindoController extends Controller
{
	
	
    public function __construct()
    {
        $this->secret = "E024987986051E074EAEB65192F3042A";
        $this->inquiryReffId = $this->generate_guid();
    }

    public static function generate_guid()
    {
        $random_code = str_split(hash("md5",mt_rand(0,999999)),1) ;
        // dd($random_code);
        $guiid = "";
        foreach( $random_code as $key => $str)
        {
            if($key<28)
            {
                
                if(($key == 8)or($key == 11)or($key == 14)or($key == 17))
                {
                    $guiid.="-".$str;
                }
                $guiid.=$str;
            }
        }

        return $guiid;
    }
    private function setHeader()
    {
      
        $header = new SoapHeader(
            'http://tempuri.org/', 
            'AuthHeader', 
            array(
                "UserName" => config("app.pefindo_user"),
                "Password" => config("app.pefindo_password")
				//"UserName" => env('PEFINDO_USER'),
                //"Password" => env('PEFINDO_PASSWORD')
            ),
            false
        );   
        return $header;
    }

    private function initSoap()
    {
    //    libxml_disable_entity_loader(false); 
        $PEFINDO_WSDL = config("app.pefindo_wsdl");
	$PEFINDO_LOCATION  = config("app.pefindo_location");
          $PEFINDO_URI = config("app.pefindo_uri");
	$PEFINDO_USER = config("app.pefindo_user");
	$PEFINDO_PASSWORD = config("app.pefindo_password");

        try {
            
			
			
			
            return new SoapClient($PEFINDO_WSDL, array(
                "uri" => $PEFINDO_LOCATION,
                "location" => $PEFINDO_LOCATION,
		"login" => $PEFINDO_USER,
                "password" => $PEFINDO_PASSWORD,
				"trace" => 1,
				"debug" =>true,
				"exceptions" => true
   
            )); 
        }catch(Exception $e)
        {
            return [
                "status_code"=>"03",
                "message" => "Terjadi kesalahan pada server"
            ];
        }
    }

    private function callSoap($parameter, $fungsi)
    {
		// syslog(0,"fungsi = ".$fungsi." parameter=".json_encode($parameter));
		if ($fungsi=="GetCustomReport") {
			$init = $this->initSoap();
			$header = $this->setHeader();
			try {
				 // syslog(0,"header getcustomreport = ".json_encode($header)); 
				$return1 =$init->__soapCall($fungsi, array($parameter), null, $header);
				if (is_soap_fault($return1)) {
				//	syslog(0,"Error1=".json_encode($return1));
				}else {
					// syslog(0,json_encode($init->__getLastRequest()));
					return $return1;
				} 
			}catch (SoapFault $ex) {
				syslog(0,"ERROR=".$ex->faultstring); 
			}
		} else {
			
			$init2 = $this->initSoap();
			$header = $this->setHeader();
			try {

				$return1 =$init2->__soapCall($fungsi, array($parameter), null, $header);

				// syslog(0,json_encode($init2->__getLastRequest()));
				return $return1;
			} catch (SoapFault $exception) {

			}


		}

    }
    public function SmartSearch($id1)
    {

        $data1 = BorrowerDetails::where('brw_id',$id1)->first();
// syslog(0,"json=".json_encode($data1));
		if ($data1->brw_type == 1) {

			$DateOfBirth = $data1->tgl_lahir;
			$FullName = $data1->nama;
            $IdNumber = $data1->ktp;
			$ret = $this->SmartSearchIndividual2($DateOfBirth,$FullName,$IdNumber);

		} else {
			$FullName = $data1->nm_bdn_hukum;
			$IdNumber = $data1->npwp;
			$ret = $this->SmartSearchCorporate2($FullName,$IdNumber);

		}

         return $ret;
    }

   /* 
    public function SmartSearchIndividual($id1)
    {
         
         $data1 = BorrowerDetails::where('brw_id',$id1)->first();
         $DateOfBirth = $data1->tgl_lahir;
         $FullName = $data1->nama;
         $IdNumber = $data1->ktp;
         
         
         $ret = $this->SmartSearchIndividual2($DateOfBirth,$FullName,$IdNumber);

     return $ret;
    }
    */

     public function SmartSearchCorporate2($FullName,$IdNumber)
    {

        $parameter =  array(
            "query" => array (
				"InquiryReason" => "ProvidingFacilities",
                "InquiryReasonText" => "",
                "Parameters" => array (
					"CompanyName" => $FullName,
					"IdNumbers" => array (
						"IdNumberPairCompany" => array (
						"IdNumber" => $IdNumber,
						"IdNumberType" => "NPWP"
						)
					)
                )

            )

        );

		$resp = $this->callSoap($parameter, "SmartSearchCompany");
		// syslog(0,"Smart Search Company Response=".json_encode($resp));

		// syslog(0,"STATUS = ".$resp->SmartSearchCompanyResult->Status);

		if($resp->SmartSearchCompanyResult->Status== null)
		{
			$return1= array(
               "status_code" => "05",
               "status_message" => $resp->SmartSearchCompanyResult

			);
		}

		if($resp->SmartSearchCompanyResult->Status == "SubjectNotFound")
		{
            $return1= array(
                "status_code" => "14",
                "status_message" => $resp->SmartSearchCompanyResult
            );
		} 
		else if($resp->SmartSearchCompanyResult->Status == "SubjectFound") {

            if (!is_array($resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord)) {

                // single hit
					$return1 = array(
                        "status_code" => "00",
                        "num_record" => 1,
                        "data" => array (
                              "CompanyName" => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->CompanyName,
                              "Address"   => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->Address,
                              "NPWP" => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->NPWP,
                              "PefindoId" => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->PefindoId
                        )

					);

				$PefindoId =  $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->PefindoId;
           

				$Date1 =  \Carbon\Carbon::now()->format('Y-m-d');
                $return2 = $this->GetCustomReport($PefindoId,$Date1, 'Company');
                $return1 = array(
					"status_code" => "00",
					"num_record" => 1,
					"data" => array (
						"CompanyName" => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->CompanyName,
						"Address"   => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->Address,
						"NPWP" => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->NPWP,
						"PefindoId" => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->PefindoId

					 ),
					 "detail" => $return2
    
                );
				
				// syslog(0,"return1 = ".json_encode($return1));

			} else {

                // multiple hit

                $data = array();
                $cnt = count($resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord);
                for ($i=0;$i<$cnt;$i++) {

                    $tmp = array (
						"CompanyName" => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->CompanyName,
						"Address"   => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->Address,
						"NPWP" => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->NPWP,
						"PefindoId" => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->PefindoId
                    );
                    array_push($data,$tmp);

                }

				$return1 = array(
					"status_code" => "00",
					"num_record" => $cnt,
					"data"   => $data
				);
            }
        }
		return json_encode($return1);
  	}
	
	
    public function SmartSearchIndividual2($DateOfBirth,$FullName,$IdNumber)
    {
        
        $parameter =  array(
            "query" => array (
                "InquiryReason" => "ProvidingFacilities",
                "InquiryReasonText" => "",
                "Parameters" => array (
					"DateOfBirth" => $DateOfBirth,
                    "FullName" => $FullName,
                    "IdNumbers" => array (
						"IdNumberPairIndividual" => array (
							"IdNumber" => $IdNumber,
							"IdNumberType" => "KTP"
						)
                    )
                )
                
            )
            
        );

        $resp = $this->callSoap($parameter, "SmartSearchIndividual");
		// syslog(0,"Smart Search Individual Response=".json_encode($resp));

		// syslog(0,"STATUS = ".$resp->SmartSearchIndividualResult->Status);

		if($resp->SmartSearchIndividualResult->Status== null)
		{
			$return1= array(
				"status_code" => "05",
				"status_message" => $resp->SmartSearchIndividualResult
			   
			);
		}

		if($resp->SmartSearchIndividualResult->Status == "SubjectNotFound")
		{
            $return1= array(
                "status_code" => "14",
                "status_message" => $resp->SmartSearchIndividualResult 
            );
			
		} 
		else if($resp->SmartSearchIndividualResult->Status == "SubjectFound") {

		// syslog(0,"resp=".json_encode($resp));

         
            if (!is_array($resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord)) {
               
				// single hit
				/*
								 syslog(0,"d1=".$resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord->FullName);
					 syslog(0,"d2=".$resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord->Address);
					syslog(0,"d3=".$resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord->DateOfBirth);

					syslog(0,"d4=".$resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord->PefindoId);
				 */

				$Date1 =  \Carbon\Carbon::now()->format('Y-m-d');
				$PefindoId =  $resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord->PefindoId;
				$return2 = $this->GetCustomReport($PefindoId,$Date1, 'Individual');// $this->GetCustomReportIndividual($PefindoId);
				$return1 = array(
					"status_code" => "00",
					"num_record" => 1,
					"data" => array (
						"FullName" => $resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord->FullName,
						"Address"   => $resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord->Address,
						"DateOfBirth" => $resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord->DateOfBirth,
						"KTP" => $resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord->KTP,
						"PefindoId" => $resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord->PefindoId
					),
					"detail" => $return2
				);  
            } else {
               
               
                // multiple hit
                  
                $data = array();
                $detail = array();
                $cnt = count($resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord); 
                for ($i=0;$i<$cnt;$i++) {
                    $Date1 =  \Carbon\Carbon::now()->format('Y-m-d');
                    $PefindoId = $resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord[$i]->PefindoId;
                    $return2 = $this->GetCustomReport($PefindoId,$Date1, 'Individual');
                     
                    $tmp = array (
                        "FullName" => $resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord[$i]->FullName,
                        "Address" => $resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord[$i]->Address,
                        "DateOfBirth" => $resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord[$i]->DateOfBirth,
                        "KTP" => $resp->SmartSearchIndividualResult->IndividualRecords->SearchIndividualRecord[$i]->KTP,
                        "PefindoId" => $PefindoId,
                     
                    );
                    array_push($data,$tmp);
                    array_push($detail, $return2);
                     
                }
                  
                $return1 = array(
                    "status_code" => "00",
                    "num_record" => $cnt,
                    "data"   => $data, 
                    "detail" =>$detail
                );
                  
                  
            }
        }
		// syslog(0,"return1=".json_encode($return1));
		return json_encode($return1);
    }

	public function generateSoapRequest(){
 
		$soapBody           =   '<soapenv:Body>\r\n<cb5:GetCustomReport>\r\n<cb5:parameters>\r\n<cus:Consent>true</cus:Consent>\r\n<cus:IDNumber>71612266</cus:IDNumber>\r\n<cus:IDNumberType>PefindoId</cus:IDNumberType>\r\n<cus:InquiryReason>ProvidingFacilities</cus:InquiryReason>\r\n<cus:InquiryReasonText/>\r\n<cus:ReportDate>2018-10-01</cus:ReportDate>\r\n<cus:Sections>\r\n<arr:string>CIP</arr:string>\r\n<arr:string>SubjectInfo</arr:string>\r\n<arr:string>SubjectHistory</arr:string>\r\n<arr:string>ContractList</arr:string>\r\n<arr:string>Inquiries</arr:string>\r\n</cus:Sections>\r\n<cus:SubjectType>Individual</cus:SubjectType>\r\n</cb5:parameters>\r\n</cb5:GetCustomReport>\r\n</soapenv:Body>\r\n';

		$openSoapEnvelope   =   '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/">\r\n';
		$soapHeader         =   '<soap:Header/>\r\n';

		$closeSoapEnvelope   =   '</soap:Envelope>';
	 
	 
	 
		$xmlRequest         = $openSoapEnvelope.$soapHeader.$soapBody.$closeSoapEnvelope;
		// syslog(0,"XML Request =".$xmlRequest);
		
		$client = new Client();

		$options = [
			'body'    => $xmlRequest,
			'headers' => [
				"Content-Type" => "text/xml",
				"accept-encoding" => "gzip, deflate",
				"SOAPAction" => "http://creditinfo.com/CB5/IReportPublicServiceBase/GetCustomReport"
				//  "Authorization" => "Basic ZXJpLmRhbmFzeWFyaWFoOkJlcmluZ2luNzAx"
			],
			'auth' => ['eri.danasyariah','Beringin701']
		];

		try {
			$res = $client->request(
				'POST',
				'https://cbs5bodemo2.pefindobirokredit.com/WsReport/v5.53/Service.svc',
				 $options
			);

			// syslog(0,"RESP BODY=".$res->getBody());
		} catch (RequestException $e) {

			// Catch all 4XX errors 

			// To catch exactly error 400 use 
			if ($e->getResponse()->getStatusCode() == '400') {
				syslog(0,"Got response 400");
			}

			// You can check for whatever error status code you need 

		} catch (\Exception $e) {

			// There was another exception.

		}
	}    

     public function GetPdfReport($IDNumber,$SubjectType){



        $Consent = 'true';
        $IDNumberType = 'PefindoId';
        $InquiryReason = 'ProvidingFacilities';
        $InquiryReasonText = '';
        $LanguageCode='id-ID'; 
        $reportname = 'CIP, SubjectInfoHistory, ContractList, ContractSummary, SubjectInfo';
        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cb5="http://creditinfo.com/CB5" xmlns:cus="http://creditinfo.com/CB5/v5.53/PdfReport" xmlns:arr="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                   <soapenv:Header/>
                   <soapenv:Body>
                                <cb5:GetPdfReport>
                                        <!--Optional:-->
                                        <cb5:parameters>
                                        <!--Optional:-->
                                        <cus:Consent>'.$Consent.'</cus:Consent>
                                        <!--Optional:-->
                                        <cus:IDNumber>'.$IDNumber.'</cus:IDNumber>
                                        <!--Optional:-->
                                        <cus:IDNumberType>'.$IDNumberType.'</cus:IDNumberType>
                                        <!--Optional:-->
                                        <cus:InquiryReason>'.$InquiryReason.'</cus:InquiryReason>
                                         <!--Optional:-->
                                        <cus:InquiryReasonText>'.$InquiryReasonText.'</cus:InquiryReasonText>
                                        <!--Optional:-->
                                        <cus:LanguageCode>'.$LanguageCode.'</cus:LanguageCode>
                                        <cus:ReportName>'.$reportname.'</cus:ReportName>
                                         
                                        <!--Optional:-->
                                        <cus:SubjectType>'.$SubjectType.'</cus:SubjectType>
                                 </cb5:parameters>
                                </cb5:GetPdfReport>
                     </soapenv:Body>
                </soapenv:Envelope>';

                // echo($xml_post_string);
                // die();
                
                $soapAction =  "http://creditinfo.com/CB5/IReportPublicServiceBase/GetPdfReport";
                $soapUser =  config("app.pefindo_user");
                $soapPassword =  config("app.pefindo_password");
                $soapUrl = config("app.pefindo_wsdl");
                $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "SOAPAction: ".$soapAction,
                        "Content-length: ".strlen($xml_post_string),
                ); //SOAPAction: your op URL

                $url = $soapUrl;

                // PHP cURL  for https connection with auth
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                 // converting
                $response = curl_exec($ch);
                curl_close($ch);
                try {
                        if (stripos($response, '<s:Envelope xmlns') !== false){
                                $array  = XML2Array::createArray($response);
                                return $array;
                                // return XML2Array::format_json(json_encode($array),true);
                        } else {
                                $array = ["error" => $response ];
                                // echo $response;
                                return json_encode($array);
                        }
                }
                catch (exception $e) {
                        //code to handle the exception
                        return $response;
                }
    }



    public function GetCustomReport($IDNumber,$ReportDate,$SubjectType){

       

        $Consent = 'true';
        $IDNumberType = 'PefindoId'; 
        $InquiryReason = 'ProvidingFacilities'; 
        $InquiryReasonText = '';
        $sSections = "CIP";
        $aSection = explode(',',$sSections);
        $rSections = "";
        foreach($aSection as $item) {
            $rSections = $rSections."<arr:string>".$item."</arr:string>";
        }
        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
		<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cb5="http://creditinfo.com/CB5" xmlns:cus="http://creditinfo.com/CB5/v5.53/CustomReport" xmlns:arr="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
		   <soapenv:Header/>
		   <soapenv:Body>
				<cb5:GetCustomReport>
					<!--Optional:-->
					<cb5:parameters>
					<!--Optional:-->
					<cus:Consent>'.$Consent.'</cus:Consent>
					<!--Optional:-->
					<cus:IDNumber>'.$IDNumber.'</cus:IDNumber>
					<!--Optional:-->
					<cus:IDNumberType>'.$IDNumberType.'</cus:IDNumberType>
					<!--Optional:-->
					<cus:InquiryReason>'.$InquiryReason.'</cus:InquiryReason>
					 <!--Optional:-->
					<cus:InquiryReasonText>'.$InquiryReasonText.'</cus:InquiryReasonText>
					<!--Optional:-->
					<cus:ReportDate>'.$ReportDate.'</cus:ReportDate>
					<!--Optional:-->
					<cus:Sections>
					   <!--Zero or more repetitions:-->
					   '.$rSections.'
					</cus:Sections>
					<!--Optional:-->
					<cus:SubjectType>'.$SubjectType.'</cus:SubjectType>
				 </cb5:parameters>
				</cb5:GetCustomReport>
			</soapenv:Body>
		</soapenv:Envelope>';

		// echo($xml_post_string);
		// die();
$soapAction =  "http://creditinfo.com/CB5/IReportPublicServiceBase/GetCustomReport";
$soapUser =  config("app.pefindo_user");
$soapPassword =  config("app.pefindo_password");
$soapUrl = config("app.pefindo_wsdl");
		$headers = array(
			"Content-type: text/xml;charset=\"utf-8\"",
			"Accept: text/xml",
			"Cache-Control: no-cache",
			"Pragma: no-cache",
			"SOAPAction: ".$soapAction,
			"Content-length: ".strlen($xml_post_string),
		); //SOAPAction: your op URL

		$url = $soapUrl;

		// PHP cURL  for https connection with auth
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		 // converting
		$response = curl_exec($ch);
		curl_close($ch);

		try {
			if (stripos($response, '<s:Envelope xmlns') !== false){
				$array  = XML2Array::createArray($response);
				return $array;
				// return XML2Array::format_json(json_encode($array),true);
			} else {
				$array = ["error" => $response ];
				// echo $response;
				return json_encode($array);
			}
		}
		catch (exception $e) {
			//code to handle the exception
			return $response;
		}
    }
    
    public function SmartSearchCompany($CompanyName,$IdNumber)
    {
        
        $parameter =  array(
            "query" => array (
                "InquiryReason" => "ProvidingFacilities",
                "InquiryReasonText" => "",
                "Parameters" => array (
                           
					"CompanyName" => $FullName,
					"IdNumbers" => array (
						"IdNumberPairCompany" =>  array (
							"IdNumber" => $IdNumber,
							"IdNumberType" => "NPWP"
							   
						)
					)
                )
                
            )
            
        );

        $resp = $this->callSoap($parameter, "SmartSearchCompany");

		if($resp->SmartSearchCompanyResult->Status== null)
		{
			return array(
               "status_code" => "05",
               "status_message" => $resp->SmartSearchCompanyResult
               
			);
		}

		if($resp->SmartSearchCompanyResult->Status == "SubjectNotFound")
		{
            return array(
                "status_code" => "14",
                "status_message" => $resp->SmartSearchCompanyResult 
            );
		} 
		else if($resp->SmartSearchCompanyResult->Status == "SubjectFound") {
         
             // $cnt = count($resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord);
             // if ($cnt == 1) {
             
			if (!is_array($resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord)) {
  
                // single hit
					$cnt=1;
					$return1= array(
                        "status_code" => "00",
                        "num_record" => $cnt,
                        "data" => array (
                            "Address"   => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->Address,
                            "CompanyName"   => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->CompanyName,
                            "NPWP"   => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->NPWP,
                            "PefindoId" => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord->PefindoId
                        )
                        
					);
                
            } else {
               
               
                // multiple hit
                  
                $data = array();
                  
				for ($i=0;$i<$cnt;$i++) {
				 
					$tmp = array (
						"Address"   => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord[$i]->Address,
						"CompanyName"   => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord[$i]->CompanyName,
						"NPWP"   => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord[$i]->NPWP,
						"PefindoId" => $resp->SmartSearchCompanyResult->CompanyRecords->SearchCompanyRecord[$i]->PefindoId
				 
					);
					array_push($data,$tmp);
				 
				}
                  
                $return1= array(
                    "status_code" => "00",
                    "num_record" => $cnt,
                    "data"   => $data 
                );
                  
                  
            }
             
		}
          return json_encode($return1);

    }
    
}