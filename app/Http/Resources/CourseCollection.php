<?php

namespace App\Http\Resources;

use App\Models\Course;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'items'      => $this->collection->map(function ($item) {
                /** @var Course $item */
                return [
                    'name'     => $item->name . ' (' . $item->year . ')',
                    'language' => $item->language->name,
                    'level'    => $item->level,
                    'units'    => $item->units->count()
                ];
            }),
            'pagination' => [
                'page'        => $this->currentPage(),
                'rowsPerPage' => (int) $this->perPage(),
                'totalPages'  => $this->lastPage(),
                'totalItems'  => $this->total(),
                'links'       => [
                    'nextUrl' => $this->nextPageUrl(),
                    'prevUrl' => $this->previousPageUrl()
                ],
            ],
        ];
    }
}
