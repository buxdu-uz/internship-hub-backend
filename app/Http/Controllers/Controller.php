<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $message
     * @param $result
     * @param $code
     * @return JsonResponse
     */
    public function successResponse($message, $result = [], $code = 200)
    {
        $response = [
            'status' => true,
            'message' => $message,
            'data'    => $result
        ];
        return response()->json($response, $code);
    }

    /**
     * Error response method.
     *
     * @param $message
     * @param array $result
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse($message, $result = [], $code = 400): JsonResponse
    {
        $response = [
            'status' => false,
            'message' => $message
        ];

        if (!empty($result)) {
            $response['data'] = $result;
        }

        return response()->json($response, $code);
    }
}
