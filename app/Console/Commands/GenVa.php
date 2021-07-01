<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Investor;

class GenVa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'console:genVA {users*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate VA for inputed user id';

    private const CLIENT_ID = '757';
    private const KEY = '9f918ff65dc67027fc5670b7b7a7e89f';
    private const API_URL = 'https://api.bni-ecollection.com/';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $users_id = $this->argument('users');
        $users = Investor::whereIn('id',$users_id)->get();
        foreach($users as $user){
            $message = generateVa($user);
            $this->info($message);
        }
    }
    private function generateVA($user){
        $data = [
            'type' => 'createbilling',
            'client_id' => self::CLIENT_ID,
            'trx_id' => "1000".$user->id,
            'trx_amount' => '0',
            'customer_name' => $user->username,
            'customer_email' => $user->email,
            'virtual_account' => '8'.self::CLIENT_ID.$user->detilInvestor->getVa(),
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
            return False;
        }
        else{
	        $decrypted = BniEnc::decrypt($result->data,self::CLIENT_ID,self::KEY);
            //return json_encode($decrypted);
            $rekening = $user->RekeningInvestor;
            $rekening->va_number = $decrypted['virtual_account'];
            $rekening->save();
            
            return True;
            // return view('pages.user.add_funds')->with('message','VA Generate Success!');
         }
    }
}
