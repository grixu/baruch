<?php

namespace Domain\Auth\Factories;

use Domain\Auth\Models\Congregation;
use Illuminate\Database\Eloquent\Factories\Factory;

class CongregationFactory extends Factory
{
    protected $model = Congregation::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
