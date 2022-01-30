<?php

use Domain\Auth\Actions\CreateGroup;
use Domain\Auth\Data\GroupData;
use Domain\Auth\Enums\GroupTypeEnum;
use Domain\Auth\Models\User;
use Domain\Auth\Notifications\GroupWasCreated;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use function Pest\Laravel\assertModelExists;

uses(WithFaker::class);

beforeEach(function () {
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
});

it("creates_a_group", function () {
    $returnedGroupObj = $this->testObj->execute($this->groupData, $this->user->congregation_id);

    assertModelExists($returnedGroupObj);
});

it("notify_all_members", function () {
    $returnedGroupObj = $this->testObj->execute($this->groupData, $this->user->congregation_id);

    Notification::assertSentTo($returnedGroupObj->users, GroupWasCreated::class);
});
