<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Data\InvitationData as InvitationData;
use Domain\Auth\Models\Invitation;
use Domain\Auth\Models\User;
use Domain\Auth\Notifications\InvitationWasSend;
use Domain\Auth\Notifications\YouWereInvited;
use Illuminate\Support\Facades\Notification;

class CreateInvitation
{
    public function execute(InvitationData $data, User $invitedBy): Invitation
    {
        $invitation = Invitation::create([
            'name' => $data->name,
            'email' => $data->email,
            'congregation_id' => $data->congregationId,
            'group_id' => $data->groupId,
            'invited_by' => $invitedBy->id,
        ]);

        Notification::route('email', [$invitation->email])
            ->notify(new YouWereInvited($invitation, $invitedBy));

        Notification::send(
            [$invitation->invitedBy],
            new InvitationWasSend($invitation)
        );

        return $invitation;
    }
}
