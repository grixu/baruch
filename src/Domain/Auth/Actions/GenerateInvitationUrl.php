<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Models\Invitation;
use Illuminate\Support\Facades\URL;

class GenerateInvitationUrl
{
    public function execute(Invitation $invitation): string
    {
        return URL::signedRoute('invitation.accept.create', ['invitation'=>$invitation->uuid]);
    }
}
