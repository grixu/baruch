<?php

use Domain\Auth\Actions\CreateInvitation;
use Domain\Auth\Data\InvitationData;
use Domain\Auth\Models\Congregation;
use Domain\Auth\Models\Group;
use Domain\Auth\Models\User;
use Domain\Auth\Notifications\InvitationWasSend;
use Domain\Auth\Notifications\YouWereInvited;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;

uses(WithFaker::class);

beforeEach(function () {

    $this->user = User::factory()->create();

    $this->data = new InvitationData(
        Congregation::factory()->create()->id,
        Group::factory()->forCongregation()->create()->id,
        $this->faker->name(),
        $this->faker->email(),
    );

    Notification::fake();
});

it("create_invitation_record", function () {
    $testObj = new CreateInvitation();

    $returnedInvitation = $testObj->execute($this->data, $this->user);

    $this->assertDatabaseHas('invitations', ['id' => $returnedInvitation->id]);
});

it("send_notification_to_invited_person", function () {
    $testObj = new CreateInvitation();

    $testObj->execute($this->data, $this->user);

    Notification::assertSentOnDemand(YouWereInvited::class, function ($notificationObj) {
        return $this->data->email === $notificationObj->invitation->email;
    });
});

it("send_notification_to_invitation_issuer", function () {
    $testObj = new CreateInvitation();

    $testObj->execute($this->data, $this->user);

    Notification::assertSentTo($this->user, InvitationWasSend::class);
});
