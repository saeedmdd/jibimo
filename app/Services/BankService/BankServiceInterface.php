<?php

namespace App\Services\BankService;
interface BankServiceInterface
{
    public function getBalance(string|null $cardNumber = null, string|null $shabaNumber = null);

    public function pay(string $cardNumber, int $amount): string;

    public function withdraw(string $shabaNum, int $amount, string $to): string;
}
