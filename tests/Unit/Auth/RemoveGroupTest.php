<?php

namespace Tests\Unit\Auth;

use Domain\Auth\Actions\RemoveGroup;
use Domain\Auth\Models\Group;
use Domain\Auth\Notifications\GroupWasDeleted;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RemoveGroupTest extends TestCase
{
    private Group $group;
    private RemoveGroup $testObj;

    protected function setUp(): void
    {
        parent::setUp();

        $this->group = Group::factory()
            ->forCongregation()
            ->hasUsers()
            ->create();

        $this->testObj = app(RemoveGroup::class);

        Notification::fake();
    }

    /** @test */
    public function it_removes_group()
    {
        $users = $this->group->users;
        $this->testObj->execute($this->group);

        $this->assertModelMissing($this->group);
        $users->each(fn($user) => $this->assertEmpty($user->groups->toArray()));
    }

    /** @test */
    public function it_sent_notification_to_each_member()
    {
        $this->testObj->execute($this->group);

        Notification::assertSentTo($this->group->users, GroupWasDeleted::class);
    }
}
