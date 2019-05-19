<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Course;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Lang;

class CourseController extends BaseApiController
{
    public function index()
    {
        return [];
    }

    public function getLevels()
    {
        return $this->successResponse(
            Course::groupBy('level')->get('level')
        );
    }
}
