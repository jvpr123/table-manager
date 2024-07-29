<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MeetingGroupFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => uuid_create(),
            'name' => fake()->word(),
            'description' => fake()->words(asText: true),
        ];
    }
}
