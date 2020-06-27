<?php
return array(
    'common'       => [
        'host'     => env('COMMON_REDIS_HOST','127.0.0.1'),
        'port'     => env('COMMON_REDIS_PORT', 6379),
        'database' => env('COMMON_REDIS_DATABASE', 0),
        'password' => env('COMMON_REDIS_PASSWORD', ''),
        'prefix'   => 'access_token:common:',
        'desc'     => '无法归类的业务模块'
    ],
    'access_token'   => [
        'host'     => env('ACCESSTOKEN_REDIS_HOST','127.0.0.1'),
        'port'     => env('ACCESSTOKEN_REDIS_PORT', 6379),
        'database' => env('ACCESSTOKEN_REDIS_DATABASE', 9),
        'password' => env('ACCESSTOKEN_REDIS_PASSWORD', ''),
        'prefix'   => 'access_token:info:',
        'desc'     => '存放访问令牌'
    ]
);
