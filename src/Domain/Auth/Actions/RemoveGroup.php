<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Models\Group;
use Domain\Auth\Notifications\GroupWasDeleted;
use Illuminate\Support\Facades\Notification;

class RemoveGroup
{
    public function execute(Group $group)
    {
        $group->delete();

        Notification::send($group->users, new GroupWasDeleted($group));
    }
}
