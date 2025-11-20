<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Cache Driver
    |--------------------------------------------------------------------------
    |
    | Supported: "swoole_table", "redis", "file"
    |
    */

    'default' => env('CACHE_DRIVER', 'swoole_table'),

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    */

    'stores' => [
        'swoole_table' => [
            'driver' => 'swoole_table',
            'size' => env('CACHE_SIZE', 1024),         // Number of rows
            'value_size' => env('CACHE_VALUE_SIZE', 4096), // Max value size in bytes
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'host' => env('REDIS_HOST', 'localhost'),
            'port' => env('REDIS_PORT', 6379),
            'password' => env('REDIS_PASSWORD', null),
            'database' => env('REDIS_CACHE_DB', 1),
        ],

        'file' => [
            'driver' => 'file',
            'path' => env('CACHE_PATH', 'storage/cache'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    */

    'prefix' => env('CACHE_PREFIX', 'alphavel_cache'),

    /*
    |--------------------------------------------------------------------------
    | Cache TTL (Time To Live)
    |--------------------------------------------------------------------------
    |
    | Default cache lifetime in seconds
    |
    */

    'ttl' => env('CACHE_TTL', 3600), // 1 hour
];
