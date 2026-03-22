<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Finvalda API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL of your Finvalda web service. Use V2 (FvsServicePure) for
    | clean REST JSON/XML responses.
    |
    | Example: https://your-server.com/FvsServicePure.svc
    |
    */
    'base_url' => env('FINVALDA_BASE_URL', ''),

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    |
    | Finvalda employee credentials used for API authentication.
    |
    */
    'username' => env('FINVALDA_USERNAME', ''),
    'password' => env('FINVALDA_PASSWORD', ''),

    /*
    |--------------------------------------------------------------------------
    | Connection String
    |--------------------------------------------------------------------------
    |
    | Database connection string. Required for some server configurations.
    |
    */
    'conn_string' => env('FINVALDA_CONN_STRING'),

    /*
    |--------------------------------------------------------------------------
    | Company ID
    |--------------------------------------------------------------------------
    |
    | Used when the service handles multiple databases. Identifies which
    | company database to connect to.
    |
    */
    'company_id' => env('FINVALDA_COMPANY_ID'),

    /*
    |--------------------------------------------------------------------------
    | Language
    |--------------------------------------------------------------------------
    |
    | Response language: 0 = Lithuanian, 1 = English
    |
    */
    'language' => (int) env('FINVALDA_LANGUAGE', 0),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | HTTP request timeout in seconds.
    |
    */
    'timeout' => (int) env('FINVALDA_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Response Filtering
    |--------------------------------------------------------------------------
    |
    | Options to reduce response payload size.
    |
    */
    'remove_empty_string_tags' => (bool) env('FINVALDA_REMOVE_EMPTY_STRINGS', false),
    'remove_zero_number_tags' => (bool) env('FINVALDA_REMOVE_ZERO_NUMBERS', false),
    'remove_new_lines' => (bool) env('FINVALDA_REMOVE_NEW_LINES', false),

];
