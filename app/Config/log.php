<?php
return [
    'prefix' => env('LOG_DIR', App::storagePath('logs')) . '/accesstoken-service/accesstoken-service.log',
    'level'  =>  env('LOG_LEVEL', 'debug'),
    'name'   => env('APP_ENV', 'prod'),
    'channel'=>'accesstoken-service',
];
