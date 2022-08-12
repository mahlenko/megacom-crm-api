<?php

namespace App\Http\Controllers\Api\V1\Ping;

use App\Http\Controllers\Controller;
use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class External extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            DB::connection('app_mysql')->getPdo();
            return $this->ok([], "Connected successfully to: " . DB::connection('app_mysql')->getDatabaseName());
        } catch (\Exception $e) {
            throw new DomainException("Could not connect to the database. Please check your configuration. error: " . $e->getMessage());
        }
    }
}
