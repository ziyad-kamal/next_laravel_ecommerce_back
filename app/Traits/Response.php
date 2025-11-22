<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait Response
{
    public function returnError(string $message, int $statusCode): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $statusCode);
    }

    public function returnSuccess(string $message = '', string $key = '', $value = null, int $statusCode = 200): JsonResponse
    {
        $data = [
            'message' => $message,
            $key      => $value,
        ];

        if ($message === '') {
            unset($data['message']);
        }

        if ($key === '') {
            unset($data[$key]);
        }

        return response()->json($data, $statusCode);
    }
}
