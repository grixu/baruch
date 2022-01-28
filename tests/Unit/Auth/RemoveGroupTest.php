<?php

use Domain\Auth\Actions\RemoveGroup;
use Domain\Auth\Models\Group;
use Domain\Auth\Notifications\GroupWasDeleted;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    $this->group = Group::factory()
        ->forCongregation()
        ->hasUsers()
        ->create();

    $this->testObj = app(RemoveGroup::class);

    Notification::fake();
});

it("removes_group", function () {
    $users = $this->group->users;
    $this->testObj->execute($this->group);

    $this->assertModelMissing($this->group);
    expect($users)->each(fn ($user) => $user->groups->toBeEmpty());
});

it("sent_notification_to_each_member", function () {
    $this->testObj->execute($this->group);

    Notification::assertSentTo($this->group->users, GroupWasDeleted::class);
});

