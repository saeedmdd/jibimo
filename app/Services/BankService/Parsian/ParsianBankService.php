<?php

namespace App\Services\BankService\Parsian;

use App\Services\BankService\BankServiceInterface;
use Illuminate\Support\Facades\Http;
use Exception;

class ParsianBankService implements BankServiceInterface
{

    /**
     * @param string|null $cardNumber
     * @return string
     */
    public function getBalance(?string $cardNumber = null, string|null $shabaNumber = null): string
    {
        try {
            $response = file_get_contents(base_path("app/Services/BankService/Parsian/parsian.json"));
            Http::fake(["parsian.ir" => Http::response($response)]);
            $response = json_decode($response);
            return $response->balance;
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * @param string $cardNumber
     * @param int $amount
     * @return string
     */
    public function pay(string $cardNumber, int $amount): string
    {
        try {

            Http::fake(["parsian.ir" => Http::response(["message" => "$amount added to $cardNumber"])]);
            return $amount;
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function withdraw(string $shabaNum, int $amount, string $to): string
    {
        try {
            Http::fake(["parsian.ir" => Http::response(["message" => "$amount decreased from $shabaNum"])]);
            return -1 * $amount;
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }
}
