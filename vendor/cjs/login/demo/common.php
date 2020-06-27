<?php

header("Content-type: text/html; charset=utf-8");
//时区设置
date_default_timezone_set('Asia/Shanghai');
$vendorFile = dirname(__DIR__)  .  '/vendor/autoload.php';
if(file_exists($vendorFile)) {
    require $vendorFile;
} else {
    require_once dirname(__DIR__)  . '/src/Helpers.php';
    spl_autoload_register(function ($class) {
        $ns = 'CjsLogin';
        $base_dir = dirname(__DIR__) . '/src';
        $prefix_len = strlen($ns);
        if (substr($class, 0, $prefix_len) !== $ns) {
            return;
        }
        $class = substr($class, $prefix_len);
        $file = $base_dir .str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        if (is_readable($file)) {
            require $file;
        }

    });
}