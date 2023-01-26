<?php

namespace App\Rules\Api\V1;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Contracts\Validation\Rule;

class ShabaNumberRule implements InvokableRule
{
    public function __invoke($attribute, $value, $fail)
    {
        $cardNumber = auth()->user()->cardNumbers()->where("shaba_number", $value)->first();
        if (!$cardNumber) $fail("shaba number is not valid");
    }
}
