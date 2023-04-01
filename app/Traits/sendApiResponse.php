<?php

namespace App\Traits;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\PaginationState;
use Illuminate\Support\Collection;

trait sendApiResponse {

    public function sendApiResponse($data = '', $message = 'success', $errorType = '', $extra = [], $code = null): JsonResponse
    {
        $response = [
            'message' => $message,
            'success' => $errorType === '',
            'error_type' => $errorType,
        ] + $extra;
        
        dd($data);

        if($data instanceof LengthAwarePaginator) {
            $response += $data->toArray();
        } elseif ($data->has('resource') && $data->resource instanceof LengthAwarePaginator || $data instanceof ResourceCollection) {
            $response += $data->resource->toArray();
        } else {
            $response['data'] = $data;
        }
        $code = $code ?: 200;
        return response()->json($response, $code);
    }
}
