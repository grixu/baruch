<?php

use App\Providers\RouteServiceProvider;
use Domain\Auth\Models\User;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it("login_screen_can_be_rendered", function () {
    get('/login')
        ->assertStatus(200);
});

it("users_can_authenticate_using_the_login_screen", function () {
    $user = User::factory()->create();

    $response = post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

it("users_can_not_authenticate_with_invalid_password", function () {
    $user = User::factory()->create();

    post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    assertGuest();
});

