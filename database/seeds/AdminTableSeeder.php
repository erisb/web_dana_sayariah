<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'firstname'=>'brama',
            'lastname' => 'diwangkara',
            'email' => 'ndutank46@gmail.com',
            'address'=> 'Keputih, Surabaya',
            'password' => bcrypt('ndutank46'),
        ]);

        DB::table('admins')->insert([
            'firstname'=>'janar',
            'lastname' => 'dana',
            'email' => 'prahita11@gmail.com',
            'address'=> 'Keputih, Surabaya',
            'password' => bcrypt('123456'),
        ]);
    }
}
