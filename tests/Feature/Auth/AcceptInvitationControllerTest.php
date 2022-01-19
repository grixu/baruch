<?php

namespace Tests\Feature\Auth;

use Domain\Auth\Models\Invitation;
use Illuminate\Support\Str;
use Tests\TestCase;

class AcceptInvitationControllerTest extends TestCase
{
    private Invitation $invitation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->invitation = Invitation::factory()
            ->forCongregation()
            ->forInvitedBy()
            ->create();
    }

    /** @test */
    public function it_shows_form_to_setting_a_password_for_invited_user()
    {
        $this->get(route('invitation.accept.create', ['invitation' => $this->invitation->uuid]))
            ->assertStatus(200);
    }

    /** @test */
    public function it_create_user_after_filling_the_form()
    {
        $password = Str::random(40);

        $this->post(route('invitation.accept.store'), [
            'invitation' => $this->invitation->uuid,
            'password' => $password,
            'password_confirmation' => $password
        ])
            ->assertStatus(302);

        $this->assertDatabaseHas('users', ['email' => $this->invitation->email]);
    }
}
