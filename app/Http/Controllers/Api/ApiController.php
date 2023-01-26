<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    const API_VERSION = '1.0.0';

    /**
     * Main structure of json response
     * @param string|null $message
     * @param null $data
     * @param string $status
     * @param null $error
     * @return array
     */
    private static function setApiStructure(string|null $message = null, mixed $data = null, string $status = "ok", mixed $error = null): array
    {
        return [
            "status" => $status,
            "data" => $data,
            "message" => $message,
            "version" => self::API_VERSION,
            "error" => $error,
        ];
    }

    /**
     * @param string|null $message
     * @param mixed $data
     * @param int $code
     * @return JsonResponse
     */
    public static function success(string|null $message = null, mixed $data = null, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json(self::setApiStructure($message, $data), $code);
    }


    /**
     * @param string|null $message
     * @param mixed $data
     * @param int $code
     * @param mixed $error
     * @return JsonResponse
     */
    public static function error(
        string|null $message = null,
        mixed       $data = null,
        int         $code = Response::HTTP_BAD_REQUEST,
        mixed       $error = null
    ): JsonResponse
    {
        return response()->json(self::setApiStructure($message, $data, "error", $error), $code);
    }
}
