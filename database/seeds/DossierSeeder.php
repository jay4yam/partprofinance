<?php

use Illuminate\Database\Seeder;

class DossierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::transaction(function (){
            factory(\App\Models\Dossier::class, 20)->create();
        });
    }
}
