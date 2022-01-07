<?php

namespace Tests\Unit\Auth;

use Domain\Auth\Actions\RemoveUserFromGroup;
use Domain\Auth\Models\Group;
use Domain\Auth\Models\User;
use Domain\Auth\Notifications\UserLeaveGroup;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RemoveUserFromGroupTest extends TestCase
{
    private User $user;
    private Group $group;
    private RemoveUserFromGroup $testObj;

    protected function setUp(): void
    {
        parent::setUp();

        $this->group = Group::factory()
            ->forCongregation()
            ->hasUsers()
            ->create();
        $this->user = User::factory()->create();
        $this->testObj = app(RemoveUserFromGroup::class);

        $this->user->groups()->attach($this->group);
        Notification::fake();
    }

    /** @test */
    public function it_removes_user_from_a_group()
    {
        $this->assertNotEmpty($this->user->groups->toArray());

        $returnedUserObj = $this->testObj->execute($this->user, $this->group);
        $returnedUserObj->refresh();

        $this->assertEmpty($returnedUserObj->groups->toArray());
    }

    /** @test */
    public function it_notify_all_members_about_it()
    {
        $this->testObj->execute($this->user, $this->group);

        Notification::assertSentTo($this->group->users, UserLeaveGroup::class);
    }
}
