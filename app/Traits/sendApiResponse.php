<?php

namespace App\Traits;


use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

trait sendApiResponse {

    public function sendApiResponse($data = '', $message = 'success', $errorType = '', $extra = [], $code = null): JsonResponse
    {
        $response = [
            'message' => $message,
            'success' => $errorType === '' ? true : false,
            'error_type' => $errorType,
        ] + $extra;

        if($data instanceof LengthAwarePaginator) {
            $response += $data->toArray();
        } else {
            $response['data'] = $data;
        }
        $code = $code ?: 200;
        return response()->json($response, $code);
    }
}
