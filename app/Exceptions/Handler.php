<?php

namespace App\Exceptions;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return ApiController::error(message: $e->getMessage(), code: Response::HTTP_NOT_FOUND);
            }
        });
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is("api/*"))
                return ApiController::error(message: $e->getMessage(), code: Response::HTTP_UNAUTHORIZED);
        });
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return ApiController::error(message: $e->getMessage(), code: Response::HTTP_FORBIDDEN);
            }
        });

        $this->renderable(function (ServiceUnavailableHttpException $e, $request) {
            if ($request->is('api/*')) {
                return ApiController::error(message: $e->getMessage(), code: Response::HTTP_SERVICE_UNAVAILABLE);
            }
        });
        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/*')) {
                return ApiController::error(code: Response::HTTP_NOT_ACCEPTABLE, error: $e->errors());
            }
        });
    }
}
