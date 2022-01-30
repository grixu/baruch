<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it("registration_screen_can_be_rendered", function () {
    get('/register')
        ->assertStatus(200);
});

it("new_users_can_register", function () {
    $response = post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});
