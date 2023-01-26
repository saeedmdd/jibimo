<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Withdraw\GetBalanceRequest;
use App\Repositories\Withdraw\WithdrawRepository;
use App\Services\BankService\BankHandlerService;

class BankController extends ApiController
{
    public function __construct(protected WithdrawRepository $withdrawRepository)
    {
    }

    public function getBalance()
    {
        $balance = $this->withdrawRepository->getUserWithdraws();
        return self::success("user withdraws", ["balance" => $balance]);
    }

    public function getBankBalance(string $bank, GetBalanceRequest $request)
    {
        $bankService = BankHandlerService::setBank($bank);
        $balance = $bankService->getBalance($request->card_number);
        return self::success("balance for {$bank}", ["balance" => $balance]);
    }
}
