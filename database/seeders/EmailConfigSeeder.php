<?php

namespace Database\Seeders;

use App\Models\EmailConfig;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmailConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // $faker = Faker::create();

        EmailConfig::create([
            'name' => "Mailtrap",
            'provider' => 'mailtrap',
            'host' => 'sandbox.smtp.mailtrap.io',
            'port' => 2525,
            'username' => "f54999c530360b",
            'password' => "694e5ffccd6bea",
            'encryption' => 'tls',
            'from_address' => "hello@example.com",
            'from_name' => "Loan-app",
            'additional_settings' => null,
            'is_default' => true,
       ]);
    }
}
