<?php

use Domain\Auth\Models\Invitation;
use Illuminate\Support\Str;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

beforeEach(function () {
    $this->invitation = Invitation::factory()
        ->forCongregation()
        ->forInvitedBy()
        ->create();
});

it("shows_form_to_setting_a_password_for_invited_user", function () {
    get(route('invitation.accept.create', ['invitation' => $this->invitation->uuid]))
        ->assertStatus(200);
});

it("create_user_after_filling_the_form", function () {
    $password = Str::random(40);

    post(route('invitation.accept.store'), [
        'invitation' => $this->invitation->uuid,
        'password' => $password,
        'password_confirmation' => $password
    ])
        ->assertStatus(302);

    assertDatabaseHas('users', ['email' => $this->invitation->email]);
});