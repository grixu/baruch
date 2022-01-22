<?php

namespace Domain\Auth\Policies;

use Domain\Auth\Models\Invitation;
use Domain\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Invitation $invitation)
    {
        //
    }

    public function create(User $user): bool
    {
        return $user->hasAnyPermission('congregation_invite', 'group_invite');
    }

    public function update(User $user, Invitation $invitation)
    {
        //
    }

    public function delete(User $user, Invitation $invitation): bool
    {
        return $this->create($user, $invitation);
    }

    public function restore(User $user, Invitation $invitation)
    {
        //
    }

    public function forceDelete(User $user, Invitation $invitation)
    {
        //
    }
}

