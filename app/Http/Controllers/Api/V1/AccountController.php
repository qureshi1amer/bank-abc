<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\DepositRequest;
use App\Http\Requests\TransferRequest;
use App\Http\Resources\AccountResource;
use App\Repositories\AccountRepository;
use Illuminate\Support\Facades\Auth;

class AccountController extends ApiBaseController
{
    public function __construct(protected AccountRepository $accountRepository){}

    public function getAccountDetails()
    {
        return response()->api(new AccountResource(Auth::user()));
    }

    public function deposit(DepositRequest $request)
    {
        $account = $this->accountRepository->deposit(Auth::user(), $request->amount);
        return response()->api(['balance' => $account->balance], __('api.message.deposit_successful'));
    }

    public function transfer(TransferRequest $request)
    {
        try {
            $this->accountRepository->transfer($request->to_account_id, $request->amount);
            return response()->api(null, __('api.message.transfer_successful'));
        }
        catch (\Exception $e) {
            return response()->api(['error' => $e->getMessage()], __('api.message.failed_transfer'), 500);
        }
    }
}
