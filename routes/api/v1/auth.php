<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;

Route::post("login", [UserController::class, "login"]);
Route::post("register",[UserController::class, "register"]);
