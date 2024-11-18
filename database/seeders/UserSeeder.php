<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
     {
         $faker = Faker::create();

         User::create([
            'name' => 'Jimmy',
            'email' => 'jimlaravel@gmail.com',
            'phone' => $faker->phoneNumber,
            'company_id' => 1,
            'password' => Hash::make('password')
        ]);

         // Generate multiple fake agent records
        //  for ($i = 0; $i < 10; $i++) {
        //      User::create([
        //          'name' => $faker->name,
        //          'email' => $faker->unique()->safeEmail,
        //          'phone' => $faker->phoneNumber,
        //          'password' => Hash::make('password')
        //      ]);
        //  }
     }
}
