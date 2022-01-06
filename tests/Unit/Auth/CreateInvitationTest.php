<?php

namespace Tests\Unit\Auth;

use Domain\Auth\Actions\CreateInvitation;
use Domain\Auth\Data\Invitation as InvitationData;
use Domain\Auth\Models\Congregation;
use Domain\Auth\Models\Group;
use Domain\Auth\Models\User;
use Domain\Auth\Notifications\InvitationWasSend;
use Domain\Auth\Notifications\YouWereInvited;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CreateInvitationTest extends TestCase
{
    use WithFaker;

    private InvitationData $data;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->data = new InvitationData(
            Congregation::factory()->create()->id,
            Group::factory()->forCongregation()->create()->id,
            $this->faker->name(),
            $this->faker->email(),
            $this->user->id,
        );

        Notification::fake();
    }

    /** @test */
    public function it_create_invitation_record()
    {
        $testObj = new CreateInvitation();

        $returnedInvitation = $testObj->execute($this->data);

        $this->assertDatabaseHas('invitations', ['id' => $returnedInvitation->id]);
    }

    /** @test */
    public function it_send_notification_to_invited_person()
    {
        $testObj = new CreateInvitation();

        $testObj->execute($this->data);

        Notification::assertSentOnDemand(YouWereInvited::class, function($notificationObj) {
            return $this->data->email === $notificationObj->invitation->email;
        });
    }

    /** @test */
    public function it_send_notification_to_invitation_issuer()
    {
        $testObj = new CreateInvitation();

        $testObj->execute($this->data);

        Notification::assertSentTo($this->user, InvitationWasSend::class);
    }
}
