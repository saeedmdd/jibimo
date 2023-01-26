<?php

namespace App\Http\Requests\Api\V1\Withdraw;

use App\Rules\Api\V1\CardNumberRule;
use Illuminate\Foundation\Http\FormRequest;

class GetBalanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            "card_number" => ["required","exists:card_numbers,card_number", new CardNumberRule()]
        ];
    }
}
