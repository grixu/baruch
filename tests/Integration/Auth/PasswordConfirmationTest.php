<?php

use Domain\Auth\Models\User;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    /** @var User user */
    $this->user = User::factory()->create();
});

it("confirm_password_screen_can_be_rendered", function () {
    actingAs($this->user)
        ->get('/confirm-password')
        ->assertStatus(200);
});

it("password_can_be_confirmed", function () {
    actingAs($this->user)
        ->post('/confirm-password', [
            'password' => 'password',
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();
});

it("password_is_not_confirmed_with_invalid_password", function () {
    actingAs($this->user)
        ->post('/confirm-password', [
            'password' => 'wrong-password',
        ])
        ->assertSessionHasErrors();
});

