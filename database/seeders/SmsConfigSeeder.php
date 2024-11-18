<?php

namespace Database\Seeders;

use App\Models\SmsConfig;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SmsConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SmsConfig::create([
            'name' => "Sms",
            'provider' => 'advanta',
            'api_key' => null,
            'username' => null,
            'sender_id' => null,
            'additional_settings' => null,
            'is_default' => true
       ]);
    }
}
