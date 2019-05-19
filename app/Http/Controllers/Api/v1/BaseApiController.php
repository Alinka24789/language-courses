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
     * @param array|null $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse($data = null, string $message = null, int $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => ($message ? Lang::get($message) : Lang::get('api.general.success'))
        ];

        if ($data) {
            if ($data instanceof AbstractPaginator) {
                $response['data'] = $this->paginatorResponse($data);
            } elseif ($data instanceof Model) {
                $response['data'] = $data->toArray();
            } else {
                $response['data'] = $data;
            }
        }

        return response()->json($response, $code);
    }

    /**
     * @param AbstractPaginator $paginator
     * @return array
     */
    private function paginatorResponse(AbstractPaginator $paginator): array
    {
        $result = [
            'page'             => $paginator->currentPage(),
            'totalPages'       => $paginator->lastPage(),
            'totalObjects'     => $paginator->total(),
            'currentPageNumber' => $paginator->currentPage(),
            'links'            => [
                'nextUrl' => $paginator->nextPageUrl(),
                'prevUrl' => $paginator->previousPageUrl()
            ],
            'items'            => $paginator->all()
        ];

        return $result;
    }
}