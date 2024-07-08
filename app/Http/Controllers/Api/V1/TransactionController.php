<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\TransactionResource;
use App\Repositories\TransactionRepository;

class TransactionController extends ApiBaseController
{
    public function __construct(protected  TransactionRepository $transactionRepository){}

    public function getTransactions()
    {
        $transactions = $this->transactionRepository->getTransactions();

        $inwardTransactions = TransactionResource::collection($transactions['inwards']);
        $outWardTransactions = TransactionResource::collection($transactions['outwards']);

        return response()->api(['inwards' => $inwardTransactions, 'outwards' => $outWardTransactions], __('api.message.registration_successful'));
    }
}
