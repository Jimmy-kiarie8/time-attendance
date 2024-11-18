<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait OpenAiTrait
{
    public function openAiMessage($question)
    {
        $url = 'https://jim-chatbot.jimlaravel.repl.co/post-question?question=' . urlencode($question);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->post($url);

        // return $response;

        // Decode the JSON response
        $responseBody = $response->json();

        // Extract the 'response' element
        $message = $responseBody['response'] ?? 'No response received';

        return $message;
    }
}
