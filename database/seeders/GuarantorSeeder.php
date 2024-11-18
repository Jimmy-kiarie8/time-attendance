<?php

namespace Database\Seeders;

use App\Models\Guarantor;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GuarantorSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Guarantor::create([
                'officer_id' => $faker->numberBetween(1, 10),
                'branch_id' => $faker->numberBetween(1, 2),
                'name' => $faker->name,
                'id_no' => $faker->randomNumber(8),
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'pobox' => $faker->postcode,
                'town' => $faker->city,
                // 'education' => $faker->randomElement(['Primary', 'Secondary', 'Tertiary']),
                'dob' => $faker->dateTimeBetween('2024-01-01', '2024-10-31'),
                'gender' => $faker->randomElement(['male', 'female']),
                'marital_status' => $faker->randomElement(['single', 'married']),
                // 'children' => $faker->numberBetween(0, 5),
                'present_residence' => $faker->address,
                'business_address' => $faker->address,
                'working_status' => $faker->randomElement(['employed', 'self-employed']),
                'category' => $faker->randomElement(['low', 'middle', 'high']),
                'net_income' => $faker->randomFloat(2, 1000, 10000),
                'monthly_income' => $faker->randomFloat(2, 500, 5000),
                'monthly_expenses' => $faker->randomFloat(2, 300, 3000),
                'household_expenses' => $faker->randomFloat(2, 200, 2000),
                'client_id' => $faker->numberBetween(1, 10),
                'spouse' => $faker->name,
            ]);
        }
    }
}
