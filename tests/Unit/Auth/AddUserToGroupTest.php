<?php

namespace Tests\Unit\Auth;

use Domain\Auth\Actions\AddUserToGroup;
use Domain\Auth\Models\Group;
use Domain\Auth\Models\User;
use Domain\Auth\Notifications\UserJoinedGroup;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AddUserToGroupTest extends TestCase
{
    private User $user;
    private Group $group;
    private AddUserToGroup $testObj;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->group = Group::factory()
            ->forCongregation()
            ->hasUsers()
            ->create();

        $this->testObj = app(AddUserToGroup::class);

        Notification::fake();
    }

    /** @test */
    public function it_adding_user_to_a_group()
    {
        $returnedUserObj = $this->testObj->execute($this->user, $this->group);

        $this->assertEquals(true,
            in_array($this->group->id, $returnedUserObj->groups->pluck('id')->toArray())
        );
    }

    /** @test */
    public function it_sending_notification_to_every_one_in_a_group()
    {
        $this->testObj->execute($this->user, $this->group);

        Notification::assertSentTo($this->group->users, UserJoinedGroup::class);
    }
}
