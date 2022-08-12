<?php

namespace App\Services;

use App\Models\Tasks\Task;
use Illuminate\Support\Facades\Auth;

class TaskService implements ServiceInterface
{
    /**
     * @param int $group_id
     * @param string $title
     * @param string $description
     * @param string $date_begin
     * @param string $date_end
     * @param bool $require_report
     * @return Task
     */
    public static function create(
        int $group_id,
        string $title,
        string $description,
        string $date_begin,
        string $date_end,
        bool $require_report = false
    ): Task
    {
        $task = new Task([
            'user_id' => Auth::user()->external_user_id,
            'users_groups' => $group_id,
            'date_start' => $date_begin,
            'date_end' => $date_end,
            'task_name' => $title,
            'note' => $description,
            'require_report' => $require_report ? 'Y' : 'N',
            'system_status' => 'active',
            'date_created' => date('Y-m-d H:i:s'),
        ]);

        $task->save();

        return $task;
    }

}
