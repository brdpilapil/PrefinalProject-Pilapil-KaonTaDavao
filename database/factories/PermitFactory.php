<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PermitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'permit_no' => 'DVO-' . fake()->numberBetween(2025, 2026) . '-' . fake()->unique()->numerify('#####'),
            'expires_on' => fake()->dateTimeBetween('+1 month', '+2 years')->format('Y-m-d'),
        ];
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'expires_on' => fake()->dateTimeBetween('-1 year', '-1 week')->format('Y-m-d'),
        ]);
    }
}