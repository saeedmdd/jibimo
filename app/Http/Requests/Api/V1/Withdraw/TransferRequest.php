<?php

namespace App\Http\Requests\Api\V1\Withdraw;

use App\Rules\Api\V1\ShabaNumberRule;
use App\Services\BankService\BankHandlerService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "shaba_number" => ["required", "exists:card_numbers,shaba_number", new ShabaNumberRule()],
            "bank" => ["required", "string", "max:255", Rule::in(BankHandlerService::BANKS)],
            "amount" => ["required", "integer", "max:100000000"],
            "to" => ["required", "digits:16", "integer"]
        ];
    }
}
