<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Models\Invitation;
use Domain\Auth\Models\User;
use Domain\Auth\Notifications\InvitationWasAccepted;
use Domain\Auth\Notifications\UserJoinedGroup;
use Domain\Auth\Notifications\YouAcceptInvitation;
use Illuminate\Support\Facades\Notification;

class AcceptInvitation
{
    public function __construct(private AddUserToGroup $addUserToGroup)
    {
    }

    public function execute(Invitation $invitation, User $user)
    {
        $invitation->load('congregation', 'group', 'group.users', 'invitedBy');
        $user->congregation()->associate($invitation->congregation);
        $this->addUserToGroup->execute($user, $invitation->group);
        $user->push();

        Notification::send(
            [$invitation->invitedBy],
            new InvitationWasAccepted()
        );

        Notification::send(
            [$user],
            new YouAcceptInvitation($invitation)
        );

        if ($invitation->group) {

            Notification::send(
                $invitation->group->users->all(),
                new UserJoinedGroup($user, $invitation->group)
            );
        }
    }
}
