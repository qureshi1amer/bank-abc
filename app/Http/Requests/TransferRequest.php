<?php

namespace App\Http\Requests;
use App\Rules\HasSufficientBalance;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class TransferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'to_account_id' => [
                'required',
                'exists:accounts,id',
                function ($attribute, $value, $fail) {
                    $fromAccountId = Auth::user()->id;

                    if ($value == $fromAccountId) {
                        $fail('The account id  must be different from the source account.');
                    }
                },
            ],
            'amount' => ['required', 'numeric', 'min:0.01', new HasSufficientBalance],
        ];
    }


    public function messages()
    {
        return [
            'to_account_id.required' => 'The recipient account ID is required.',
            'to_account_id.exists' => 'The recipient account ID must exist.',
            'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The amount must be at least 0.01.',
        ];
    }
}
