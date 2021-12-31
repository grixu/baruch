<?php

namespace Domain\Auth\Factories;

use Domain\Auth\Enums\GroupTypeEnum;
use Domain\Auth\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'type' => $this->faker->randomElement([GroupTypeEnum::SERVICE]),
        ];
    }
}
