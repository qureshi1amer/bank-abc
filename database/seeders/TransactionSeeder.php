<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Transaction::create([
            'from_account_id' => 1,
            'to_account_id' => 2,
            'amount' => 100,
        ]);

        Transaction::create([
            'from_account_id' => 2,
            'to_account_id' => 1,
            'amount' => 50,
        ]);

    }
}
