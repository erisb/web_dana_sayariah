<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InvestorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('investor')->insert([
            'username' => 'bramganteng',
            'email' => 'ndutank46@gmail.com',
            'password' => bcrypt('bramganteng'),
            'ref_number' => bcrypt('bramganteng'),
            'status'=> 'active',
            'last_login' => Carbon::parse('2018-01-01')
        ]);
    }
}
