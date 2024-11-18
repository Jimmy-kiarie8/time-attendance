<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use Illuminate\Notifications\Notification;

class SendSmsNotification extends Notification
{
    public $message;

    // Constructor to pass the message
    public function __construct($message)
    {
        $this->message = $message;
    }

    // Determine which channel to send the notification on
    public function via($notifiable)
    {
        return [SmsChannel::class];  // Use your custom SmsChannel
    }

    // Format the SMS message for the channel
    public function toSms($notifiable)
    {
        return $this->message;  // Return the message to send
    }
}
