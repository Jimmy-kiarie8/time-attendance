<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            Payment::create([
                'client_id' => $faker->numberBetween(1, 10),
                'branch_id' => $faker->numberBetween(1, 2),
                'loan_id' => $faker->numberBetween(1, 100),
                'repayment_amount' => $faker->randomFloat(2, 100, 10000),
                'method' => $faker->randomElement(['PAYBILL', 'CASH', 'BANK']),
                'date' => $faker->dateTimeBetween('2024-01-01', '2024-10-31'),
                'officer_id' => $faker->numberBetween(1, 50),
                'payment_code' => $faker->uuid(),
            ]);
        }
    }
}
