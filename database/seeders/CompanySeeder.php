<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        Company::create([
            "name" => $faker->company(),
            "logo" => $faker->imageUrl,
            "email" => $faker->email,
            "website" => 'logixsaas.com',
            "phone" => $faker->phoneNumber,
            "address" => $faker->address
       ]);
    }
}
