<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EateryFactory extends Factory
{
    public function definition(): array
    {
        $prefixes = ['Carinderia ni', 'Kainan sa', 'Lutong Bahay ni', 'Turo-Turo sa', 'Kusina ni'];
        $name = fake()->randomElement($prefixes) . ' ' . fake()->unique()->firstName();

        return [
            'district_id' => District::inRandomOrder()->value('id') ?? 1,
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => fake()->streetAddress() . ', Davao City',
            'price_range' => fake()->randomElement(['budget', 'mid', 'splurge']),
            'specialty' => fake()->randomElement([
                'Sinuglaw', 'Balbacua', 'Bulalo', 'Kinilaw na Malasugui',
                'Paksiw na Bangus', 'Beef Hinalang', 'Chicken Inasal', null,
            ]),
            'is_open' => true,
        ];
    }

    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_open' => false,
        ]);
    }
}