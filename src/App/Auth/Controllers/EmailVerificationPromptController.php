<?php

namespace App\Auth\Controllers;

use App\BaseController;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmailVerificationPromptController extends BaseController
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::HOME)
                    : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}
