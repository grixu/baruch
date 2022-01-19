<?php

namespace App\Auth\Controllers;

use App\Auth\Requests\InvitationFormRequest;
use App\BaseController;
use Domain\Auth\Actions\AcceptInvitation;
use Domain\Auth\Models\Invitation;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AcceptInvitationController extends BaseController
{
    public function create(Invitation $invitation): \Inertia\Response
    {
        return Inertia::render('Auth/AcceptInvitation', [
            'name' => $invitation->name,
            'congregation' => $invitation->congregation->name
        ]);
    }

    public function store(InvitationFormRequest $request, AcceptInvitation $acceptInvitation): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        ['invitation' => $invitation, 'password' => $password] = $request->validated();
        $invitation = Invitation::findByUuid($invitation);
        $createdUser = $acceptInvitation->execute($invitation, $password);

        Auth::attempt([
            'email' => $invitation->email,
            'password' => $password
        ]);

        return redirect('dashboard');
    }
}
