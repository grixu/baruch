<?php

namespace Domain\Auth\Policies;

use Domain\Auth\Models\Congregation;
use Domain\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CongregationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Congregation $congregation)
    {
        //
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('congregation_create');
    }

    public function update(User $user, Congregation $congregation)
    {
        //
    }

    public function delete(User $user, Congregation $congregation): bool
    {
        return $user->hasPermissionTo('congregation_delete');
    }

    public function restore(User $user, Congregation $congregation)
    {
        //
    }

    public function forceDelete(User $user, Congregation $congregation)
    {
        //
    }
}

