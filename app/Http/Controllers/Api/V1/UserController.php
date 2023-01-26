<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\User\LoginRequest;
use App\Http\Requests\Api\V1\User\RegisterRequest;
use App\Repositories\User\UserRepository;
use Symfony\Component\HttpFoundation\Response;

class UserController extends ApiController
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function login(LoginRequest $request)
    {
        $user = $this->userRepository->login($request);
        if (!$user)
            return self::error(code: Response::HTTP_NOT_ACCEPTABLE, error: "credentials do not match!");
        $user->token = $this->userRepository->createToken($user);
        return self::success(message: "logged in successfully", data: $user, code: Response::HTTP_ACCEPTED);
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->userRepository->create($request->validated());
        $user->token = $this->userRepository->createToken($user);
        return self::success("register successful", $user, Response::HTTP_CREATED);
    }
}
