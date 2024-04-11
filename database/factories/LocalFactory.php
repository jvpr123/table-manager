<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Local>
 */
class LocalFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => uuid_create(),
            'title' => fake()->streetName(),
            'description' => fake()->streetAddress(),
        ];
    }
}
