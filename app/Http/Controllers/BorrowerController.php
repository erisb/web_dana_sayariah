<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Middleware\NotifikasiProyek;
use App\Http\Middleware\StatusProyek;

class BorrowerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    private const API_LOGIN = 'http://149.129.250.37/api/auth/login';
    private const HEADER_PUSDAFIl = 'application/json';
    private const API_CEK = 'http://149.129.250.37/api/Inquiry/LoanReport/';

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

    public function show(){

        return view('pages.admin.borrower_manage');
    }

    public function search(Request $pusdafil){
        $client = new Client();
        $data_login = [
                            'email' => 'danasyariah@pusdafil.com',
                            'password' => 'dsi123456'
                      ];
        $raw = json_encode($data_login);

        $connect = $client->post(self::API_LOGIN,[
                    'headers' => ['Content-Type' => self::HEADER_PUSDAFIl],
                    'body'  => $raw
                ]);

        $status = json_decode($connect->getBody());
        if ($status->responsCode == '00')
        {
            $bearer = 'Bearer '.$status->token;
            $data_id = [ 'id' => $pusdafil->nik ];
            $id = json_encode($data_id);
            $cek = $client->get(self::API_CEK,[
                    'headers' => [  'Content-Type' => self::HEADER_PUSDAFIl,
                                    'Authorization' => $bearer
                                ],
                    'body'  => $id
                ]);

            return $cek->getBody();
        }
        else
        {
            return response()->json(['data' => 'gagal']);
        }
    }
    
}
