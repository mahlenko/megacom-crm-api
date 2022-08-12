<?php

namespace App\Http\Controllers\Api\V1\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\TaskCreateRequest;
use App\Http\Resources\Tasks\TaskResource;
use App\Services\TaskService;
use App\Services\UserGroupsService;
use Illuminate\Http\JsonResponse;

class Create extends Controller
{
    /**
     * @param TaskCreateRequest $request
     * @return JsonResponse
     */
    public function index(TaskCreateRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!key_exists('group_id', $data)) {
            $group_id = UserGroupsService::create($data['users_id']);
        } else {
            $group_id = $data['group_id'];
        }

        //
        $task = TaskService::create(
            $group_id,
            $data['title'],
            $data['description'],
            $data['date_begin'],
            $data['date_end'],
            key_exists('require_report', $data) && $data['require_report']
        );

        return $this->ok(new TaskResource($task));
    }
}
