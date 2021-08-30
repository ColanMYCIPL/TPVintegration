<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        'aws_bucket_name' => env('AWS_BUCKET'),
    ],
    'twilio' => [
     'sid' => env('TWILIO_ACCOUNT_SID'),
     'token' => env('TWILIO_AUTH_TOKEN'),
     'key' => env('TWILIO_API_KEY'),
     'secret' => env('TWILIO_API_SECRET'),
     'syncsid' => env('TWILIO_SYNC_SERVICE_SID')
  ],

];
