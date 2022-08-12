<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class Get extends Controller
{
    public function index(int $user_id): \Illuminate\Http\JsonResponse
    {
        return $this->ok(new UserResource(User::findOrFail($user_id)));
    }
}
