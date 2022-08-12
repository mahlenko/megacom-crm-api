<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class Delete extends Controller
{
    /**
     * @param int $user_id
     * @return JsonResponse
     */
    public function index(int $user_id): JsonResponse
    {
        return $this->ok([
            'delete' => UserService::delete($user_id)
        ]);
    }
}
