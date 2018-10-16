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
        /*
        $this->call(ProspectSeeder::class);
        $this->call(BanqueSeeder::class);
        $this->call(DossierSeeder::class);
        $this->call(PortetUserSeeder::class);
        */

        //$this->call(SuperUserSeeder::class);
        //$this->call(SalesUserSeeder::class);
        //$this->call(BanqueSeeder::class);
        //$this->call(InsertOldTempProspectData::class);
        //$this->call(InsertOldProspectData::class);
        $this->call(InsertOldDossierData::class);
    }
}
