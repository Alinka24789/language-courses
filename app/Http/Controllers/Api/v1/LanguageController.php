<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Lang;

class LanguageController extends BaseApiController
{
    /**
     * Get language list
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->successResponse(
            Language::orderBy('name')->get()
        );
    }
}
