<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Data\GroupData;
use Domain\Auth\Models\Group;
use Domain\Auth\Notifications\GroupWasCreated;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CreateGroup
{
    public function execute(GroupData $data, int $congregationId): Group
    {
        $group = Group::create([
            'name' => $data->name,
            'type' => $data->type,
            'congregation_id' => $congregationId
        ]);

        $group->users()->syncWithoutDetaching(Arr::flatten($data->users->toArray()));

        Notification::send($group->users, new GroupWasCreated($group));

        return $group;
    }
}
