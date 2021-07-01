<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(gambarProyekSeeder::class);
        // $this->call(InvestorTableSeeder::class);
        $this->call(ProyekTableSeeder::class);
        $this->call(AdminTableSeeder::class);
    }
}
