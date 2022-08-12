<?php

namespace App\Http\Controllers\Api\V1\Users\Token;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\TokenCollection;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class Get extends Controller
{
    /**
     * @param int $user_id
     * @return JsonResponse
     */
    public function index(int $user_id): JsonResponse
    {
        $tokens = UserService::tokens($user_id);

        return $this->ok(new TokenCollection($tokens->paginate($this->per_page)));
    }
}
