<?php

namespace App\Rules\Api\V1;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Contracts\Validation\Rule;

class CardNumberRule implements InvokableRule
{

    public function __invoke($attribute, $value, $fail)
    {
        $cardNumber = auth()->user()->cardNumbers()->where("card_number", $value)->first();
        if (!$cardNumber) $fail("card number is not valid");
    }
}
