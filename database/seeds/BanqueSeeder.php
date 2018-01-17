<?php

use Illuminate\Database\Seeder;
use App\Models\Banque;

class BanqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banque::create([
            'nom' => 'cetelem',
            'logo' => 'cetelem_logo.png',
        ]);

        Banque::create([
            'nom' => 'sofinco',
            'logo' => 'sofinco_logo.gif',
        ]);

        Banque::create([
            'nom' => 'franfinance',
            'logo' => 'franfinance_logo.png',
        ]);
    }
}
