<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\Api\UserRequest;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class UserController extends BaseApiController
{
    /**
     * Get token for authorization
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function authenticate(UserRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->failResponse('api.auth.invalid_credentials', null, 400);
            }
        } catch (JWTException $e) {
            return $this->failResponse('api.auth.could_not_create_token', null, 500);
        }
        return $this->successResponse(
            compact('token')
        );
    }
}
