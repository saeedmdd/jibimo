<?php

namespace App\Services\BankService\Pasargad;

use App\Services\BankService\BankServiceInterface;
use Illuminate\Support\Facades\Http;
use Exception;

class PasargadBankService implements BankServiceInterface
{

    /**
     * @param string|null $cardNumber
     * @param string|null $shabaNumber
     * @return string
     */
    public function getBalance(?string $cardNumber = null, ?string $shabaNumber = null)
    {
        try {
            $response = file_get_contents(base_path("app/Services/BankService/Pasargad/pasargad.json"));
            Http::fake(["pasargad.ir" => Http::response($response)]);
            $response = json_decode($response);
            return $response->amount;
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

            Http::fake(["pasargad.ir" => Http::response(["message" => "$amount added to $cardNumber"])]);
            return $amount;
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function withdraw(string $shabaNum, int $amount, string $to): string
    {
        try {
            Http::fake(["pasargad.ir" => Http::response(["message" => "$amount decreased from $shabaNum"])]);
            return -1 * $amount;
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }
}
