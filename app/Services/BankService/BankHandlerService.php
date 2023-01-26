<?php

namespace App\Services\BankService;

use App\Services\BankService\Mellat\MellatBankService;
use App\Services\BankService\Parsian\ParsianBankService;
use App\Services\BankService\Pasargad\PasargadBankService;

class BankHandlerService
{
    const BANKS = [
      "parsian",
      "pasargad",
      "mellat"
    ];

    /**
     * @param string $bank
     * @return BankServiceInterface
     */
    public static function setBank(string $bank): BankServiceInterface
    {
        if (!in_array($bank,self::BANKS))
            abort(404, "bank is not valid");
        return match ($bank){
            "pasargad" => new PasargadBankService(),
            "mellat" => new MellatBankService(),
            "parsian" => new ParsianBankService()
        };
    }

}
