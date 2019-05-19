<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;

class UserRequest extends BaseApiRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required'
        ];
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
