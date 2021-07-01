<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;


use App\Investor;
use App\DetilInvestor;

class KirimEmailController extends Controller
{
    

    public function BroadcastEmail($data)
    {
      // dd($data);
      
      // echo date('h:i:s');die;
      $title = $data['title']; 
      $content = $data['content'];
      $list = $data['list_id'];
      $timeString = strtotime(Carbon::now());
      $time = time();
      $generated_token = hash_hmac("sha256","DanaSyariah"."::"."wDYMzq3Vj5OIFnaWk0r1uvLtRGPN8elbDanaSyariah"."::".$time,"wDYMzq3Vj5OIFnaWk0r1uvLtRGPN8elbDanaSyariah");
      $user = Investor::get();
      
      // echo $request->judul_email;die;
    
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.kirim.email/v3/broadcast/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\n  \"title\" : \"$title\",\n  \"sender\": \"info@danasyariah.id\",\n  \"messages\":[\n  {\n    \"subject\" : \"$title\",\n    \"content\" : \"$content\"\n  }\n  ],\n  \"list\":\"$list\",\n  \"send_at\":\"2018-12-30 00:00:00\"\n}",
        CURLOPT_HTTPHEADER => array(
          "Auth-Id:DanaSyariah",
          "Auth-Token:".$generated_token,
          "Timestamp:".$timeString,
          "Content-Type: application/x-www-form-urlencoded"
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);

      dd($response);

      return $response;

    }

    public function ListGroup()
    {      
      $timeString = strtotime(Carbon::now());
      $time = time();
      $generated_token = hash_hmac("sha256","DanaSyariah"."::"."wDYMzq3Vj5OIFnaWk0r1uvLtRGPN8elbDanaSyariah"."::".$time,"wDYMzq3Vj5OIFnaWk0r1uvLtRGPN8elbDanaSyariah");
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.kirim.email/v3/list",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "Auth-Id:DanaSyariah",
          "Auth-Token:".$generated_token,
          "Timestamp:".$timeString,
        ),
      ));
      
      $response = curl_exec($curl);
      

      $result = json_decode($response,true);
      $result['data'];
      $data = array();
      foreach($result['data'] as $item)
      {
       $data[] = '<option value="'.$item['id'].'">'.$item['name'].'</option>';
      }
      return $data;
    }

    public function CreateList($data)
    {
      $timeString = strtotime(Carbon::now());
      $time = time();
      $generated_token = hash_hmac("sha256","DanaSyariah"."::"."wDYMzq3Vj5OIFnaWk0r1uvLtRGPN8elbDanaSyariah"."::".$time,"wDYMzq3Vj5OIFnaWk0r1uvLtRGPN8elbDanaSyariah");

      // dd($data);
      $name_group = $data['title'];

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.kirim.email/v3/list",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "name=".$name_group,
        CURLOPT_HTTPHEADER => array(
          "Auth-Id:DanaSyariah",
          "Auth-Token:".$generated_token,
          "Timestamp:".$timeString,
          "Content-Type: application/x-www-form-urlencoded"
        ),
      ));
      
      $response = curl_exec($curl);
      
      curl_close($curl);
      return $response;

    }

    public function CreateSubscriber($data)
    {

      $timeString = strtotime(Carbon::now());
      $time = time();
      $generated_token = hash_hmac("sha256","DanaSyariah"."::"."wDYMzq3Vj5OIFnaWk0r1uvLtRGPN8elbDanaSyariah"."::".$time,"wDYMzq3Vj5OIFnaWk0r1uvLtRGPN8elbDanaSyariah");
      $id = $data['id'];

      if($data['list_id'] == 1)
      {
        $getData = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                           ->where('investor.status','active')
                           ->select(
                                      [
                                        'investor.id',
                                        'investor.email',
                                        'detil_investor.nama_investor',
                                        'detil_investor.phone_investor',
                                        'detil_investor.alamat_investor'

                                      ]
                           )

                           ->get();
        // dd($getData);
        // $sleepTime = date('h:i:s');
        foreach($getData as $item)
        {
            $curl = curl_init();
      
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.kirim.email/v3/subscriber/",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => "lists=".$id."&full_name=".$item->nama_investor."&email=".$item->email."&fields%5Bno_hp%5D=".$item->phone_investor."&fields%5Balamat%5D=".$item->alamat_investor,
              CURLOPT_HTTPHEADER => array(
                "Auth-Id:DanaSyariah",
                "Auth-Token:".$generated_token,
                "Timestamp:".$timeString,
                "Content-Type: application/x-www-form-urlencoded"
              ),
            ));
            $response = curl_exec($curl);
            sleep(2);
            curl_close($curl);
            
      
        }


        return $response;

      }

      if($data['list_id'] == 2)
      {
        $getData = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                           ->where('investor.status','notfilled')
                           ->select(
                                      [
                                        'investor.id',
                                        'investor.email',
                                        'detil_investor.nama_investor',
                                        'detil_investor.phone_investor',
                                        'detil_investor.alamat_investor'

                                      ]
                           )

                           ->get();
        foreach($getData as $item)
        {
            $curl = curl_init();
      
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.kirim.email/v3/subscriber/",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => "lists=".$id."&full_name=".$item->nama_investor."&email=".$item->email."&fields%5Bno_hp%5D=".$item->phone_investor."&fields%5Balamat%5D=".$item->alamat_investor,
              CURLOPT_HTTPHEADER => array(
                "Auth-Id:DanaSyariah",
                "Auth-Token:".$generated_token,
                "Timestamp:".$timeString,
                "Content-Type: application/x-www-form-urlencoded"
              ),
            ));
            $response = curl_exec($curl);
            sleep(2);
            curl_close($curl);
            
      
        }

      }

      if($data['list_id'] == 3)
      {
        
        $getData = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                           ->where('investor.id',752)
                           ->select(
                                      [
                                        'investor.id',
                                        'investor.email',
                                        'detil_investor.nama_investor',
                                        'detil_investor.phone_investor',
                                        'detil_investor.alamat_investor'

                                      ]
                           )

                           ->first();
        // dd($getData);
        // $sleepTime = date('h:i:s');
        // foreach($getData as $item)
        // {
            $curl = curl_init();
      
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.kirim.email/v3/subscriber/",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => "lists=".$id."&full_name=".$getData->nama_investor."&email=".$getData->email."&fields%5Bno_hp%5D=".$getData->phone_investor."&fields%5Balamat%5D=".$getData->alamat_investor,
              CURLOPT_HTTPHEADER => array(
                "Auth-Id:DanaSyariah",
                "Auth-Token:".$generated_token,
                "Timestamp:".$timeString,
                "Content-Type: application/x-www-form-urlencoded"
              ),
            ));
            $response = curl_exec($curl);
            sleep(2);
            curl_close($curl);
            
      
        // }
        return $response;
      }
      
      return $response;

    }
    

}
