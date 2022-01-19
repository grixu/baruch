<?php

namespace Tests\Unit\Auth;

use Domain\Auth\Actions\AcceptInvitation;
use Domain\Auth\Models\Group;
use Domain\Auth\Models\Invitation;
use Domain\Auth\Models\User;
use Domain\Auth\Notifications\InvitationWasAccepted;
use Domain\Auth\Notifications\UserJoinedGroup;
use Domain\Auth\Notifications\YouAcceptInvitation;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AcceptInvitationTest extends TestCase
{
    private Invitation $invitation;
    private AcceptInvitation $testObj;

    protected function setUp(): void
    {
        parent::setUp();

        $this->invitation = Invitation::factory()
            ->forInvitedBy()
            ->forCongregation()
            ->for(
                Group::factory()->forCongregation()->hasUsers()
            )
            ->create();

        $this->testObj = app(AcceptInvitation::class);

        Notification::fake();
    }

    /** @test */
    public function it_creates_user()
    {
        $createdUser = $this->testObj->execute($this->invitation, 'password');

        $this->assertModelExists($createdUser);
        $this->assertNotEmpty($createdUser->email_verified_at);
    }

    /** @test */
    public function it_add_user_to_selected_group_and_congregation()
    {
        $createdUser = $this->testObj->execute($this->invitation, 'password');

        ray($this, $createdUser);
        $this->assertEquals($this->invitation->congregation_id, $createdUser->congregation_id);
        $this->assertEquals(
            true,
            in_array(
                $this->invitation->group->id,
                $createdUser->groups()->pluck('groups.id')->all()
            )
        );
    }

    /** @test */
    public function it_sent_notification_to_invited_user()
    {
        $this->testObj->execute($this->invitation, 'password');

        Notification::assertSentTo($this->invitation->invitedBy, InvitationWasAccepted::class);
    }

    /** @test */
    public function it_sent_notification_to_invitation_issuer()
    {
        $createdUser = $this->testObj->execute($this->invitation, 'password');

        Notification::assertSentTo($createdUser, YouAcceptInvitation::class);

    }

    /** @test */
    public function it_sent_notification_to_group()
    {
        $this->testObj->execute($this->invitation, 'password');

        Notification::assertSentTo($this->invitation->group->users->all(), UserJoinedGroup::class);
    }
}
