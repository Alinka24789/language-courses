<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseApiRequest extends FormRequest
{
    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "success" => false,
            "message" => $this->message,
            "data"    => $validator->errors()
        ], ($this->isResourceNotFound($validator) ? 404 : 422)));
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @param Validator $validator
     * @return bool
     */
    protected function isResourceNotFound(Validator $validator): bool
    {
        foreach ($validator->failed() as $field) {
            foreach ($field as $key => $value) {
                if (strtolower($key) === 'exists') {
                    return true;
                }
            }
        }

        return false;
    }
}
