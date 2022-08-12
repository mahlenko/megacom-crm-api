<?php

namespace App\Http\Controllers\Api\V1\Users\Token;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\TokenCollection;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Index extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tokens = UserService::tokens(Auth::id());
        return $this->ok(new TokenCollection($tokens->paginate($this->per_page)));
    }
}
