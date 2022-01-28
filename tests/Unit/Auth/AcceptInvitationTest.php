<?php

use Domain\Auth\Actions\AcceptInvitation;
use Domain\Auth\Models\Group;
use Domain\Auth\Models\Invitation;
use Domain\Auth\Notifications\InvitationWasAccepted;
use Domain\Auth\Notifications\UserJoinedGroup;
use Domain\Auth\Notifications\YouAcceptInvitation;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    $this->invitation = Invitation::factory()
        ->forInvitedBy()
        ->forCongregation()
        ->for(
            Group::factory()->forCongregation()->hasUsers()
        )
        ->create();

    $this->testObj = app(AcceptInvitation::class);

    Notification::fake();
});

it("creates_user", function () {
    $createdUser = $this->testObj->execute($this->invitation, 'password');

    $this->assertModelExists($createdUser);
    expect($createdUser->email_verified_at)->not()->toBeEmpty();
});

it("add_user_to_selected_group_and_congregation", function () {
    $createdUser = $this->testObj->execute($this->invitation, 'password');

    expect($this->invitation->congregation_id)->toEqual($createdUser->congregation_id);
    expect($this->invitation->group->id)->toBeIn($createdUser->groups()->pluck('groups.id')->all());
});

it("sent_notification_to_invited_user", function () {
    $this->testObj->execute($this->invitation, 'password');

    Notification::assertSentTo($this->invitation->invitedBy, InvitationWasAccepted::class);
});

it("sent_notification_to_invitation_issuer", function () {
    $createdUser = $this->testObj->execute($this->invitation, 'password');

    Notification::assertSentTo($createdUser, YouAcceptInvitation::class);
});

it("sent_notification_to_group", function () {
    $this->testObj->execute($this->invitation, 'password');

    Notification::assertSentTo($this->invitation->group->users->all(), UserJoinedGroup::class);
});

