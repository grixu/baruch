<?php

use Domain\Auth\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it("reset_password_link_screen_can_be_rendered", function () {
     get('/forgot-password')
        ->assertStatus(200);
});

it("reset_password_link_can_be_requested", function () {
    Notification::fake();

    $user = User::factory()->create();

    post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class);
});

it("reset_password_screen_can_be_rendered", function () {
    Notification::fake();

    $user = User::factory()->create();

    post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        get('/reset-password/' . $notification->token)
            ->assertStatus(200);

        return true;
    });
});

it("password_can_be_reset_with_valid_token", function () {
    Notification::fake();

    $user = User::factory()->create();

    post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $response = post('/reset-password', [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasNoErrors();

        return true;
    });
});
