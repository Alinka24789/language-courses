<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\Api\Course\CourseListRequest;
use App\Http\Resources\CourseCollection;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder;

class CourseController extends BaseApiController
{
    /**
     * Get courses list
     *
     * @param CourseListRequest $request
     * @return JsonResponse
     */
    public function index(CourseListRequest $request)
    {
        $total = $request->get('total') ?? self::DEFAULT_TOTAL_PER_PAGE;
        $page = $request->get('total') ?? self::DEFAULT_FIRST_PAGE;
        $languageId = $request->get('languageId');
        $level = $request->get('level');
        $text = $request->get('text');
        $orderBy = $request->get('orderBy');
        $orderType = $request->get('orderType') ?? 'asc';

        /** @var Course $courses */
        $coursesQuery = Course::query();
        if ($languageId) {
            $coursesQuery->ofLanguage($languageId);
        }
        if ($level) {
            $coursesQuery->ofLevel($level);
        }
        if ($text) {
            $coursesQuery->ofText($text);
        }
        if ($orderBy) {
            $coursesQuery->orderByColumn($orderBy, $orderType);
        }
        $coursesQuery->offset($page);
        $courses = $coursesQuery->paginate($total);

        return $this->successResponse(
            new CourseCollection($courses)
        );
    }

    public function getLevels()
    {
        return $this->successResponse(
            Course::groupBy('level')->get('level')
        );
    }
}
