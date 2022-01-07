<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Models\Group;
use Domain\Auth\Models\User;
use Domain\Auth\Notifications\UserJoinedGroup;
use Illuminate\Support\Facades\Notification;

class AddUserToGroup
{
    public function execute(User $user, Group $group): User
    {
        $user->groups()->syncWithoutDetaching([$group->id]);

        Notification::send(
            $group->users->all(),
            new UserJoinedGroup($user, $group)
        );

        return $user;
    }
}
