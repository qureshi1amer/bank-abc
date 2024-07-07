<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\TransactionResource;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends ApiBaseController
{
    public function getTransactions()
    {
        /**
         * @var  $transactions Transaction[]
         */
        $user = Auth::user();
        $outwards = $user->account?->outWardtransactions()->paginate(10);
        $inwards = $user->account?->inWardtransactions()->paginate(10);

        $outwards->load('fromAccount.user', 'toAccount.user');
        $inwards->load('fromAccount.user', 'toAccount.user');

         $inwardTransactions =   TransactionResource::collection($inwards);
         $outWardTransactions =   TransactionResource::collection($outwards);


        return response()->json([
            'inwards' => $inwardTransactions,
            'outwards' => $outWardTransactions
        ] );
    }
}
