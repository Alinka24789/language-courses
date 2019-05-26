<?php

namespace App\Http\Requests\Api\Unit;

use App\Http\Requests\Api\BaseApiRequest;

class UnitSearchRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'search'      => 'max:100'
        ];
    }
}
