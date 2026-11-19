<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Benz Pilapil',
            'email' => 'pilapil@kaonta.test',
            'password' => Hash::make('kaonta2026'),
        ]);

        User::create([
            'name' => 'Tita Pilapil',
            'email' => 'tita.pilapil@kaonta.test',
            'password' => Hash::make('kaonta2026'),
        ]);

        User::factory()->count(10)->create([
            'password' => Hash::make('kaonta2026'),
        ]);
    }
}