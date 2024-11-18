// app/Contracts/EmailServiceInterface.php
<?php

namespace App\Contracts;

interface EmailServiceInterface
{
    public function send(string $to, string $subject, string $body, array $attachments = []): bool;
}
