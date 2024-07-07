<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\DepositRequest;
use App\Http\Requests\TransferRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountController extends ApiBaseController
{
    public function getAccountDetails()
    {
        return new AccountResource(Auth::user());
    }

    public function deposit(DepositRequest $request)
    {
        /**
         * @var  $account Account
         */
        $account = Auth::user()?->account;

        $account->update([
            'balance' => $account->balance + $request->amount
        ]);

        return response()->json([
            'message' => 'Deposit successful',
            'new_balance' => $account->balance
        ]);
    }


    public function transfer(TransferRequest $request)
    {
        /**
         * @var  $fromAccount Account
         * @var  $toAccount Account
         */

        $user = Auth::user();

        $fromAccount = $user->account()->first();
        $toAccount = Account::findOrFail($request->to_account_id);

        DB::beginTransaction();
        try {
            $fromAccount->balance -= $request->amount;
            $fromAccount->save();

            $toAccount->balance += $request->amount;
            $toAccount->save();

            Transaction::create([
                'from_account_id' => $fromAccount->id,
                'to_account_id' => $toAccount->id,
                'amount' => $request->amount,
            ]);

            DB::commit();

            return response()->json(['message' => 'Transfer successful']);

        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Transacting: ' . $e->getMessage());

            return response()->json((object)['message' => 'Failed To Transfer', 'error' => $e->getMessage()],
                500
            );
        }
    }
}
