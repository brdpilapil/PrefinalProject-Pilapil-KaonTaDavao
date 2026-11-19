<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    public function run(): void
    {
        $poblacion = District::where('name', 'Poblacion')->firstOrFail();
        $myName = 'Carinderia ni Pilapil';

        $myEatery = Eatery::create([
            'district_id' => $poblacion->id,
            'name' => $myName,
            'slug' => Str::slug($myName),
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        $featureIds = Feature::whereIn('name', ['Suki ni Pilapil', 'Budget Meal'])->pluck('id');
        $myEatery->features()->sync($featureIds);

        $myEatery->permit()->create([
            'permit_no' => 'DVO-2026-0923',
            'expires_on' => '2027-09-23',
        ]);

        $myEatery->dishes()->createMany([
            ['name' => 'Tinolang Manok', 'price' => 85.00, 'is_bestseller' => true],
            ['name' => 'Kinilaw na Tuna', 'price' => 120.00, 'is_bestseller' => false],
            ['name' => 'Durian Shake', 'price' => 75.00, 'is_bestseller' => false],
        ]);

        $districtIds = District::pluck('id');
        $allFeatureIds = Feature::pluck('id');

        // 11 open factory eateries + 3 closed factory eateries = 14 factory eateries
        $openFactoryEateries = Eatery::factory()->count(11)->create([
            'district_id' => fn () => $districtIds->random(),
        ]);

        $closedFactoryEateries = Eatery::factory()->closed()->count(3)->create([
            'district_id' => fn () => $districtIds->random(),
        ]);

        $factoryEateries = $openFactoryEateries->concat($closedFactoryEateries);

        foreach ($factoryEateries as $index => $eatery) {
            // Guarantee at least one factory eatery has an expired permit
            $permitData = $index === 0
                ? Permit::factory()->expired()->make()->toArray()
                : Permit::factory()->make()->toArray();

            $eatery->permit()->create($permitData);

            Dish::factory()->count(rand(2, 5))->create([
                'eatery_id' => $eatery->id,
            ]);

            $eatery->features()->attach(
                $allFeatureIds->random(rand(1, 3))->all()
            );
        }
    }
}