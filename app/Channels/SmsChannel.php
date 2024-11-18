<?php

namespace App\Channels;

use AfricasTalking\SDK\AfricasTalking;
use App\Models\SmsLog;
use Exception;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
        $phone = ['+254743895505'];

        // dd($message);
        // $phone = $notifiable->phone;

        // Add your Africastalking SMS sending logic here
        $username = env('AFRICASTALKING_USERNAME'); // use 'sandbox' for development in the test environment
        $apiKey = env('AFRICASTALKING_API_KEY'); // use your sandbox app API key for development in the test environment

        try {
            $AT = new AfricasTalking($username, $apiKey);
            $sms = $AT->sms();
            $result = $sms->send([
                'enqueue' => true,
                // 'username' => $username,
                'to' => $phone,
                'message' => $message
            ]);

            // Store SMS log in the database
            // SmsLog::create([
            //     'user_id' => 1,
            //     'phone' => $phone,
            //     'message' => $message,
            //     'result' => json_encode($result), // store the result as JSON
            //     'error' => null,
            // ]);

            return $result;
        } catch (Exception $e) {
            // Store error log in the database
            // SmsLog::create([
            //     'user_id' => 1,
            //     'phone' => $phone,
            //     'message' => $message,
            //     'result' => null,
            //     'error' => $e->getMessage(),
            // ]);

            // Optional: rethrow the exception if you want to propagate it
            throw $e;
        }
    }
}
