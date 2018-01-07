<?php

use Illuminate\Database\Seeder;

class ProspectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::transaction(function (){
            factory(App\Models\User::class, 20)->create()->each(function ($u) {
                $u->prospect()->save(factory(App\Models\Prospect::class)->make());
            });
        });

    }
}
