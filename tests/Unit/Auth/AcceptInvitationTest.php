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
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->invitation = Invitation::factory()
            ->forInvitedBy()
            ->forCongregation()
            ->for(
                Group::factory()->forCongregation()
            )
            ->create();

        $this->user = User::factory()->create();

        Notification::fake();
    }

    /** @test */
    public function it_add_user_to_selected_group_and_congregation()
    {
        $testObj = new AcceptInvitation();

        $testObj->execute($this->invitation, $this->user);
        $this->user->refresh();

        $this->assertEquals($this->invitation->congregation_id, $this->user->congregation_id);
        $this->assertEquals(
            true,
            in_array(
                $this->invitation->group->id,
                $this->user->groups()->pluck('groups.id')->all()
            )
        );
    }

    /** @test */
    public function it_sent_notification_to_invited_user()
    {
        $testObj = new AcceptInvitation();

        $testObj->execute($this->invitation, $this->user);

        Notification::assertSentTo($this->invitation->invitedBy, InvitationWasAccepted::class);
    }

    /** @test */
    public function it_sent_notification_to_invitation_issuer()
    {
        $testObj = new AcceptInvitation();

        $testObj->execute($this->invitation, $this->user);

        Notification::assertSentTo($this->user, YouAcceptInvitation::class);

    }

    /** @test */
    public function it_sent_notification_to_group()
    {
        $testObj = new AcceptInvitation();

        $testObj->execute($this->invitation, $this->user);

        Notification::assertSentTo($this->invitation->group->users->all(), UserJoinedGroup::class);
    }
}
