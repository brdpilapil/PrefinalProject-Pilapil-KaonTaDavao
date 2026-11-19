<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DishFactory extends Factory
{
    public function definition(): array
    {
        $dishes = [
            'Tinolang Manok', 'Sinigang na Baboy', 'Pork Adobo', 'Beef Caldereta',
            'Pinakbet', 'Bicol Express', 'Lechon Kawali', 'Pancit Canton',
            'Kare-Kare', 'Ginataang Langka', 'Daing na Bangus', 'Halo-Halo',
        ];

        return [
            'name' => fake()->randomElement($dishes),
            'price' => fake()->randomFloat(2, 45, 280),
            'is_bestseller' => fake()->boolean(30),
        ];
    }
}