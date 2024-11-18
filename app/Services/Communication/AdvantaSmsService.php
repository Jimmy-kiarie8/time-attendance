<?php

namespace App\Services\Sms;

use App\Contracts\SmsServiceInterface;

class AdvantaSmsService implements SmsServiceInterface
{
    public function send(string $to, string $message): bool
    {
        // Implement Advanta SMS sending logic
        // Return true if successful, false otherwise
        return true;
    }
}
