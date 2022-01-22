<?php

namespace Domain\Auth\Policies;

use Domain\Auth\Models\Group;
use Domain\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Group $group)
    {
        //
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('group_create');
    }

    public function update(User $user, Group $group)
    {
        //
    }

    public function delete(User $user, Group $group): bool
    {
        return $user->hasPermissionTo('group_delete');
    }

    public function restore(User $user, Group $group)
    {
        //
    }

    public function forceDelete(User $user, Group $group)
    {
        //
    }
}
