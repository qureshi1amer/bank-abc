<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'Ammar Qureshi',
            'email' => 'ammarqureshi@outlook.com',
            'password' => Hash::make('12345'),
        ]);

        User::create([
            'name' => 'Sam',
            'email' => 'sam@gmail.com',
            'password' => Hash::make('12345'),
        ]);
    }
}
