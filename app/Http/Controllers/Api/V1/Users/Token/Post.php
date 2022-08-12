<?php

namespace App\Http\Controllers\Api\V1\Users\Token;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizationRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class Post extends Controller
{
    /**
     * @param AuthorizationRequest $request
     * @return JsonResponse
     */
    public function index(AuthorizationRequest $request): JsonResponse
    {
        $data = $request->validated();

        return $this->ok([
            'token' => UserService::createToken(
                $data['email'],
                $data['password'],
                $data['token_name'] ?? null
            )
        ]);
    }
}
