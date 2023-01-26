<?php

namespace App\Services;

use App\Services\BankService\BankServiceInterface;
use Illuminate\Http\Request;

class CheckAccountBalanceService
{
    public function check(BankServiceInterface $bankService, Request $request)
    {
        return $bankService->getBalance(shabaNumber: $request->shaba_number) >= $request->amount;
    }

}
