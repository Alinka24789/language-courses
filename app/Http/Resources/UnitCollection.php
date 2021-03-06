<?php

namespace App\Http\Resources;

use App\Models\Unit;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UnitCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            /** @var Unit $item */
            return [
                'course'   => $item->course->name,
                'name' => $item->name
            ];
        })->toArray();
    }
}
