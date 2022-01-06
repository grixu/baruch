<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Data\Invitation as InvitationData;
use Domain\Auth\Models\Invitation;
use Domain\Auth\Notifications\InvitationWasSend;
use Domain\Auth\Notifications\YouWereInvited;
use Illuminate\Support\Facades\Notification;

class CreateInvitation
{
    public function execute(InvitationData $data): Invitation
    {
        $invitation = Invitation::create([
            'name' => $data->name,
            'email' => $data->email,
            'congregation_id' => $data->congregationId,
            'group_id' => $data->groupId,
            'invited_by' => $data->invitedBy,
        ]);

        Notification::route('email', [$invitation->email])
            ->notify(new YouWereInvited($invitation));

        Notification::send(
            [$invitation->invitedBy],
            new InvitationWasSend($invitation)
        );

        return $invitation;
    }
}
