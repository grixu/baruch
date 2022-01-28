<?php

use Domain\Auth\Actions\RemoveUserFromGroup;
use Domain\Auth\Models\Group;
use Domain\Auth\Models\User;
use Domain\Auth\Notifications\UserLeaveGroup;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    $this->group = Group::factory()
        ->forCongregation()
        ->hasUsers()
        ->create();
    $this->user = User::factory()->create();
    $this->testObj = app(RemoveUserFromGroup::class);

    $this->user->groups()->attach($this->group);
    Notification::fake();
});

it("removes_user_from_a_group", function () {
    $this->assertNotEmpty($this->user->groups->toArray());

    $returnedUserObj = $this->testObj->execute($this->user, $this->group);
    $returnedUserObj->refresh();

    expect($returnedUserObj->groups->toArray())->toBeEmpty();
});

it("notify_all_members_about_it", function () {
    $this->testObj->execute($this->user, $this->group);

    Notification::assertSentTo($this->group->users, UserLeaveGroup::class);
});
