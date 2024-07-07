<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Account::create([
            'user_id' => 1,
            'balance' => 1000,
        ]);

        Account::create([
            'user_id' => 2,
            'balance' => 500,
        ]);

    }
}
