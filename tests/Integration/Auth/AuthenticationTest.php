<?php

use App\Providers\RouteServiceProvider;
use Domain\Auth\Models\User;

it("login_screen_can_be_rendered", function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

it("users_can_authenticate_using_the_login_screen", function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

it("users_can_not_authenticate_with_invalid_password", function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

