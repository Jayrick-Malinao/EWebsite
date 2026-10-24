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
    | PhilSMS SMS Gateway
    |--------------------------------------------------------------------------
    |
    | Used to send SMS announcements through the PhilSMS API.
    | Keep the API token in .env and never expose it publicly.
    | SMS sending is disabled by default for safety.
    |
    */

    'philsms' => [
        'api_token' => env('PHILSMS_API_TOKEN'),
        'sender_id' => env('PHILSMS_SENDER_ID'),
        'enabled' => env('PHILSMS_SMS_ENABLED', false),
        'base_url' => env(
            'PHILSMS_BASE_URL',
            'https://app.philsms.com/api/v3'
        ),
    ],

];
