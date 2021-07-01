<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'midtrans' => [
        // Midtrans server key
        'serverKey'     => env('MIDTRANS_SERVERKEY'),
        // Midtrans client key
        'clientKey'     => env('MIDTRANS_CLIENTKEY'),
        // Isi false jika masih tahap development dan true jika sudah di production, default false (development)
        'isProduction'  => env('MIDTRANS_IS_PRODUCTION', false),
        'isSanitized'   => env('MIDTRANS_IS_SANITIZED', true),
        'is3ds'         => env('MIDTRANS_IS_3DS', true),                
    ],
    'facebook' => [
        'client_id'     => env('FB_ID'),
        'client_secret' => env('FB_SECRET'),
        'redirect'      => env('FB_URL'),
    ],
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT_CALLBACK'),
    ],
    'linkedin' => [
        'client_id'     => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect'      => env('LINKEDIN_REDIRECT_CALLBACK'),
    ],
];
