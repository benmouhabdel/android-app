<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;

class Helper
{
    /**
     * Send error response.
     *
     * @param string $message
     * @param array $data
     * @return JsonResponse
     */
    public static function sendError(string $message, array $data = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], 422);
    }
}
