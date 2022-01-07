<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Models\Group;
use Domain\Auth\Models\User;
use Domain\Auth\Notifications\UserLeaveGroup;
use Illuminate\Support\Facades\Notification;

class RemoveUserFromGroup
{
    public function execute(User $user, Group $group, bool $quietly = false): User
    {
        $user->groups()->detach([$group->id]);

        if (!$quietly) {
            Notification::send($group->users, new UserLeaveGroup($user, $group));
        }

        return $user;
    }
}
