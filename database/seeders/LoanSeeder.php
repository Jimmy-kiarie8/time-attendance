<?php

namespace Database\Seeders;

use App\Models\Loan;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LoanSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            Loan::create([
                'id_no' => $faker->randomNumber(8),
                'client_id' => $faker->numberBetween(1, 10),
                'officer_id' => $faker->numberBetween(1, 5),
                'branch_id' => $faker->numberBetween(1, 2),
                'loan_type_id' => $faker->numberBetween(1, 5),
                'min_amount' => $faker->randomFloat(2, 1000, 5000),
                'max_amount' => $faker->randomFloat(2, 5000, 50000),
                'application_date' => $faker->dateTimeBetween('2024-01-01', '2024-10-31'),
                'interest_type' => $faker->randomElement(['AFTER', 'BEFORE']),
                'frequency' => $faker->randomElement(['Daily', 'Weekly', 'Bi-weekly', 'Monthly', 'Yearly']),
                'amount' => $faker->randomFloat(2, 1000, 100000),
                'installments' => $faker->numberBetween(6, 36),
                'disbursement' => $faker->randomFloat(2, 1000, 100000),
                'processing_fee' => $faker->randomFloat(2, 100, 1000),
                'processing_fee_status' => $faker->randomElement(['PAID', 'UNPAID']),
                'lgf_required' => $faker->boolean(),
                'lgf_paid' => $faker->boolean(),
                'payment_ref' => $faker->uuid(),
                'interest' => $faker->numberBetween(1000, 100000),
                'disbursement_fee' => $faker->randomFloat(2, 100, 1000),
                'processing_fee_paid' => $faker->boolean(),
                'remarks' => $faker->sentence(),
                'stage' => $faker->numberBetween(1, 5),
                'status' => $faker->randomElement(['Pending', 'Approved', 'Rejected', 'Disbursed', "Paid", "Written Off", "Over paid"]),
                'balance' => $faker->randomFloat(2, 1000, 50000),
                'due_date' => $faker->dateTimeBetween('2024-01-01', '2024-12-31'),
                'payment_per_installment' => $faker->randomFloat(2, 100, 5000),
                'disbursed_at' => $faker->dateTimeBetween('2024-01-01', '2024-10-31 08:20'),
                'approved_at' => $faker->dateTimeBetween('2024-01-01', '2024-10-31 08:20'),
                'last_payment' => $faker->dateTimeBetween('2024-07-01', '2024-10-31'),
                'maturity_date' => $faker->dateTimeBetween('2024-11-10', '2025-10-31'),
                'rejected_at' => $faker->optional()->dateTimeBetween('2024-01-01', '2024-10-31 08:20'),
                'last_payment' => $faker->optional()->dateTimeBetween('2024-01-01', '2024-10-31 08:20'),
            ]);
        }
    }
}
