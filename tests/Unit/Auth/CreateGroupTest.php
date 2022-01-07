<?php

namespace Tests\Unit\Auth;

use Domain\Auth\Actions\CreateGroup;
use Domain\Auth\Data\GroupData;
use Domain\Auth\Enums\GroupTypeEnum;
use Domain\Auth\Models\User;
use Domain\Auth\Notifications\GroupWasCreated;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CreateGroupTest extends TestCase
{
    use WithFaker;

    private GroupData $groupData;
    private User $user;
    private CreateGroup $testObj;

    protected function setUp(): void
    {
        parent::setUp();

        $this->groupData = GroupData::from([
            "name" => $this->faker->name(),
            "type" => GroupTypeEnum::SERVICE,
            "users" => [['id' => User::factory()->create()->id]]
        ]);

        $this->testObj = app(CreateGroup::class);

        $this->user = User::factory()
            ->forCongregation()
            ->create();

        Notification::fake();
    }

    /** @test */
    public function it_creates_a_group()
    {
        $returnedGroupObj = $this->testObj->execute($this->groupData, $this->user->congregation_id);

        $this->assertModelExists($returnedGroupObj);
    }

    /** @test */
    public function it_notify_all_members()
    {
        $returnedGroupObj = $this->testObj->execute($this->groupData, $this->user->congregation_id);

        Notification::assertSentTo($returnedGroupObj->users, GroupWasCreated::class);
    }
}
