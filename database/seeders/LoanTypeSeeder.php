<?php

namespace Database\Seeders;

use App\Models\LoanType;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LoanTypeSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            LoanType::create([
                "name" => $faker->word,
                "interest_rate" => $faker->numberBetween(1, 8),
                "active" => $faker->boolean(),
                "minimum" => $faker->numberBetween(1000, 10000),
                "maximum" =>  $faker->numberBetween(1000000, 10000000),
                "grace_days" => $faker->numberBetween(5, 10),
                "processing_fee" => $faker->numberBetween(100, 800),
                "registration_fee" => $faker->numberBetween(100, 800),
                "period" => $faker->numberBetween(1, 8),
                "loan_type" => $faker->word,
                'penalty_base' => $faker->randomElement(['Fixed', 'Percentage', 'Daily fixed', 'Daily percentage', 'Compounded']),
                "late_fee" => $faker->numberBetween(1, 10),
                "given_to" => $faker->word,
                "interest_account" => $faker->word
            ]);
        }
    }
}
