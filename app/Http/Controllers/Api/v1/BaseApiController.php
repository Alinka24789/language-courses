<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Http\JsonResponse;
use Lang;

/**
 * Class BaseApiController
 * @package App\Http\Controllers\Api\v1
 */
class BaseApiController extends Controller
{
    const DEFAULT_TOTAL_PER_PAGE = 10;
    const DEFAULT_FIRST_PAGE = 1;
    /**
     * Wrapper to the responses with errors
     *
     * @param string $message
     * @param array|null $data
     * @param int $code
     * @return JsonResponse
     */
    protected function failResponse(string $message, array $data = null, int $code = 400): JsonResponse
    {
        $response = [
            "success" => false,
            "message" => Lang::get($message)
        ];

        if ($data) {
            $response["fails"] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * Wrapper to the responses with success
     *
     * @param array $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse($data = [], string $message = null, int $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => ($message ? Lang::get($message) : Lang::get('api.general.success'))
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
}