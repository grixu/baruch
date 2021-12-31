<?php

namespace Domain\Auth\Factories;

use Domain\Auth\Models\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvitationFactory extends Factory
{
    protected $model = Invitation::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
        ];
    }
}
