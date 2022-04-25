<?php

use Domain\Auth\Actions\AddUserToGroup;
use Domain\Auth\Models\Group;
use Domain\Auth\Models\User;
use Domain\Auth\Notifications\UserJoinedGroup;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {

    $this->user = User::factory()->create();
    $this->group = Group::factory()
        ->forCongregation()
        ->hasUsers()
        ->create();

    $this->testObj = app(AddUserToGroup::class);

    Notification::fake();
});

it("adding_user_to_a_group", function () {
    $returnedUserObj = $this->testObj->execute($this->user, $this->group);

    expect($this->group->id)->toBeIn($returnedUserObj->groups->pluck('id')->toArray());
});

it("sending_notification_to_every_one_in_a_group", function () {
    $this->testObj->execute($this->user, $this->group);

    Notification::assertSentTo($this->group->users, UserJoinedGroup::class);
});

