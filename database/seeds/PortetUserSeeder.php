<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class PortetUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'emylie',
            'email' => 'partprofinance.ed@gmail.com',
            'password' => bcrypt('Miniboo27'),
            'role' => 'staff',
            'avatar' => 'avatar2.png'
        ]);

        User::create([
            'name' => 'sebastien',
            'email' => 'partprofinance@gmail.com',
            'password' => bcrypt('Martinez06'),
            'role' => 'admin',
            'avatar' => 'avatar04.png'
        ]);
    }
}
