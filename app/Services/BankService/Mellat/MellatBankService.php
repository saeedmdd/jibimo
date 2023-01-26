<?php

namespace App\Services\BankService\Mellat;

use App\Services\BankService\BankServiceInterface;
use Illuminate\Support\Facades\Http;
use Exception;

class MellatBankService implements BankServiceInterface
{

    /**
     * @param string|null $cardNumber
     * @return string
     */
    public function getBalance(?string $cardNumber = null): string
    {
        try {
            $response = file_get_contents(base_path("app/Services/BankService/Mellat/mellat.json"));
            Http::fake(["mellat.ir" => Http::response($response)]);
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

            Http::fake(["mellat.ir" => Http::response(["message" => "$amount added to $cardNumber"])]);
            return $amount;
        }
        catch (Exception $e){
            return $e->getMessage();
        }

    }

    public function withdraw(string $shabaNum, int $amount): string
    {
        try {
            Http::fake(["mellat.ir" => Http::response(["message" => "$amount decreased from $shabaNum"])]);
            return -1 * $amount;
        }catch (Exception $e){
            return $e->getMessage();
        }

    }
}
