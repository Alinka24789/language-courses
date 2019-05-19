<?php

namespace App\Http\Requests\Api\Course;

use App\Http\Requests\Api\BaseApiRequest;
use App\Models\Course;

class CourseListRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'total'      => 'int|max:10',
            'page'       => 'int',
            'languageId' => 'int',
            'level'      => 'int',
            'text'       => 'string',
            'orderBy'    => 'in:' . implode(',', Course::AVAILABLE_SORT_BY),
            'orderType'  => 'in:desc,asc'
        ];
    }
}
