<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Models\Invitation;
use Domain\Auth\Models\User;
use Domain\Auth\Notifications\InvitationWasAccepted;
use Domain\Auth\Notifications\UserJoinedGroup;
use Domain\Auth\Notifications\YouAcceptInvitation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class AcceptInvitation
{
    public function __construct(private AddUserToGroup $addUserToGroup)
    {
    }

    public function execute(Invitation $invitation, string $password): User
    {
        $invitation->load('congregation', 'group', 'group.users', 'invitedBy');

        $user = $this->createUser($invitation, $password);
        if ($invitation->group) {
            $this->addUserToGroup->execute($user, $invitation->group);
        }

        $this->sendNotifications($invitation, $user);

        return $user;
    }

    private function createUser(Invitation $invitation, string $password): User
    {
        $user = User::create([
            'name' => $invitation->name,
            'email' => $invitation->email,
            'password' => Hash::make($password),
            'congregation_id' => $invitation->congregation_id,
        ]);
        $user->email_verified_at = now();
        $user->save();

        return $user;
    }

    private function sendNotifications(Invitation $invitation, User $user)
    {
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
