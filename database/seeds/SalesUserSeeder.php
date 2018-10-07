<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class SalesUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'emillie',
            'email' => 'partprofinance.ed@gmail.com',
            'password' => bcrypt('Miniboo27'),
            'role' => 'pro',
            'avatar' => 'avatar5.png'
        ]);
    }
}
