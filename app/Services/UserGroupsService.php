<?php

namespace App\Services;

use App\Models\Users\Group;

class UserGroupsService implements ServiceInterface
{

    /**
     * @param array|int $users_id
     * @return int
     */
    public static function create($users_id): int
    {
        if (!is_array($users_id)) {
            $users_id = [$users_id];
        }

        $current_group_id = Group::max('group_id');
        $group_id = $current_group_id + 1;

        foreach ($users_id as $id) {
            $user_group = new Group([
                'group_id' => $group_id,
                'user_id' => $id
            ]);

            $user_group->save();
        }

        return $group_id;
    }

}
