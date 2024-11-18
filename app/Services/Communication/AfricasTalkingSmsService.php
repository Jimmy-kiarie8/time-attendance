<?php

namespace App\Services\Communication;

use App\Contracts\SmsServiceInterface;

class AfricasTalkingSmsService implements SmsServiceInterface
{
    public function send(string $to, string $message): bool
    {
        // Implement Africa's Talking SMS sending logic
        // Return true if successful, false otherwise
        return true;
    }
}
