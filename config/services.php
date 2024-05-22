<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'github' => [
        'client_id' => '24fbd0edd46019058da7', //Github API
        'client_secret' => '4500e6ab7a9bb70608600fbdee37969276bb0685', //Github Secret
        'redirect' => 'http://localhost:8000/login/github/callback',
     ],
     'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'), //Google API
        'client_secret' => env('GOOGLE_CLIENT_SECRET'), //Google Secret
        'redirect' => env('GOOGLE_REDIRECT_URL'), // Redirect URL
    ],

    //  'google' => [
    //     'client_id' => '767464693989-mqb1d1g3ka8cjhmkai42sephans0aqqt.apps.googleusercontent.com', //Google API
    //     'client_secret' => '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', //Google Secret
    //     'redirect' => 'https://cococareph.store/login/google/callback',
    //  ],


     'facebook' => [
        'client_id' => env('FACEBOOK_APP_ID'),
                    'client_secret' => env('FACEBOOK_APP_SECRET'),
                    'redirect_uri' => env('FACEBOOK_REDIRECT_URI'),
        // 'client_id' => '1765623050514944        ', //Facebook API
        // 'client_secret' => 'b28ce6bb62c2d33e44acba786e4bb49a', //Facebook Secret
        // 'redirect' => 'https://cococareph.store/login/facebook/callback',
     ],

];
