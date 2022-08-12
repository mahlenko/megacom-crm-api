<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserCollection;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class Index extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->ok(
            new UserCollection(
                User::paginate($this->per_page)
            )
        );
    }
}
