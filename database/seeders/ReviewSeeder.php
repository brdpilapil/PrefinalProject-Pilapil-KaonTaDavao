<?php

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $tita = User::where('email', 'tita.pilapil@kaonta.test')->firstOrFail();
        $benz = User::where('email', 'pilapil@kaonta.test')->firstOrFail();
        $allUserIds = User::pluck('id');

        $myEatery = Eatery::where('slug', 'carinderia-ni-pilapil')->firstOrFail();

        $myEatery->reviews()->create([
            'user_id' => $tita->id,
            'rating' => 5,
            'body' => 'Lami kaayo! Balik-balikan ni Tita Pilapil.',
        ]);

        $myEatery->reviews()->create([
            'user_id' => $benz->id,
            'rating' => 5,
            'body' => 'Hot tinola right on San Pedro St. Very affordable and generous servings.',
        ]);

        Review::factory()->create([
            'eatery_id' => $myEatery->id,
            'user_id' => $allUserIds->random(),
            'rating' => 4,
        ]);

        // Open factory eateries get 0-6 reviews; closed eateries get none
        $openFactoryEateries = Eatery::where('id', '!=', $myEatery->id)
            ->where('is_open', true)
            ->get();

        foreach ($openFactoryEateries as $eatery) {
            $count = rand(0, 6);
            for ($i = 0; $i < $count; $i++) {
                Review::factory()->create([
                    'eatery_id' => $eatery->id,
                    'user_id' => $allUserIds->random(),
                ]);
            }
        }
    }
}