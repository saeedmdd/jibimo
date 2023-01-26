<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BankController;

Route::get("balance", [BankController::class, "getBalance"]);
Route::get("balance/{bank}", [BankController::class, "getBankBalance"]);
