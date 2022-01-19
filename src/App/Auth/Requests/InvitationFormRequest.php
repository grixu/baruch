<?php

namespace App\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class InvitationFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'invitation' => 'required|uuid|exists:invitations,uuid',
            'password' => ['required', 'confirmed', Password::min(8)->uncompromised()],
            'password_confirmation' => 'required'
        ];
    }
}
