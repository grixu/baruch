<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;

it("registration_screen_can_be_rendered", function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

it("new_users_can_register", function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});
