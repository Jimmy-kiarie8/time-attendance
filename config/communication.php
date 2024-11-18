<?php

return [
    'sms' => [
        'provider' => env('SMS_PROVIDER', 'AfricasTalking'),
        'africa_talking' => [
            'api_key' => env('AFRICA_TALKING_API_KEY'),
            'username' => env('AFRICA_TALKING_USERNAME'),
        ],
        'advanta' => [
            'api_key' => env('ADVANTA_API_KEY'),
        ],
    ],
    'email' => [
        'provider' => env('EMAIL_PROVIDER', 'Zoho'),
        'zoho' => [
            'username' => env('ZOHO_USERNAME'),
            'password' => env('ZOHO_PASSWORD'),
        ],
        'gsuite' => [
            'client_id' => env('GSUITE_CLIENT_ID'),
            'client_secret' => env('GSUITE_CLIENT_SECRET'),
        ],
        'microsoft' => [
            'client_id' => env('MICROSOFT_CLIENT_ID'),
            'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
        ],
        'imap_pop' => [
            'host' => env('IMAP_POP_HOST'),
            'port' => env('IMAP_POP_PORT'),
            'username' => env('IMAP_POP_USERNAME'),
            'password' => env('IMAP_POP_PASSWORD'),
            'encryption' => env('IMAP_POP_ENCRYPTION', 'ssl'),
        ],
    ],
];
