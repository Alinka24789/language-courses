<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\Api\Unit\UnitSearchRequest;
use App\Http\Resources\UnitCollection;
use App\Models\Unit;
use Illuminate\Http\JsonResponse;

class UnitController extends BaseApiController
{
    /**
     * Get results for units by search
     *
     * @param UnitSearchRequest $request
     * @return JsonResponse
     */
    public function index(UnitSearchRequest $request)
    {
        $search = $request->get('search');

        /** @var Unit $courses */
        $units = Unit::where('name', 'like', '%' . $search . '%')->get();

        return $this->successResponse(
            new UnitCollection($units)
        );
    }
}
