<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for these credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | UniSMS Gateway
    |--------------------------------------------------------------------------
    |
    | Keep the secret key in .env and never expose it publicly.
    | SMS sending is disabled by default until the UniSMS account is configured.
    |
    */

    'unisms' => [
        'secret_key' => env('UNISMS_SECRET_KEY'),
        'sender_id' => env('UNISMS_SENDER_ID'),
        'enabled' => env('UNISMS_SMS_ENABLED', false),
        'base_url' => env(
            'UNISMS_BASE_URL',
            'https://unismsapi.com/api'
        ),
    ],

];
