<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Withdraw\GetBalanceRequest;
use App\Http\Requests\Api\V1\Withdraw\PayRequest;
use App\Http\Requests\Api\V1\Withdraw\TransferRequest;
use App\Http\Requests\Api\V1\Withdraw\WithdrawRequest;
use App\Repositories\Withdraw\WithdrawRepository;
use App\Services\BankService\BankHandlerService;
use App\Services\CheckAccountBalanceService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BankController extends ApiController
{
    public function __construct(protected WithdrawRepository $withdrawRepository, protected CheckAccountBalanceService $accountBalanceService)
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

    public function pay(PayRequest $request)
    {
        $bankService = BankHandlerService::setBank($request->bank);
        $pay = $bankService->pay($request->card_number, $request->amount);
        $withdraw = $this->withdrawRepository->create([
            "user_id" => auth()->id(),
            "bank" => $request->bank,
            "amount" => $pay,
            "type" => WithdrawRepository::PAY
        ]);
        return self::success("payment was successful", $withdraw, Response::HTTP_ACCEPTED);
    }

    public function withdraw(WithdrawRequest $request)
    {
        $bankService = BankHandlerService::setBank($request->bank);

        $accountBalance = $this->accountBalanceService->check($bankService, $request);
        if (!$accountBalance)
            return self::error("you don't have enough balance!", code: Response::HTTP_FORBIDDEN);

        $withdrawResult = $bankService->withdraw($request->shaba_number, $request->amount, $request->to);
        $withdraw = $this->withdrawRepository->create([
            "user_id" => auth()->id(),
            "bank" => $request->bank,
            "amount" => $withdrawResult,
            "type" => WithdrawRepository::WITHDRAW
        ]);
        return self::success("withdraw was successful", $withdraw, Response::HTTP_ACCEPTED);
    }


    public function transfer(TransferRequest $request)
    {
        $bankService = BankHandlerService::setBank($request->bank);
        $accountBalance = $this->accountBalanceService->check($bankService, $request);
        if (!$accountBalance)
            return self::error("you don't have enough balance!", code: Response::HTTP_FORBIDDEN);
        DB::beginTransaction();
        try {

            $withdrawResult = $bankService->withdraw($request->shaba_number, $request->amount, $request->to);

            DB::table("withdraws")->insert([
                "user_id" => auth()->id(),
                "bank" => "mammad",
                "amount" => $withdrawResult,
                "type" => WithdrawRepository::WITHDRAW
            ]);
            $pay = $bankService->pay($request->to, $request->amount);

            DB::table("withdraws")->insert([
                "user_id" => auth()->id(),
                "bank" => $request->bank,
                "amount" => $pay,
                "type" => WithdrawRepository::PAY
            ]);
            DB::commit();
            return self::success("transfer completed successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }


    }

}
