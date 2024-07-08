<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Auth;

class TransactionRepository
{
    public function getTransactions()
    {
        $user = Auth::user();
        $outwards = $user->account?->outWardtransactions()->latest()->paginate(config('constants.pagination.transaction_limit'));
        $inwards = $user->account?->inWardtransactions()->latest()->paginate(config('constants.pagination.transaction_limit'));

        $outwards->load('fromAccount.user', 'toAccount.user');
        $inwards->load('fromAccount.user', 'toAccount.user');

        return [
            'inwards' => $inwards,
            'outwards' => $outwards
        ];
    }
}
