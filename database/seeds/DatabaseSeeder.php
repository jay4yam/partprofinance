<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(SuperUserSeeder::class);
        //$this->call(ProspectSeeder::class);
        $this->call(BanqueSeeder::class);
    }
}
