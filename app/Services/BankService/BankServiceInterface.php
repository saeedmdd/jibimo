<?php
namespace App\Services\BankService;
interface BankServiceInterface
{
    public function getBalance(string|null $cardNumber = null);

    public function pay(string $cardNumber, int $amount): string;

    public function withdraw(string $shabaNum, int $amount): string;
}
