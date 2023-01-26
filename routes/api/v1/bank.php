<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BankController;

Route::get("balance", [BankController::class, "getBalance"]);
Route::get("balance/{bank}", [BankController::class, "getBankBalance"]);
Route::post("pay", [BankController::class, "pay"]);
Route::post("withdraw", [BankController::class, "withdraw"]);
Route::post("transfer", [BankController::class, "transfer"]);
