<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\Users\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;


class Post extends Controller
{
    /**
     * @param RegistrationRequest $request
     * @return JsonResponse
     */
    public function index(RegistrationRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = UserService::registration(
            $data['name'],
            $data['email'],
            $data['password'],
            key_exists('external_user_id', $data) ? intval($data['external_user_id']) : null
        );

        return $this->ok(new UserResource($user));
    }
}
