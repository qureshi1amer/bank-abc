<?php

namespace App\Repositories;

use App\Events\TransactionSuccessEvent;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AccountRepository
{
    /**
     * Get the account details for the authenticated user.
     */
    public function getAccountDetails($user) :Account
    {
        return $user->account;
    }

    /**
     * Deposit amount to the authenticated user's account.
     */
    public function deposit($user, $amount) :  Account
    {
        $account = $user->account;
        $account->update([ 'balance' => $account->balance + $amount]);
        return $account;
    }

    /**
     * Transfer amount from one account to another.
     */
    public function transfer($toAccountId, $amount)
    {
        $fromAccount = Auth::user()->account()->first();
        $toAccount = Account::findOrFail($toAccountId);

        DB::beginTransaction();
        try {
            $fromAccount->balance -= $amount;
            $fromAccount->save();

            $toAccount->balance += $amount;
            $toAccount->save();

           $transaction =  Transaction::create([
                'from_account_id' => $fromAccount->id,
                'to_account_id' => $toAccount->id,
                'amount' => $amount,
            ]);
            DB::commit();
            event(new TransactionSuccessEvent($transaction));
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Transacting: ' . $e->getMessage());
            throw $e;
        }
    }
}
